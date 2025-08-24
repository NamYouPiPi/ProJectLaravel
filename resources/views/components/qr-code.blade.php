@props(['data', 'size' => 250, 'margin' => 0])

<div class="qr-container">
    @if(class_exists('SimpleSoftwareIO\QrCode\Facades\QrCode'))
        <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size($size)->margin($margin)->generate($data)) }}" 
             alt="QR Code" {{ $attributes }}>
    @else
        <img src="https://chart.googleapis.com/chart?cht=qr&chl={{ urlencode($data) }}&chs={{ $size }}x{{ $size }}" 
             alt="QR Code" {{ $attributes }}>
    @endif
</div>
