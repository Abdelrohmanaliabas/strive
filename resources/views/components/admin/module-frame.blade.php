@props([
    'title' => 'Admin Module',
    'eyebrow' => null,
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'space-y-8 dashboard-shell']) }}>
    <header class="header-panel flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text" @if($eyebrow) data-eyebrow="{{ $eyebrow }}" @endif>{{ $title }}</h1>
            @if ($description)
                <p class="text-sm module-subtext mt-1">{{ $description }}</p>
            @endif
        </div>
        @isset($actions)
            <div class="flex flex-wrap gap-3">
                {{ $actions }}
            </div>
        @endisset
    </header>

    <div class="card p-6 space-y-8">
        {{ $slot }}
    </div>
</div>
