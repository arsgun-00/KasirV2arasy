@extends('admin.template.master')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Modal -->
    <div class="modal fade" id="modalTambahStok" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Stok
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-tambah-stok" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id_produk" id="id_produk">
                        <label for=""> Jumlah Stok </label>
                        <input type="number" name="Stok" id="nilaiTambahStok" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
  
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-warning float-right">Kembali</a>
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailpenjualan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->NamaProduk}}</td>
                                        <td>{{ rupiah($item->harga) }}</td>
                                        <td>{{ $item->JumlahProduk }}</td>
                                        <td>{{ rupiah($item->SubTotal) }}</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="4" align="right">Total Harga</td>
                                    <td> <input type="text" name="totalHarga" id="totalHarga"
                                            value="{{ rupiah($penjualan->TotalHarga) }}" readonly class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right">Jumlah Bayar</td>
                                    <td><input type="number" class="form-control name="JumlahBayar" id="JumlahBayar"></td>
                                </tr>
                                <tr>
                                <td colspan="4" align="right">Kembalian</td>
                                <td><input type="number" class="form-control name="Kembalian" id="Kembalian" readonly></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" id="btnSimpan" class="btn btn-primary float-right mt-2">Simpan</button>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#JumlahBayar').on('input', function() {
                var totalHarga = $('#totalHarga').val();

                var totalHarga = totalHarga.replace(/[^0-9,]/g, '').replace(",", ".");
                console.log(totalHarga);
                var JumlahBayar = $(this).val();
                var Kembalian = JumlahBayar - totalHarga;
                $('#Kembalian').val(Kembalian);
            })
        })
    </script>
    <script>
        $(document).ready(function() {
                    $('#btnSimpan').on('click', function() {
                            var totalHarga = $('#totalHarga').val();
                            var totalHarga = totalHarga.replace(/[^0-9,]/g, '').replace(",", ".");
                            var JumlahBayar = $('#JumlahBayar').val();
                            var Kembalian = $('#Kembalian').val();
                            var id = '{{ $penjualan->id }}';
                            $.ajax({
                                    type: "POST",
                                    url: "{{ route('penjualan.bayarCashStore') }}",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        totalHarga: totalHarga,
                                        JumlahBayar: JumlahBayar,
                                        Kembalian: Kembalian,
                                        id: id
                                    },
                                    success: function(response) {
                                        window.location.href = "{{ route('penjualan.index') }}";
                                    },
                                    error: function(response) {
                                        console.log(response);
                                    }
                                })
                            })
                    })
    </script>
@endsection
