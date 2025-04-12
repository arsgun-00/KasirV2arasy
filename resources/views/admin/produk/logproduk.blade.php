@extends('admin.template.master')
@section('title')
    SAPRAS | Manajemen Sarana
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid bg-gray-200" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid " id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl ">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produk Log</h3>

                    </div>
                    <div class="card-body">
                        <table class="table table-hover" id="table-produk">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Stok</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Sarana -->



    </div>
    </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            let table = $('#table-produk').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: {
                    url: "{{ route('produk.datatableLog') }}", // Ganti dengan URL yang sesuai
                    type: 'GET',
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // Nomor urut
                { data: 'NamaProduk', name: 'NamaProduk' }, // Nama Produk
                { data: 'JumlahProduk', name: 'JumlahProduk' }, // Jumlah Produk
                { data: 'created_at', name: 'created_at' }, // Tanggal
                { data: 'name', name: 'name' }, // Pengguna
                    
                ],
                button: ["copy", "csv", "excel", "pdf", "print"]
                ,
                order: [
                    [1, 'asc']
                ], // Mengurutkan berdasarkan Ruangan
                dom: "<'row mb-2'" +
                    "<'col-sm-6 d-flex align-items-center justify-content-start dt-toolbar'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                    ">" +
                    "<'table-responsive'tr>" +
                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });


        });
    </script>
@endsection