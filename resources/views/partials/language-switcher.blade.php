{{-- Language switcher: UK flag = English, Yemen flag = Arabic --}}
<div class="lang-switch" role="group" aria-label="Language / اللغة">
    <a href="{{ route('lang.switch', 'en') }}" hreflang="en" title="English"
       class="lang-flag {{ app()->getLocale() === 'en' ? 'is-active' : '' }}"
       @if(app()->getLocale() === 'en') aria-current="true" @endif>
        <svg viewBox="0 0 60 30" aria-hidden="true">
            <clipPath id="uk-s"><path d="M0,0 v30 h60 v-30 z"/></clipPath>
            <clipPath id="uk-t"><path d="M30,15 h30 v15 z v15 h-30 z h-30 v-15 z v-15 h30 z"/></clipPath>
            <g clip-path="url(#uk-s)">
                <path d="M0,0 v30 h60 v-30 z" fill="#012169"/>
                <path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/>
                <path d="M0,0 L60,30 M60,0 L0,30" clip-path="url(#uk-t)" stroke="#C8102E" stroke-width="4"/>
                <path d="M30,0 v30 M0,15 h60" stroke="#fff" stroke-width="10"/>
                <path d="M30,0 v30 M0,15 h60" stroke="#C8102E" stroke-width="6"/>
            </g>
        </svg>
        <span class="sr-only">English</span>
    </a>
    <a href="{{ route('lang.switch', 'ar') }}" hreflang="ar" title="العربية"
       class="lang-flag {{ app()->getLocale() === 'ar' ? 'is-active' : '' }}"
       @if(app()->getLocale() === 'ar') aria-current="true" @endif>
        <svg viewBox="0 0 60 30" aria-hidden="true">
            <rect width="60" height="10" y="0" fill="#CE1126"/>
            <rect width="60" height="10" y="10" fill="#FFFFFF"/>
            <rect width="60" height="10" y="20" fill="#000000"/>
        </svg>
        <span class="sr-only">العربية</span>
    </a>
</div>
