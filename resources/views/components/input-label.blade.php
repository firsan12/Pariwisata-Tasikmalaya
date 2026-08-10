@props(['value'])

<label {{ $attributes->merge(['class' => 'profil-label']) }}>
    {{ $value ?? $slot }}
</label>
