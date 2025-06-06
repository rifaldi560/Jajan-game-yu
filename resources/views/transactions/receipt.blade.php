<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manduriar Transaction Receipt Game </title>
    <style>
        :root {
            --primary-color: #ff6f61; /* Manduriar's primary color */
            --secondary-color: #f8f9fa;
            --border-color: #e0e0e0;
            --text-primary: #333333;
            --text-secondary: #666666;
            --success-color: #28a745;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-primary);
            background-color: #f5f5f5;
            line-height: 1.6;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .receipt-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            padding: 40px;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .company-logo {
            width: 120px;
            height: auto;
            margin-bottom: 15px;
        }

        .receipt-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .receipt-subtitle {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .info-group {
            margin-bottom: 15px;
            min-width: 200px;
        }

        .info-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-secondary);
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-success {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success-color);
        }

        .status-pending {
            background-color: rgba(255, 193, 7, 0.15);
            color: #d39e00;
        }

        .status-failed {
            background-color: rgba(220, 53, 69, 0.15);
            color: #c82333;
        }

        .items-section {
            margin-top: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: var(--secondary-color);
        }

        th {
            text-align: left;
            padding: 12px 15px;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .product-name {
            font-weight: 500;
        }

        .product-price, .quantity {
            font-size: 15px;
        }

        .receipt-total {
            margin-top: 30px;
            text-align: center;  /* Center the total */
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .total-label {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .total-value {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            margin-left: 10px;
        }

        .receipt-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .footer-text {
            margin-bottom: 10px;
        }

        .barcode {
            margin: 20px auto;
            text-align: center;
        }

        .barcode img {
            max-width: 250px;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .receipt-container {
                box-shadow: none;
                max-width: 100%;
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .receipt-container {
                padding: 20px;
            }

            .receipt-info {
                flex-direction: column;
            }

            th, td {
                padding: 10px;
                font-size: 14px;
            }

            .receipt-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    @php use Illuminate\Support\Facades\Route; use Illuminate\Support\Facades\Auth; @endphp

    <div class="receipt-container">
        <div class="receipt-header">

            <div class="receipt-title">Manduriar Transaction Receipt Game </div>
            <div class="receipt-subtitle">Thank you for choosing Manduriar!</div>
        </div>

        <div class="receipt-info">
            <div class="info-group">
                <div class="info-label">Transaction ID</div>
                <div class="info-value">{{ $transactions->id }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Date</div>
                <div class="info-value">{{ date('d M Y, H:i', strtotime($transactions->created_at ?? now())) }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Status</div>
                <div class="info-value">
                    @php
                        $statusClass = 'status-pending';
                        if(strtolower($transactions->status) == 'completed' || strtolower($transactions->status) == 'success') {
                            $statusClass = 'status-success';
                        } elseif(strtolower($transactions->status) == 'failed' || strtolower($transactions->status) == 'cancelled') {
                            $statusClass = 'status-failed';
                        }
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $transactions->status }}</span>
                </div>
            </div>
        </div>

        <div class="items-section">
            <div class="section-title">Items Purchased</div>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(json_decode($transactions->items, true) as $item)
                    <tr>
                        <td class="product-name">{{ $item['nama'] }}</td>
                        <td class="quantity">{{ $item['quantity'] }}</td>
                        <td class="product-price">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td class="product-price">Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="receipt-total">
            <span class="total-label">Total Amount:</span>
            <span class="total-value">Rp {{ number_format($transactions->total_harga, 0, ',', '.') }}</span>
        </div>
        @php
        use App\Models\Produk;
        $items = json_decode($transactions->items, true);
        $itchLinks = collect();

        foreach ($items as $item) {
            $product = Produk::where('nama', $item['nama'])->first(); // Ganti ke product_id jika tersedia
            if ($product && $product->itch_url) {
                $itchLinks->push($product->itch_url);
            }
        }

        $itchLinks = $itchLinks->unique();
    @endphp





        </div>
    </div>
</body>
</html>
