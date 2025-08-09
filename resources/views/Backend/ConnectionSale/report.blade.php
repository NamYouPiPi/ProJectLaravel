<!DOCTYPE html>
<html>
<head>
    <title>Connection Sales Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
        .summary { margin-top: 20px; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
<div class="header">
    <h1>Connection Sales Report</h1>
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
</div>

<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @forelse($sales as $sale)
        <tr>
            <td>{{ $sale->created_at->format('M j, Y') }}</td>
            <td>{{ $sale->inventory->item_name ?? 'N/A' }}</td>
            <td>{{ $sale->quantity }}</td>
            <td>${{ number_format($sale->price, 2) }}</td>
            <td>${{ number_format($sale->total_price, 2) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">No sales found</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="summary">
    <p><strong>Total Quantity:</strong> {{ $totalQuantity }}</p>
    <p><strong>Total Revenue:</strong> ${{ number_format($totalRevenue, 2) }}</p>
</div>
</body>
</html>
