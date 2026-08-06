<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kanca Coffee - Table Digital Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-kanca-bg text-kanca-dark font-sans p-4 sm:p-6 max-w-lg mx-auto pb-12">
    <!-- Header -->
    <div class="text-center py-6 border-b border-orange-200">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-kanca-orange to-kanca-teal text-white font-bold text-2xl mx-auto flex items-center justify-center shadow-lg">K</div>
        <h1 class="font-extrabold text-2xl mt-2 tracking-tight">KANCA COFFEE</h1>
        <p class="text-xs text-kanca-orange font-bold uppercase tracking-widest mt-0.5">Table 04 • Digital Menu</p>
        <p class="text-[11px] text-gray-500 mt-1 italic">"Teman yang kamu cari ada di seberang meja."</p>
    </div>

    <!-- Category Groups -->
    <div class="mt-6 space-y-8">
        @foreach($categories as $category)
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xl">{{ $category->icon }}</span>
                    <h2 class="font-extrabold text-lg tracking-tight">{{ $category->name }}</h2>
                </div>

                <div class="space-y-3">
                    @foreach($category->menus as $item)
                        <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100 flex gap-3 items-center">
                            <img src="{{ $item->image }}" class="w-16 h-16 rounded-xl object-cover flex-shrink-0" />
                            <div class="flex-grow">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-xs text-gray-900 leading-tight">{{ $item->name }}</h4>
                                    <span class="font-extrabold text-xs text-kanca-orange whitespace-nowrap">IDR {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-[10px] text-gray-500 line-clamp-1 mt-1">{{ $item->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 text-center text-xs text-gray-400">
        Please inform our barista at the counter to place your order! ☕
    </div>
</body>
</html>
