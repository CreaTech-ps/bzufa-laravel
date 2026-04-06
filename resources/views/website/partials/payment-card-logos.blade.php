{{-- Visa & Mastercard marks (visual only). Use variant=inline for subtle placement under newsletter. --}}
@php
    $inline = ($variant ?? '') === 'inline';
@endphp
<div class="flex items-center {{ $inline ? 'gap-2.5 justify-center sm:justify-start opacity-75' : 'gap-2' }}" aria-hidden="true">
    @if($inline)
        <span class="inline-flex items-center justify-center h-7 min-w-[2.75rem] px-2.5 rounded-md border border-slate-200/80 dark:border-white/10 bg-slate-50/80 dark:bg-white/5 font-black text-[10px] tracking-widest text-[#1434CB]" title="Visa">VISA</span>
        <span class="inline-flex items-center justify-center h-7 px-2 rounded-md border border-slate-200/80 dark:border-white/10 bg-slate-50/80 dark:bg-white/5" title="Mastercard">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 24" class="h-[1.125rem] w-auto" aria-hidden="true">
                <circle cx="15" cy="12" r="9" fill="#EB001B"/>
                <circle cx="25" cy="12" r="9" fill="#F79E1B"/>
                <path fill="#FF5F00" d="M20 6.2a8.9 8.9 0 000 11.6 8.9 8.9 0 000-11.6z"/>
            </svg>
        </span>
    @else
        <span class="inline-flex items-center justify-center h-8 px-3 rounded-md bg-white dark:bg-white/10 border border-slate-200 dark:border-white/10 font-black text-[11px] tracking-[0.2em] text-[#1434CB]" title="Visa">VISA</span>
        <span class="inline-flex items-center justify-center h-8 px-2 rounded-md bg-white dark:bg-white/10 border border-slate-200 dark:border-white/10" title="Mastercard">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 24" class="h-5 w-auto" aria-hidden="true">
                <circle cx="15" cy="12" r="9" fill="#EB001B"/>
                <circle cx="25" cy="12" r="9" fill="#F79E1B"/>
                <path fill="#FF5F00" d="M20 6.2a8.9 8.9 0 000 11.6 8.9 8.9 0 000-11.6z"/>
            </svg>
        </span>
    @endif
</div>
