@props(['value' => null])

@if (config('firefly.features.wysiwyg.enabled'))
    <input id="content_hidden" type="hidden" name="content">
    <input id="formatting" type="hidden" name="formatting" value="rich">
    <div id="content">{!! old('content', $value) !!}</div>
@else
    <x-textarea id="content" class="block mt-1 w-full" type="text" name="content" required autofocus>
        {{ old('content', $value) }}
    </x-textarea>
@endif
