<!DOCTYPE html>
<html>

<head>
    <title>Best Sellers Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .rank {
            text-align: center;
            font-weight: bold;
        }

        .number {
            text-align: right;
        }

        .trophy {
            color: #ffc107;
        }

        .summary {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>🏆 Best Sellers Report</h1>
        <p>Generated on: {{ $generatedAt->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="info">
        @if($startDate || $endDate)
            <p><strong>Period:</strong>
                {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('M j, Y') : 'Beginning' }}
                to
                {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('M j, Y') : 'Present' }}
            </p>
        @endif
        <p><strong>Showing:</strong> Top {{ $limit }} best selling items</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="rank">Rank</th>
                <th>Item Name</th>
                <th class="number">Total Sold</th>
                <th class="number">Total Orders</th>
                <th class="number">Revenue</th>
                <th class="number">Avg. Order Size</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bestSellers as $index => $seller)
                <tr>
                    <td class="rank">
                        @if($index + 1 <= 3)
                            <span class="trophy">
                                @if($index + 1 == 1) 🥇
                                @elseif($index + 1 == 2) 🥈
                                @else 🥉
                                @endif
                            </span>
                        @endif
                        {{ $index + 1 }}
                    </td>
                    <td>{{ $seller->inventory->item_name ?? 'Unknown Item' }}</td>
                    <td class="number">{{ number_format($seller->total_quantity) }}</td>
                    <td class="number">{{ number_format($seller->total_orders) }}</td>
                    <td class="number">${{ number_format($seller->total_revenue, 2) }}</td>
                    <td class="number">{{ number_format($seller->total_quantity / $seller->total_orders, 1) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">No sales data found for the selected period
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($bestSellers->isNotEmpty())
        <div class="summary">
            <h3>Summary</h3>
            <p><strong>Total Items Analyzed:</strong> {{ $bestSellers->count() }}</p>
            <p><strong>Top Seller:</strong> {{ $bestSellers->first()->inventory->name ?? 'N/A' }}
                ({{ number_format($bestSellers->first()->total_quantity ?? 0) }} units sold)</p>
            <p><strong>Total Revenue (Top {{ $limit }}):</strong>
                ${{ number_format($bestSellers->sum('total_revenue'), 2) }}</p>
        </div>
    @endif
</body>

</html>