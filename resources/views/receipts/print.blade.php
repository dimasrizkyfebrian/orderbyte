<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ $order->id }}</title>
    <style>
        /* Memberi tahu browser ukuran ideal halaman untuk dicetak */
        @page {
            size: 80mm auto;  /* Lebar 80mm (umum untuk printer thermal), tinggi otomatis */
            margin: 3mm;      /* Margin sangat kecil di sekeliling kertas */
        }

        /* Style umum untuk body, berlaku untuk layar dan print */
        body {
            font-family: 'Courier New', Courier, monospace;
            color: #000;
            width: 80mm; /* Pastikan lebar body sama dengan lebar kertas */
            margin: 0 auto;
            padding: 10px;
            box-sizing: border-box; /* Mencegah padding menambah lebar total */
        }

        /* Style lain yang sudah ada sebelumnya... */
        .header, .footer {
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 2px 0;
            font-size: 12px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .items-table th, .items-table td {
            padding: 5px;
            font-size: 12px;
            text-align: left;
        }
        .items-table .qty { text-align: center; }
        .items-table .price { text-align: right; }
        .totals {
            margin-top: 15px;
            font-size: 14px;
        }
        .totals div {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
        }
        .totals .grand-total {
            font-weight: bold;
            font-size: 16px;
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        .footer p {
            font-size: 12px;
            margin-top: 20px;
        }
        hr.dashed {
            border-top: 1px dashed #000;
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reka Coffeeshop</h1>
        <p>Jalan Kopi No. 123, Bekasi</p>
        <p>Telp: 0812-3456-7890</p>
    </div>

    <hr class="dashed">

    <div>
        <p style="font-size: 12px;">No Struk: #{{ $order->order_number }}</p>
        <p style="font-size: 12px;">Kasir: {{ Auth::user()->name }}</p>
        <p style="font-size: 12px;">Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <hr class="dashed">

    <table class="items-table">
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td colspan="3">{{ $item->menu->name }}</td>
                </tr>
                <tr>
                    <td class="qty">{{ $item->quantity }}x</td>
                    <td>Rp {{ number_format($item->price) }}</td>
                    <td class="price">Rp {{ number_format($item->price * $item->quantity) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr class="dashed">

    <div class="totals">
        <div class="grand-total">
            <span>TOTAL</span>
            <span>Rp {{ number_format($order->total_price) }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Terima Kasih Atas Kunjungan Anda!</p>
    </div>

    <script>
        // Secara otomatis memanggil dialog cetak saat halaman dimuat
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>