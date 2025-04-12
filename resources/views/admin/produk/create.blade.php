@extends('admin.template.master')

@section('css')

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content d-flex flex-column flex-column-fluid bg-gray-200" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid " id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl ">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Data Produk</h3>
                        <div class="card-toolbar d-flex justify-content-end">

                            <a href="{{ route('produk.index') }}" class="btn text-white hover-index  btn-sm btn-warning">
                                Kembali
                            </a>
                        </div>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        <div id="error-container" style=" display:none ">
                            <div class="alert alert-danger">
                                <p id="error-message"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form-create-produk" method="post">
                            <label for="">Nama Produk</label>
                            <input type="text" name="NamaProduk" class="form-control" required>
                            <label for="">Harga</label>
                            <input type="number" name="Harga" class="form-control" required>
                            <label for="">Stok</label>
                            <input type="number" name="Stok" class="form-control" required>
                            <button class="btn btn-primary mt-2" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
            <!-- /.content -->
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $("#form-create-produk").submit(function (e) {
                e.preventDefault();
                dataForm = $(this).serialize() + "&_token={{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "{{ route('produk.store') }}",
                    data: dataForm,
                    dataType: "json",
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            confirmButtonText: 'Ok'
                        })
                        $('input[name="NamaProduk"]').val('');
                        $('input[name="Harga"]').val('');
                        $('input[name="Stok"]').val('');
                    },
                    error: function (data) {
                        console.log(data.message);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonText: 'Ok'
                        })
                        if (data.status == 500) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.responseJSON.message,
                                confirmButtonText: 'Ok'
                            })
                        }
                    }
                });
            });
        });
    </script>
@endsection