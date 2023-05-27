<div class="page-header">
    <h1 class="page-title">
        {{ $title }}
    </h1>
    <div class="page-subtitle d-none d-md-block">
        {{ $description ?? '' }}
    </div>
    {{ $slot ?? '' }}
</div>
