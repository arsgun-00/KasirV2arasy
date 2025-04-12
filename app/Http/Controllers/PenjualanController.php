<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['main'] = 'Penjualan';
        $data['sub'] = 'Penjualan Home';
       
        return view('admin.penjualan.index', $data);
    }

    public function datatable()
    {
        $penjualans = Penjualan::join('users', 'penjualans.UsersId', '=', 'users.id')
            ->leftJoin('bayars', 'penjualans.id', '=', 'bayars.PenjualanId')
            ->select('penjualans.*', 'users.name as UserName', 'bayars.StatusBayar') // Gunakan alias 'UserName'
            ->get();
    
        return DataTables::of($penjualans)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $id = $row->id;
                if ($row->StatusBayar == 'Lunas') {
                    // Jika status bayar "Lunas", tampilkan tombol Nota
                    return '<a href="' . route('penjualan.nota', $id) . '" class="btn btn-success" target="_blank">Nota</a>';
                } else {
                    // Jika belum lunas, tampilkan dropdown untuk pembayaran
                    return '
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Bayar
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="' . route('penjualan.bayarCash', $id) . '">Cash</a></li>
                                <li><a class="dropdown-item" href="#">Transfer/Qris</a></li>
                            </ul>
                        </div>';
                }
            })
            ->rawColumns(['action']) // Memastikan kolom HTML tidak di-escape
            ->make(true);
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['main'] = 'Penjualan';
        $data['sub'] = 'Penjualan Create';
        $data['produks']= Produk::where('Stok', '>', 0)->get();
        return view('admin.penjualan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'ProdukId' => 'required',
            'JumlahProduk' => 'required',
        ]);
        $data_penjualan = [
            'TanggalPenjualan' => date('Y-m-d'),
            'UsersId' => Auth::user()->id,
            'TotalHarga' => $request->total,
        ];
        $simpanPenjualan = Penjualan::create($data_penjualan);
        foreach ($request->ProdukId as $key => $ProdukId){
            $simpanDetailPenjualan = DetailPenjualan::create([
                'PenjualanId' => $simpanPenjualan->id,
                'ProdukId' => $ProdukId,
                'harga' => $request->harga[$key],
                'JumlahProduk' => $request->JumlahProduk[$key],
                'SubTotal' => $request->TotalHarga[$key],
            ]);
        }

        return redirect()->route('penjualan.index')->with('success', 'Penjualan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(penjualan $penjualan)
    {
        //
    }

    public function bayarCash($id)
    {
        $data['main'] = 'Penjualan';
        $data['sub'] = 'Bayar Cash';
        
        $data['penjualan'] = Penjualan::find($id);
        $data['detailpenjualan'] = DetailPenjualan::join('produks', 'detail_penjualans.ProdukId', '=', 'produks.id')
        ->where('PenjualanId', $id)->get();
        return view('admin.penjualan.bayarCash', $data);
    }

    public function bayarCashStore(Request $request)
    {
       $validate = $request->validate([
           'JumlahBayar' => 'required',
       ]);

       $simpan = Bayar::create([
           'PenjualanId' => $request->id,
           'TanggalBayar' => date('Y-m-d H:i:s'),
           'TotalBayar' => $request->JumlahBayar,
           'Kembalian' => $request->Kembalian,
           'StatusBayar' => 'Lunas',
           'JenisBayar' => 'Cash',
       ]);

       $detailPenjualan = DetailPenjualan::where('PenjualanId', $request->id)->get();
       foreach ($detailPenjualan as $detail) {
           $produk = Produk::find($detail->ProdukId);
           if($produk){
               $produk->Stok -= $detail->JumlahProduk;
               $produk->Users_id() = Auth::user()->id;
               $produk->save();
           } 

       }
       return response()->json(['status' => 200, 'message' => 'Pembayaran Berhasil']);

    }

    public function Nota($id)
    {
        $penjualan = Penjualan::find($id);
        $detailpenjualan = DetailPenjualan::join('produks', 'detail_penjualans.ProdukId', '=', 'produks.id')
        ->where('PenjualanId', $id)->get();
        $bayar = Bayar::where('PenjualanId', $id)->get();
        $totalBayar = 0;
        $kembalian = 0;
        foreach ($bayar as $item) {
            $totalBayar = $item->TotalBayar;
            $kembalian = $item->Kembalian;
        }
        return view('admin.penjualan.nota', compact('penjualan', 'detailpenjualan', 'totalBayar','kembalian'));
    }

}
