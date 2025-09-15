@php
    switch ($getMediaIconSize()) {
        case 'xs':
            $gap = '8px';
            $textSpace = '0.35rem';
            $iconWidth = 30;
            $iconHeight = 30;
            break;
        case 'md':
            $gap = '18px';
            $textSpace = '0.75rem';
            $iconWidth = 60;
            $iconHeight = 60;
            break;
        case 'lg':
            $gap = '22px';
            $textSpace = '1rem';
            $iconWidth = 80;
            $iconHeight = 80;
            break;

        default:
            $gap = '12px';
            $textSpace = '0.5rem';
            $iconWidth = 40;
            $iconHeight = 40;
            break;
    }
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div style="display: flex; gap: {{ $gap }}; width: 100%; flex-wrap: wrap;" {{ $getExtraAttributeBag() }}>

        @foreach ($filterMedia($getState()) as $media)
            <div style="display: flex; flex-direction: column; gap: .{{ $textSpace }};">

                <div>

                    @if (str($media?->mime_type)->startsWith('video/'))
                        <a class="" href="{{ $media?->getUrl() }}" target="_blank" rel="noopener noreferrer">
                            <img src="/fb-essentials-assets/video.png" width={{ $iconWidth }}px
                                height={{ $iconHeight }}px>
                        </a>
                    @endif

                    @if (str($media?->mime_type)->startsWith('image/'))
                        <a href="{{ $media?->getUrl() }}" target="_blank">
                            <img src={{ $media?->getUrl() }} width={{ $iconWidth }}px height={{ $iconHeight }}px>
                        </a>
                    @endif

                    @if (str($media?->mime_type)->startsWith('application/pdf'))
                        <a class="flex justify-center" href="{{ $media?->getUrl() }}" target="_blank">
                            <img src="/fb-essentials-assets/pdf.png" width={{ $iconWidth }}px
                                height={{ $iconHeight }}px>
                        </a>
                    @endif

                    @if (str($media?->mime_type)->startsWith('audio/'))
                        <a class="flex justify-center" href="{{ $media?->getUrl() }}" target="_blank">
                            <img src="/fb-essentials-assets/audio.png" width={{ $iconWidth }}px
                                height={{ $iconHeight }}px>
                        </a>
                    @endif

                </div>

                @if ($hasMediaText())
                    @php
                        $mediaTextStyle = match ($getMediaTextSize()) {
                            'xs' => 'font-size: 0.7rem; line-height: 0.82rem;',
                            'md' => 'font-size: 0.9rem; line-height: 1rem;',
                            'lg' => 'font-size: 1rem; line-height: 1.2rem;',
                            default => 'font-size: 0.82rem; line-height: 0.9rem;',
                        };
                    @endphp

                    <div
                        style="{{ $mediaTextStyle }} width:{{ $iconWidth }}px; overflow: hidden; text-align: center;">
                        {{ $media->name }}
                    </div>
                @endif
            </div>
        @endforeach

    </div>
</x-dynamic-component>
