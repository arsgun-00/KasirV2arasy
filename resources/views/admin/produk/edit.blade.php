@extends('admin.template.master')



@section('content')
    <div class="content d-flex flex-column flex-column-fluid bg-gray-200" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid " id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl ">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Produk</h3>
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
                        <form id="form-update-produk" method="post">
                            <label for="">Nama Produk</label>
                            <input type="text" name="NamaProduk" value="{{ $produk->NamaProduk }}" class="form-control"
                                required>
                            <label for="">Harga</label>
                            <input type="number" name="Harga" value="{{ $produk->Harga }}" class="form-control" required>
                            <label for="">Stok</label>
                            <input type="number" name="Stok" value="{{ $produk->Stok }}" class="form-control" required>
                            <button class="btn btn-warning mt-2" type="submit">Update</button>
                        </form>
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
                $("#form-update-produk").submit(function (e) {
                    e.preventDefault();
                    dataForm = $(this).serialize() + "&_token={{ csrf_token() }}" + "&id={{ $produk->id }}";
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('produk.update', ':id') }}".replace(':id', {{ $produk->id }}),
                        data: dataForm,
                        dataType: "json",
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('produk.index') }}";
                                }
                            })
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