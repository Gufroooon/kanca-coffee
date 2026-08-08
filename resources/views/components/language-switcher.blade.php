@php
    $currentLocale = app()->getLocale();
@endphp
<div class="flex items-center gap-1 rounded-full border border-gray-200 dark:border-zinc-700 p-1 text-xs font-bold">
    <a href="{{ route('locale.switch', 'id') }}" class="px-2.5 py-1 rounded-full transition-colors {{ $currentLocale === 'id' ? 'bg-kanca-orange text-white' : 'text-gray-500 hover:text-kanca-orange' }}">
        ID
    </a>
    <a href="{{ route('locale.switch', 'en') }}" class="px-2.5 py-1 rounded-full transition-colors {{ $currentLocale === 'en' ? 'bg-kanca-orange text-white' : 'text-gray-500 hover:text-kanca-orange' }}">
        EN
    </a>
</div>
