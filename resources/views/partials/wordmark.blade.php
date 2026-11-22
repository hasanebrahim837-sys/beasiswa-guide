{{-- IndoScholar wordmark: INDO (olive) + SCHOLAR (burgundy), Open Sans SemiBold; optional orange tagline --}}
<span class="wordmark {{ $class ?? '' }}" aria-label="IndoScholar">
    <span class="wm-name"><span class="wm-indo">INDO</span><span class="wm-scholar">SCHOLAR</span></span>
    @if($tagline ?? true)
        <span class="wm-tagline">Your guide to scholarships in Indonesia</span>
    @endif
</span>
