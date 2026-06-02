<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan ChoiATK</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1,h2,h3{
            margin-bottom: 5px;
        }

        .info{
            margin-bottom:20px;
        }

        .summary{
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-bottom:20px;
        }

        th, td{
            border:1px solid #000;
            padding:8px;
        }

        th{
            background:#f1f5f9;
        }

        .text-center{
            text-align:center;
        }
    </style>
</head>
<body>

    <h1>Laporan Penjualan ChoiATK</h1>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i') }}</p>

        <p>
            <strong>Filter:</strong>
            @if(request('filter') == 'bulan')
                30 Hari Terakhir
            @else
                Semua Data
            @endif
        </p>
    </div>

    <hr>

    <h2>Ringkasan Penjualan</h2>

    <div class="summary">
        <p><strong>Total Pendapatan :</strong>
            Rp {{ number_format($totalPendapatan,0,',','.') }}
        </p>

        <p><strong>Order Selesai :</strong>
            {{ $totalOrderSelesai }}
        </p>

        <p><strong>Order Pending :</strong>
            {{ $totalOrderPending }}
        </p>

        <p><strong>Order Ditolak :</strong>
            {{ $totalOrderDitolak }}
        </p>
    </div>

    <h2>Produk Terlaris</h2>

    <table>
        <thead>
            <tr>
                <th width="10%">No</th>
                <th>Nama Produk</th>
                <th width="25%">Jumlah Terjual</th>
            </tr>
        </thead>

        <tbody>
            @forelse($terlaris as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->nama }}</td>
                <td>{{ $product->orders_count }} kali</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Produk Kurang Laku</h2>

    <table>
        <thead>
            <tr>
                <th width="10%">No</th>
                <th>Nama Produk</th>
                <th width="25%">Jumlah Terjual</th>
            </tr>
        </thead>

        <tbody>
            @forelse($jarangDibeli as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->nama }}</td>
                <td>{{ $product->orders_count }} kali</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Produk Belum Pernah Diorder</h2>

    <table>
        <thead>
            <tr>
                <th width="10%">No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
            </tr>
        </thead>

        <tbody>
            @forelse($belumDiorder as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->nama }}</td>
                <td>{{ $product->category->nama }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">
                    Semua produk sudah pernah diorder
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <br><br>

    <p>
        <strong>Keterangan:</strong><br>
        - Produk Terlaris adalah produk dengan jumlah transaksi selesai terbanyak.<br>
        - Produk Kurang Laku adalah produk yang pernah terjual tetapi jumlah transaksinya rendah.<br>
        - Produk Belum Pernah Diorder adalah produk yang belum memiliki transaksi sama sekali.<br>
        - Data pada laporan ini diambil dari transaksi yang tersimpan pada sistem ChoiATK.
    </p>

</body>
</html>
