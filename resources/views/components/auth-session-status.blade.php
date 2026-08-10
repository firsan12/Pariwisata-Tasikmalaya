@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success profil-alert']) }}>
        {{ $status }}
    </div>
@endif
