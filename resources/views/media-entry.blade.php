<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div style="display: flex; gap: 12px; width: 100%;" {{ $getExtraAttributeBag() }}>

        @foreach ($filterMedia($getState()) as $media)
            <div>

                @if (str($media?->mime_type)->startsWith('video/'))
                    <a class="" href="{{ $media?->getUrl() }}" target="_blank">
                        <img src="/fb-essentials-video" width=40px height=40px>
                    </a>
                @endif

                @if (str($media?->mime_type)->startsWith('image/'))
                    <a href="{{ $media?->getUrl() }}" target="_blank">
                        <img src={{ $media?->getUrl() }} width=40px height=40px>
                    </a>
                @endif

                @if (str($media?->mime_type)->startsWith('application/pdf'))
                    <a class="flex justify-center" href="{{ $media?->getUrl() }}" target="_blank">
                        <img src="/fb-essentials-pdf" width=40px height=40px>
                    </a>
                @endif

                @if (str($media?->mime_type)->startsWith('audio/'))
                    <a class="flex justify-center" href="{{ $media?->getUrl() }}" target="_blank">
                        <img src="/fb-essentials-audio" width=40px height=40px>
                    </a>
                @endif

            </div>
        @endforeach

    </div>
</x-dynamic-component>
