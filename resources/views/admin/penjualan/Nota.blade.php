<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Penjualan</title>
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        border: 1px solid black;
        padding: 5px;
        text-align: left;
    }

    .header, .footer {
        text-align: center;
        margin-bottom: 10px;
    }

    .footer {
        margin-top: 20px;
        font-size: 10px;
    }

    .no-border {
        border: none !important;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }
</style>

<body>
    <!-- Header Section -->
    <div class="header">
        <h3>Angkasa Collection</h3>
        <p>NPWP: 0000-0000-0000-0000</p>
        <h4>Nota Penjualan</h4>
    </div>

    <!-- Transaction Details -->
    <table class="no-border">
        <tr>
            <td>No. Nota</td>
            <td>: {{ $penjualan->id }}</td>
            <td>Tanggal</td>
            <td>: {{ $penjualan->TanggalPenjualan }}</td>
        </tr>
        <tr>
            <td>Jenis Bayar</td>
            <td>: Cash / Kontan</td>
            <td>Kasir</td>
            <td>: {{ Auth::user()->name }}</td>
        </tr>
    </table>

    <!-- Items Table -->
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detailpenjualan as $item)
                <tr>
                    <td>{{ $item->ProdukId }}</td>
                    <td>{{ $item->NamaProduk }}</td>
                    <td>{{ rupiah($item->harga) }}</td>
                    <td>{{ $item->JumlahProduk }}</td>
                    <td>{{ rupiah($item->SubTotal) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-right"><strong>Total</strong></td>
                <td>{{ rupiah($penjualan->TotalHarga) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>Tunai</strong></td>
                <td>{{ rupiah($totalBayar) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>Kembali</strong></td>
                <td>{{ rupiah($kembalian) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Footer Section -->
    <div class="footer">
        <p>> Terima kasih atas kunjungan Anda.</p>
        <p>> Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
    </div>
</body>
</html>

<script>
    window.print();
</script>