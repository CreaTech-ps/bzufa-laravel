@php
    $wa = !empty($settings->contact_phone) ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $settings->contact_phone) : null;
    $hasSocialLinks = !empty($settings->facebook_url) || !empty($settings->twitter_url) || !empty($settings->instagram_url) || !empty($settings->linkedin_url) || $wa;
    $isRtl = app()->getLocale() === 'ar';
@endphp
<aside class="fixed {{ $isRtl ? 'left-4' : 'right-4' }} top-1/2 -translate-y-1/2 z-[60] hidden xl:flex flex-col gap-3 p-2 rounded-2xl bg-white/80 dark:bg-slate-800/60 backdrop-blur-md shadow-xl border border-slate-200 dark:border-slate-700">

    @if(!empty($settings->facebook_url))
    <a class="social-icon social-fb w-10 h-10 flex items-center justify-center transition-all duration-300 rounded-lg hover:scale-110 hover:shadow-[0_0_15px_rgba(24,119,242,0.5)] text-slate-400 dark:text-slate-500 hover:!text-[#1877F2]" href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer" title="Facebook">
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
    </a>
    @endif

    @if(!empty($settings->twitter_url))
    <a class="social-icon social-tw w-10 h-10 flex items-center justify-center transition-all duration-300 rounded-lg hover:scale-110 hover:shadow-[0_0_15px_rgba(0,0,0,0.3)] text-slate-400 dark:text-slate-500 hover:!text-[#000]" href="{{ $settings->twitter_url }}" target="_blank" rel="noopener noreferrer" title="X (Twitter)">
        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
    </a>
    @endif

    @if(!empty($settings->instagram_url))
    <style>.social-ig:hover svg, .social-ig:hover svg path { fill: url(#ig-gradient-nav) !important; }</style>
    <a class="social-icon social-ig w-10 h-10 flex items-center justify-center transition-all duration-300 rounded-lg hover:scale-110 hover:shadow-[0_0_15px_rgba(253,29,29,0.5)] text-slate-400 dark:text-slate-500" href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer" title="Instagram">
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><defs><linearGradient id="ig-gradient-nav" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#833AB4"/><stop offset="50%" style="stop-color:#FD1D1D"/><stop offset="100%" style="stop-color:#F77737"/></linearGradient></defs><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.948-.069zM12 0C8.741 0 8.333.015 7.053.072 3.51.232 1.567 2.16 1.407 5.7c-.058 1.281-.072 1.689-.072 4.948 0 3.259.014 3.668.072 4.948.16 3.537 2.103 5.471 5.64 5.631 1.28.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 3.534-.16 5.468-2.103 5.631-5.64.058-1.28.072-1.689.072-4.948 0-3.259-.014-3.668-.072-4.948-.161-3.534-2.103-5.468-5.64-5.631C15.668.015 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
    </a>
    @endif

    @if(!empty($settings->linkedin_url))
    <a class="social-icon social-li w-10 h-10 flex items-center justify-center transition-all duration-300 rounded-lg hover:scale-110 hover:shadow-[0_0_15px_rgba(10,102,194,0.5)] text-slate-400 dark:text-slate-500 hover:!text-[#0A66C2]" href="{{ $settings->linkedin_url }}" target="_blank" rel="noopener noreferrer" title="LinkedIn">
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
    </a>
    @endif

    @if($wa)
    <a class="social-icon social-wa w-10 h-10 flex items-center justify-center transition-all duration-300 rounded-lg hover:scale-110 hover:shadow-[0_0_15px_rgba(37,211,102,0.5)] text-slate-400 dark:text-slate-500 hover:!text-[#25D366]" href="{{ $wa }}" target="_blank" rel="noopener noreferrer" title="WhatsApp">
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></path></svg>
    </a>
    @endif

    @if($hasSocialLinks || !empty($settings->contact_email))
    <div class="h-[1px] w-8 mx-auto bg-slate-200 dark:bg-slate-700 my-1"></div>
    @endif

    @if(!empty($settings->contact_email))
    <a class="social-icon w-10 h-10 flex items-center justify-center transition-all duration-300 rounded-lg hover:scale-110 hover:shadow-[0_0_15px_rgba(234,67,53,0.5)] text-slate-400 dark:text-slate-500 hover:!text-[#EA4335]" href="mailto:{{ $settings->contact_email }}" title="{{ __('ui.contact_us') }}">
        <span class="material-symbols-outlined text-[22px]">mail</span>
    </a>
    @endif

    <button type="button" onclick="event.preventDefault(); navigator.clipboard.writeText('{{ url()->current() }}').then(() => alert('{{ __('ui.link_copied') }}'));" class="w-10 h-10 flex items-center justify-center transition-all duration-300 rounded-lg hover:scale-110 hover:shadow-[0_0_15px_rgba(150,25,74,0.4)] text-slate-400 dark:text-slate-500 hover:!text-primary cursor-pointer" title="{{ __('ui.copy_link') }}">
        <span class="material-symbols-outlined text-[22px]">link</span>
    </button>
</aside>
