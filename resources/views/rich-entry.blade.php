<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div {{ $getExtraAttributeBag() }} class="flex flex-col gap-y-10">
        <div class="fi-fo-rich-editor-main">
            <div class="fi-fo-rich-editor-content fi-prose">
                <div class="tiptap ProseMirror">
                    {!! $getState() !!}
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
