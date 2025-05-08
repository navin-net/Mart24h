@props([
    'title' => '',
    'value' => '',
    'icon' => '',
    'iconColor' => '',
    'bgColor' => '',
    'change' => '',
    'changeType' => 'success'
])

<div class="col-md-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <div class="stat-card-icon" style="background-color: {{ $bgColor }};">
                    <i class="bi {{ $icon }}" style="color: {{ $iconColor }};"></i>
                </div>
            </div>
            <h3 class="mb-1">{{ $value }}</h3>
            <div class="text-{{ $changeType }} small">
                <i class="bi bi-arrow-up"></i>
                <span>{{ $change }}</span>
            </div>
        </div>
    </div>
</div>
