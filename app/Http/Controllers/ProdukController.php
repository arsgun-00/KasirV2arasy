<?php

namespace App\Http\Controllers;

use App\Models\LogStok;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Milon\Barcode\Facades\DNS1DFacade;
use Milon\Barcode\Facades\DNS2DFacade;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['main'] = 'Produk';
        $data['sub'] = 'Produk Home';

        // Ambil semua data produk
        $data['produk'] = Produk::all();

        return view('admin.produk.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     */


    public function datatable()
    {
        // Menggunakan Eloquent untuk mengambil data produk
        $produk = Produk::query();

        return DataTables::of($produk)
            ->addIndexColumn() // Menambahkan kolom nomor urut
            ->addColumn('checkbox', function ($row) {
                // Menambahkan checkbox untuk setiap baris
                return '<div class="form-check">
                             <input class="form-check-input" type="checkbox" name="id_produk[]" value="' . $row->id . '" id="checkbox_' . $row->id . '">
                         </div>';
            })
            ->addColumn('action', function ($row) {
                $id = $row->id;

                // Tombol aksi: Detail, Edit, Hapus
                $data = '
                 <div class="d-flex flex-wrap gap-2">
                    
                     <a class="btn btn-sm btn-warning btn-icon edit-produk" data-id="' . $id . '" href="' . route('produk.edit', $id) . '">
                         <i class="fa fa-pencil"></i>
                     </a>
                     <form action="' . route('produk.destroy', $id) . '" method="POST" style="display:inline-block;">
                         ' . csrf_field() . '
                         ' . method_field('DELETE') . '
                         <button type="submit" class="btn btn-sm btn-danger btn-icon delete-produk" onclick="return confirm(\'Apakah Anda yakin ingin menghapus produk ini?\')">
                             <i class="fa fa-trash"></i>
                         </button>
                     </form>
                      <button type="button" class="btn btn-sm btn-info" id="btnTambahStok"
                    data-bs-toggle="modal" data-bs-target="#modalTambahStok"
                    data-id_produk="' . $id . '">
                    Tambah Stok
                </button>
                 </div>';

                return $data;
            })
            ->rawColumns(['checkbox', 'action']) // Memastikan kolom HTML tidak di-escape
            ->toJson();
    }

    public function create()
    {
        $data['main'] = 'Produk';
        $data['sub'] = 'Produk Create';
        return view('admin.produk.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'NamaProduk' => 'required',
            'Harga' => 'required|numeric',
            'Stok' => 'required|numeric',

        ]);
        $validate['Users_id'] = Auth::user()->id;
        $simpan = Produk::create($validate);
        if ($simpan) {
            return response()->json(['status' => 200, 'message' => 'Produk Berhasil Ditambahkan']);
        } else {
            return response()->json(['status' => 500, 'message' => 'Produk Gagal']);
        }
    }

    /**
     * Display the specified resource.
     */

     public function datatablesLog() {
        // Query untuk mengambil data log produk
        $query = LogStok::join('produks', 'log_stoks.ProdukId', '=', 'produks.id')
            ->join('users', 'log_stoks.UsersId', '=', 'users.id')
            ->select(
                'log_stoks.JumlahProduk',
                'log_stoks.created_at',
                'produks.NamaProduk',
                'users.name'
            );

        // Kirim data ke DataTables
        return DataTables::of($query)
        ->addIndexColumn()
        ->editColumn('created_at', function ($row) {
            return $row->created_at->format('d F Y'); // Format: "12 November 2024"
        })
            ->make(true);
     }
    public function show(Produk $produk)
    {
        //public fu
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['main'] = 'Produk Edit';
        $data['sub'] = 'Edit';
    
        $data['produk'] = Produk::find($id);

        return view('admin.produk.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $validate = $request->validate([
            'NamaProduk' => 'required',
            'Harga' => 'required|numeric',
            'Stok' => 'required|numeric',
        ]);
        $validate['Users_id'] = Auth::user()->id;
        $simpan = $produk->update($validate);
        if ($simpan) {
            return response()->json(['status' => 200, 'message' => 'Produk Berhasil Diubah']);
        } else {
            return response()->json(['status' => 500, 'message' => 'Produk Gagal']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $delete = $produk->delete();
        if ($delete) {
            return redirect(route('produk.index'))->with('success', 'Produk Berhasil Dihapus');
        } else {
            return redirect(route('produk.index'))->with('error', 'Produk Gagal Dihapus');
        }
    }

    public function tambahStok(Request $request, $id)
    {
        $validate = $request->validate([
            'Stok' => 'required|numeric',
        ]);
        $produk = Produk::find($id);
        $produk->Stok += $validate['Stok'];
        $update = $produk->save();
        if ($update) {
            return response()->json(['status' => 200, 'message' => 'Stok Berhasil Ditambahkan']);
        } else {
            return response()->json(['status' => 500, 'message' => 'Stok Gagal Ditambahkan']);
        }
    }

    public function logproduk()
    {
        // Menggunakan array $data untuk menyimpan nilai main dan sub
        $data['main'] = 'Home Produk Log';
        $data['sub'] = 'Home Produk Log';

        // Query untuk mengambil data log produk


        // Mengirimkan data ke view menggunakan array $data
        return view('admin.produk.logproduk', $data);
    }


    public function datatableLog()
    {
        // Query untuk mengambil data log produk
        $query = LogStok::join('produks', 'log_stoks.ProdukId', '=', 'produks.id')
            ->join('users', 'log_stoks.UsersId', '=', 'users.id')
            ->select(
                'log_stoks.JumlahProduk',
                'log_stoks.created_at',
                'produks.NamaProduk',
                'users.name'
            );

        // Kirim data ke DataTables
        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                // Opsional: Tambahkan kolom aksi jika diperlukan
                return '<a href="#" class="btn btn-sm btn-primary">View</a>';
            })
            ->rawColumns(['action']) // Untuk kolom HTML seperti action
            ->make(true);
    }

    public function cetaklabel(Request $request)
    {
        $id_produk = $request->id_produk; // Bisa berupa array atau nilai tunggal
        $barcodes = [];

        if (is_array($id_produk)) {
            // Jika $id_produk adalah array, proses setiap ID dalam array
            foreach ($id_produk as $id) {
                $id = (string) $id; // Pastikan ID adalah string 
                $harga = Produk::find($id)->Harga;
                $barcode = DNS1DFacade::getBarcodeHTML($id, 'C128'); // Membuat barcode untuk setiap ID
                $barcodes[] = ['barcode' => $barcode, 'harga' => $harga]; // Simpan barcode ke array
            }
        } else {
            // Jika hanya satu nilai, konversi menjadi string dan proses
            $id_produk = (string) $id_produk;
            $harga = Produk::find($id_produk)->Harga;
            $barcode = DNS1DFacade::getBarcodeHTML($id_produk, 'C128'); // Membuat barcode untuk setiap ID
            $barcodes[] = ['barcode' => $barcode, 'harga' => $harga]; // Simpan barcode ke array
        }
        $pdf = Pdf::loadView('admin.produk.cetaklabel', compact('barcodes'));

        $file_path = storage_path('app/public/barcodes.pdf');
        $pdf->save($file_path);

        return response()->json(['url' => asset('storage/barcodes.pdf')]);
    }
}
