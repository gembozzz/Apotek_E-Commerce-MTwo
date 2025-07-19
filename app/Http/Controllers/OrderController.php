<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.v_pesanan.proses', [
            'judul' => 'Pesanan',
            'subJudul' => 'Pesanan Proses',
        ]);
    }

    public function addToCart(Request $request, $id)
    {
        $customer = User::where('id', Auth::id())->first();
        $produk = Product::findOrFail($id);

        // Cek apakah stok mencukupi
        if ($produk->stok_barang <= 0) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
        }

        $order = Order::firstOrCreate(
            ['user_id' => $customer->id, 'status' => 'pending'],
        );

        $orderItem = OrderItem::firstOrCreate(
            ['order_id' => $order->id, 'produk_id' => $produk->id_barang],
            ['quantity' => 1, 'harga' => $produk->hrgjual_barang]
        );

        if (!$orderItem->wasRecentlyCreated) {
            // Cek apakah stok mencukupi untuk ditambah lagi
            if ($produk->stok_barang < 1) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
            }

            $orderItem->quantity++;
            $orderItem->save();
        }

        // Update total harga
        $order->total_harga += $produk->hrgjual_barang;
        $order->save();

        // Cek parameter redirect
        if ($request->input('redirect') == '0') {
            // Kembali ke halaman sebelumnya (tidak pindah)
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
        } else {
            // Redirect ke halaman keranjang
            return redirect()->route('order.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang');
        }
    }



    public function viewCart()
    {
        $jarak = 12;
        $customer = User::where('id', Auth::id())->first();
        $order = Order::where('user_id', $customer->id)->where('status', ['pending', 'paid'])->first();
        if ($order) {
            $order->load('orderItems.produk');
        }
        return view('frontend.v_order.cart', compact('order', 'jarak'));
    }



    public function removeFromCart(Request $request, $id)
    {
        $customer = User::where('id', Auth::id())->first();
        $order = Order::where('user_id', $customer->id)->where('status', 'pending')->first();
        if ($order) {
            $orderItem = OrderItem::where('order_id', $order->id)->where('produk_id', $id)->first();
            if ($orderItem) {
                $order->total_harga -= $orderItem->harga * $orderItem->quantity;
                $orderItem->delete();

                if ($order->total_harga <= 0) {
                    $order->delete();
                } else {
                    $order->save();
                }
            }
        }
        return redirect()->route('order.cart')->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function updateCart(Request $request, $id)
    {
        $customer = User::where('id', Auth::id())->first();

        $order = Order::where('user_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return redirect()->route('order.cart')->with('error', 'Order tidak ditemukan');
        }

        $orderItem = $order->orderItems()->where('id', $id)->first();

        if (!$orderItem) {
            return redirect()->route('order.cart')->with('error', 'Item tidak ditemukan di keranjang');
        }

        $orderItem->load('produk');

        $stok = $orderItem->produk->stok_barang ?? 0;

        $quantity = (int) $request->input('quantity');

        // Cek manual apakah quantity melebihi stok
        if ($quantity > $stok) {
            return redirect()->route('order.cart')->with('error', 'Jumlah produk melebihi stok yang tersedia');
        }

        // Validasi input quantity min 1
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        // Update total harga
        $order->total_harga -= $orderItem->harga * $orderItem->quantity;

        $orderItem->quantity = $quantity;
        $orderItem->save();

        $order->total_harga += $orderItem->harga * $orderItem->quantity;
        $order->save();

        return redirect()->route('order.cart')->with('success', 'Keranjang berhasil diperbarui');
    }


    public function selectShipping(Request $request)
    {

        $customer = User::where('id', Auth::id())->first();
        $order = Order::where('user_id', $customer->id)->where('status', 'pending')->first();
        if (!$order || $order->orderItems->count() == 0) {
            return redirect()->route('order.cart')->with('error', 'Keranjang belanja kosong.');
        }
        $jenisLayanan = $order->total_harga >= 50000 ? 'Instan' : 'Reguler';
        return view('frontend.v_order.shipping', compact('order', 'customer', 'jenisLayanan'));
    }

    public function selectPayment()
    {
        $customer = Auth::user();
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();


        $origin = session('origin');        // Kode kota asal
        $originName = session('originName'); // Nama kota asal

        if (!$order) {
            return redirect()->route('order.cart')->with('error', 'Keranjang belanja kosong.');
        }

        // Muat relasi orderItems dan produk terkait
        $order->load('orderItems.produk');

        // Hitung total harga produk
        $totalHarga = 0;
        foreach ($order->orderItems as $item) {
            $totalHarga += $item->harga * $item->quantity;
        }

        // Tambahkan biaya ongkir ke total harga
        $grossAmount = $totalHarga + $order->biaya_ongkir;

        // Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Generate unique order_id
        $orderId = $order->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $grossAmount, // Pastikan gross_amount adalah integer
            ],
            'customer_details' => [
                'first_name' => $customer->nama,
                'email' => $customer->email,
                'phone' => $customer->hp,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('frontend.v_order.payment', [
            'order' => $order,
            'origin' => $origin,
            'originName' => $originName,
            'snapToken' => $snapToken,
        ]);
    }

    public function updateOngkir(Request $request)
    {
        $customer = User::where('id', Auth::id())->first();
        $order = Order::where('user_id', $customer->id)->where('status', 'pending')->first();


        if ($order) {
            $jenisLayanan = $order->total_harga >= 50000 ? 'Instan' : 'Reguler';
            $order->layanan_pengiriman = $jenisLayanan;
            $order->alamat = $request->input('alamat');
            $order->save();
            // Simpan ke session flash agar bisa diakses di halaman tujuan
            return redirect()->route('order.selectpayment');
        }

        return back()->with('error', 'Gagal menyimpan data ongkir');
    }

    public function orderHistory()
    {
        $customer = User::where('id', Auth::id())->first();;;
        // $orders = Order::where('customer_id', $customer->id)->where('status', 'completed')->get();
        $statuses = ['Paid', 'Kirim', 'Selesai'];
        $orders = Order::where('user_id', $customer->id)
            ->whereIn('status', $statuses)
            ->orderBy('id', 'desc')
            ->get();
        return view('frontend.v_order.history', compact('orders'));
    }

    public function invoiceFrontend($id)
    {
        $order = Order::findOrFail($id);
        return view('frontend.v_order.invoice', [
            'judul' => 'Pesanan',
            'subJudul' => 'Pesanan Proses',
            'judul' => 'Data Transaksi',
            'order' => $order,
        ]);
    }

    public function complete()
    {
        // Dapatkan customer yang login
        $customer = Auth::user();

        // Cari order dengan status 'pending' milik customer tersebut
        $order = Order::where('user_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        $today = date('Y-m-d');

        // Hitung jumlah order untuk hari ini
        $todayOrderCount = Order::whereDate('created_at', $today)->where('status', 'Paid')->count();

        // Tentukan nomor urut berikutnya
        $nextOrderNumber = $todayOrderCount + 1;

        // Buat invoice number
        $invoice = 'ORD-' . date('Ymd') . '-' . str_pad($nextOrderNumber, 4, '0', STR_PAD_LEFT);


        if ($order) {
            // Update status order menjadi 'Paid'

            // Tentukan layanan ongkir berdasarkan total_harga

            $order->status = 'Paid';
            $order->kode_pesanan = $invoice;
            $order->save();
        }

        // Redirect ke halaman riwayat dengan pesan sukses
        return redirect()->route('order.history')->with('success', 'Checkout berhasil');
    }

    public function callback(Request $request)
    {
        // dd($request->all());
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            $order = Order::find($request->order_id);
            if ($order) {
                $order->update(['status' => 'Paid']);
            }
        }
    }

    public function processOrder()
    {
        //backend 
        $order = Order::whereIn('status', ['Paid', 'Kirim'])->orderBy('id', 'desc')->get();
        return view('backend.order.process', [
            'index' => $order
        ]);
    }

    public function getProcessOrder(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with('user')
                ->whereIn('status', ['Paid', 'Kirim'])
                ->orderBy('id', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d H:i'))
                ->editColumn('total_harga', fn($row) => 'Rp ' . number_format($row->total_harga, 0, ',', '.'))
                ->addColumn('pelanggan', fn($row) => $row->user->name ?? '-')
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action</button>
                        <div class="dropdown-menu p-2">
                            <a href="' . route('pesanan.proses.detail', $row->id) . '" class="btn btn-primary btn-sm w-100 mb-1">
                                 Update Pesanan
                            </a>
                            <button onclick="batalkanPesanan(' . route('pesanan.batalkan', $row->id) . ')" class="btn btn-danger btn-sm w-100">
                                Batalkan Pesanan
                            </button>
                        </div>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function finishedOrders()
    {
        //backend 
        $order = Order::where('status', 'Selesai')->orderBy('id', 'desc')->get();
        return view('backend.order.finished', [
            'judul' => 'Pesanan',
            'subJudul' => 'Pesanan Selesai',
            'judul' => 'Data Transaksi',
            'index' => $order
        ]);
    }

    public function getFinishedOrders(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with('user')
                ->where('status', 'Selesai')
                ->orderBy('id', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d H:i'))
                ->editColumn('total_harga', fn($row) => 'Rp ' . number_format($row->total_harga, 0, ',', '.'))
                ->addColumn('pelanggan', fn($row) => $row->user->name ?? '-')
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action</button>
                        <div class="dropdown-menu p-2">
                            <a href="' . route('pesanan.proses.detail', $row->id) . '" class="btn btn-primary btn-sm w-100 mb-1">
                                 Detail Pesanan
                            </a>
                        </div>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }


    public function statusDetail($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.order.show', [
            'judul' => 'Pesanan',
            'subJudul' => 'Pesanan Proses',
            'judul' => 'Data Transaksi',
            'order' => $order,
        ]);
    }

    public function statusUpdate(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|in:Paid,Kirim,Selesai', // sesuaikan dengan status valid
        ]);

        $order->update([
            'status' => $validatedData['status']
        ]);

        return redirect()->route('pesanan.proses')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function batalkan($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::with('orderItems.produk')->findOrFail($id);

            if (!in_array($order->status, ['Paid', 'Kirim'])) {
                return response()->json(['status' => false, 'message' => 'Pesanan tidak bisa dibatalkan.']);
            }

            // Kembalikan stok produk
            foreach ($order->orderItems as $item) {
                $produk = $item->produk;
                $produk->stok_barang += $item->quantity;
                $produk->save();
            }

            // Update status order
            $order->status = 'Dibatalkan';
            $order->save();

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Pesanan berhasil dibatalkan dan stok dikembalikan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
