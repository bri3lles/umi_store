@props(['rating', 'size' => 15])
<span {{ $attributes->merge(['class' => 'stars']) }} aria-label="{{ $rating }} dari 5 bintang">
    @for ($i = 1; $i <= 5; $i++)
        <x-admin.icon :name="$i <= $rating ? 'star-fill' : 'star'" :size="$size" class="{{ $i <= $rating ? 'is-on' : 'is-off' }}" />
    @endfor
</span>