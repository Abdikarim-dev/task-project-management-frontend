@props([
    'id',
    'labels' => [],
    'data' => [],
    'colors' => [],
    'height' => '280',
])

<div style="height: {{ $height }}px;">
    <canvas id="{{ $id }}" role="img" aria-label="Chart"></canvas>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById(@js($id));
    if (!ctx || typeof Chart === 'undefined') return;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @js($labels),
            datasets: [{
                data: @js($data),
                backgroundColor: @js($colors),
                borderWidth: 0,
                hoverOffset: 6,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 16,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 12 },
                    },
                },
            },
        },
    });
});
</script>
@endpush
