<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $main = 'Penjualan';
        $sub = 'Penjualan Home';
        $title = 'Penjualan';
        $subtitle = 'Index';
        $penjualans = Penjualan::join('users', 'penjualans.UsersId', '=', 'users.id')
            ->Leftjoin('bayars', 'penjualans.id', '=', 'bayars.PenjualanId')
            ->select('penjualans.*', 'users.name','bayars.StatusBayar')->get();
        return view('admin.penjualan.index', compact('penjualans', 'title', 'subtitle', 'main', 'sub'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Penjualan';
        $subtitle = 'Create';
        $produks = Produk::where('Stok', '>', 0)->get();
        return view('admin.penjualan.create', compact('title', 'subtitle', 'produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
        $title = 'Penjualan';
        $subtitle = 'Bayar Cash';
        $penjualan = Penjualan::find($id);
        $detailpenjualan = DetailPenjualan::join('produks', 'detail_penjualans.ProdukId', '=', 'produks.id')
            ->where('PenjualanId', $id)->get();
        return view('admin.penjualan.bayarCash', compact('title', 'subtitle', 'penjualan', 'detailpenjualan'));
    }

    public function bayarCashStore(Request $request)
    {
        $validate = $request->validate([
            'JumlahBayar' => 'required',
        ]);
    
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();
    
            Bayar::create([
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
                if ($produk) {
                    $produk->Stok -= $detail->JumlahProduk;
                    $produk->Users_id = Auth::user()->id;
                    $produk->save();
                }
            }
    
            \Illuminate\Support\Facades\DB::commit();
    
            return response()->json(['status' => 200, 'message' => 'Pembayaran Berhasil']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
    
            return response()->json(['status' => 500, 'message' => 'Pembayaran Gagal: ' . $e->getMessage()]);
        }
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
        return view('admin.penjualan.nota', compact('penjualan', 'detailpenjualan', 'totalBayar', 'kembalian'));
    }

    public function datatable()
    {
        $penjualans = Penjualan::join('users', 'penjualans.UsersId', '=', 'users.id')
            ->join('detail_penjualans', 'penjualans.id', '=', 'detail_penjualans.PenjualanId')
            ->join('produks', 'detail_penjualans.ProdukId', '=', 'produks.id')
            ->select(
                'penjualans.id',
                'penjualans.TanggalPenjualan',
                'produks.NamaProduk as Produk',
                'penjualans.TotalHarga',
                'users.name as UsersId'
            )
            ->get();
    
        return DataTables::of($penjualans)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $bayarButton = '<a href="' . route('penjualan.bayarCash', $row->id) . '" class="btn btn-sm btn-success">Bayar</a>';
                $notaButton = '<a href="' . route('penjualan.nota', $row->id) . '" class="btn btn-sm btn-primary">Nota</a>';
                return $bayarButton . ' ' . $notaButton;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

   
}