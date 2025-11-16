{{-- candidate side pagination --}}
@if ($paginator->hasPages())

    @php
        $baseBtn = 'inline-flex items-center justify-center w-10 h-10 rounded-full border transition duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-400';
        $muted =
            $baseBtn .
            ' border-white/40 dark:border-white/10 bg-white/70 dark:bg-slate-800/70 text-gray-400 dark:text-gray-500 cursor-not-allowed';
        $linkBtn =
            $baseBtn .
            ' border-white/60 dark:border-white/20 bg-white/90 dark:bg-slate-900/70 text-slate-600 dark:text-slate-200 hover:-translate-y-0.5 hover:border-blue-400 hover:text-blue-500 dark:hover:text-blue-300 shadow';
        $activeBtn =
            $baseBtn .
            ' border-transparent bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 text-white shadow-lg shadow-blue-500/30';
    @endphp

    <nav role="navigation" aria-label="Pagination Navigation" class="mt-10 flex justify-center">
        <ul class="inline-flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="{{ $muted }}" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <i class="bi bi-chevron-left text-base"></i>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $linkBtn }}" aria-label="@lang('pagination.previous')">
                        <i class="bi bi-chevron-left text-base"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="{{ $muted }}">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="{{ $activeBtn }}" aria-current="page">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="{{ $linkBtn }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $linkBtn }}" aria-label="@lang('pagination.next')">
                        <i class="bi bi-chevron-right text-base"></i>
                    </a>
                </li>
            @else
                <li>
                    <span class="{{ $muted }}" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <i class="bi bi-chevron-right text-base"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
