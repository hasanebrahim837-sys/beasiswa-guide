{{-- Large faint 4-petal flower (brand motif) used as a watermark --}}
<svg class="hero-flower" viewBox="-330 -330 660 660" aria-hidden="true">
    @foreach([[0, '#4B1A24'], [90, '#6B6947'], [180, '#4B1A24'], [270, '#6B6947']] as [$rot, $color])
        <path d="M0,0 A300 300 0 0 1 300,-300 A300 300 0 0 1 0,0Z" transform="rotate({{ $rot }})"
              fill="{{ $color }}" fill-opacity=".14" stroke="{{ $color }}" stroke-opacity=".55" stroke-width="3"/>
        <path d="M0,0 A480 480 0 0 1 300,-300 A480 480 0 0 1 0,0Z" transform="rotate({{ $rot }})"
              fill="none" stroke="{{ $color }}" stroke-opacity=".35" stroke-width="2"/>
    @endforeach
</svg>
