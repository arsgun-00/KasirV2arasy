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
    <!-- Main content -->
    <div class="content d-flex flex-column flex-column-fluid bg-gray-200" id="kt_content">
        <div class="post d-flex flex-column-fluid " id="kt_post">
            <div id="kt_content_container" class="container-xxl ">
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
                    <form action="{{ route('penjualan.store') }}" method="post" onsubmit="return validateForm()">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">

                                @csrf
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="penjualan">
                                    <tr>
                                        <td>
                                            <select name="ProdukId[]" id="id_produk" class="form-control kode-produk"
                                                onchange="pilihProduk(this)">
                                                <option value="">Pilih Produk</option>
                                                @foreach ($produks as $produk)
                                                    <option value="{{ $produk->id }}" data-harga="{{ $produk->Harga }}">
                                                        {{ $produk->NamaProduk }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </td>
                                        <td>
                                            <input type="text" name="harga[]" id="harga" class="form-control harga"
                                                readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="JumlahProduk[]" id="JumlahProduk "
                                                class="form-control jumlahProduk" oninput="hitungTotal(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="TotalHarga[]" id="TotalHarga"
                                                class="form-control totalHarga" readonly>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger"
                                                onclick="hapusProduk(this)">Hapus</button>
                                        </td>
                                    </tr>


                                </tbody>
                                <tfooter>
                                    <tr>
                                        <td colspan="3">
                                            Total harga
                                        </td>
                                        <td colspan="2">
                                            <input type="text" id="total" readonly class="form-control" name="total">
                                        </td>
                                </tfooter>

                            </table>
                            <button type="button" class="btn btn-primary" onclick="tambahProduk()">Tambah Produk</button>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('') }}plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('') }}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('') }}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('') }}plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('') }}plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script>
        function tambahProduk() {
            const newRow = `
                <tr>
                    <td>
                        <select name="ProdukId[]" class="form-control kode-produk" onchange="pilihProduk(this)">
                            <option value="">Pilih Produk</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}" data-harga="{{ $produk->Harga }}">
                                    {{ $produk->NamaProduk }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="harga[]" class="form-control harga" disabled>
                    </td>
                    <td>
                        <input type="number" name="JumlahProduk[]" class="form-control jumlahProduk" oninput="hitungTotal(this)">
                    </td>
                    <td>
                        <input type="text" name="TotalHarga[]" class="form-control totalHarga" disabled>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="hapusProduk(this)">Hapus</button>
                    </td>
                </tr>
            `;
            $('#penjualan').append(newRow);
        }

        function hapusProduk(buttonElement) {
            $(buttonElement).closest('tr').remove();
            hitungTotalAkhir();
        }

        function pilihProduk(produk) {
            const selectOption = produk.options[produk.selectedIndex];
            const row = $(produk).closest('tr');
            const harga = $(selectOption).data('harga');

            const selectedKode = produk.value;
            if ($(".kode-produk").not(produk).filter((_, el) => el.value === selectedKode).length > 0) {
                alert('Produk sudah ada');
                row.find('.kode-produk').val('');
                return;
            }

            row.find('.harga').val(harga);
        }

        function hitungTotal(inputElement) {
            const row = $(inputElement).closest('tr');
            const harga = parseFloat(row.find('.harga').val());
            const jumlahProduk = parseFloat(inputElement.value);

            if (jumlahProduk <= 0) {
                alert('Jumlah produk harus lebih dari 0.');
                row.find('.jumlahProduk').val('');
                row.find('.totalHarga').val('');
                hitungTotalAkhir();
                return;
            }

            const totalHarga = harga * jumlahProduk;
            row.find('.totalHarga').val(totalHarga);

            hitungTotalAkhir();
        }

        function hitungTotalAkhir() {
            let total = 0;

            $('.totalHarga').each(function () {
                total += parseFloat($(this).val()) || 0;
            });

            $('#total').val(total);
        }

        function validateForm() {
            let isValid = true;

            $('#penjualan tr').each(function () {
                const produk = $(this).find('.kode-produk').val();
                const jumlah = $(this).find('.jumlahProduk').val();

                if (!produk || !jumlah) {
                    isValid = false;
                    alert('Pastikan semua produk dan jumlah telah diisi.');
                    return false; // Break the loop
                }
            });

            return isValid;
        }
    </script>


@endsection