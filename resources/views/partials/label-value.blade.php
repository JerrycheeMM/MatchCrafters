@if(isset($slot) || isset($value))
    <div class="details-list">
        <div class="details-list__label">{{ $label }}</div>
        <div class="details-list__value">
            {{ $slot ?? $value }}
        </div>
    </div>
@endif