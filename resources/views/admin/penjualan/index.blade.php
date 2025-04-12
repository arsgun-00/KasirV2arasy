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
    <div class="content d-flex flex-column flex-column-fluid bg-gray-200" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid " id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl ">
            
                <div class="card">
                <div class="card-header">
                        <h3 class="card-title">Penjualan</h3>
                        <div class="card-toolbar d-flex justify-content-end">

                            <a href="{{ route('penjualan.create') }}" class="btn text-white hover-index  btn-sm"
                                style="background-color:var(--primary-color);"
                                <i class="ki-duotone ki-plus-square fs-2 text-white">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                Tambah Penjualan
                            </a>
                        
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover" id="table-produk">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Penjualan</th>
                                    <th>Harga</th>
                                    <th>Penjualan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                        </table>
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
        $(document).ready(function () {
            let table = $('#table-produk').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: {
                    url: "{{ route('penjualan.datatable') }}", // Ganti dengan URL yang sesuai
                    type: 'GET',
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // Nomor urut
                    { data: 'TanggalPenjualan', name: 'TanggalPenjualan' }, // Tanggal
                    { data: 'TotalHarga', name: 'TotalHarga' }, // Harga
                    { data: 'UsersId', name: 'UsersId' }, // Jumlah Produk
                    { data: 'action', name: 'action' }, // Aksi
                ],
                button: ["copy", "csv", "excel", "pdf", "print"]
                ,
                order: [
                    [0, 'desc']
                ]
            });

        });
    </script>


@endsection
