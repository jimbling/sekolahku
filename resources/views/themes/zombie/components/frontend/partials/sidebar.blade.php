@php
    $currentUrl = request()->path(); // Mendapatkan path dari URL saat ini
@endphp

@php
    $cardColors = ['bg-yellow-100', 'bg-green-100', 'bg-blue-100', 'bg-red-100', 'bg-purple-100', 'bg-pink-100'];
@endphp

@foreach ($widgets as $widget)
    @if ($widget->is_active)
        @includeIf('themes.' . getActiveTheme() . '.widgets.' . $widget->name, ['widget' => $widget])
    @endif
@endforeach
