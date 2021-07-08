@props(['post'])

<x-card>
    <div class="flex justify-between items-center">
        <div class="text-sm text-gray-500">
            {{ __('Posted by') }} {{ $post->user->name }} &#8226; {{ $post->created_at->diffForHumans() }}
        </div>

        <div class="flex space-x-2">
            @can ('update', $post)
                <a href="{{ route('firefly.post.edit', $post) }}">
                    <span class="sr-only">{{ __('Edit') }}</span>
                    <svg class="w-5 h-5 text-gray-700 hover:text-gray-500" data-tippy-content="{{ __('Edit') }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endcan

            @can ('delete', $post)
                <button onclick="event.preventDefault(); document.getElementById('delete-post-{{ $post->id }}-form').submit();">
                    <span class="sr-only">{{ __('Delete') }}</span>
                    <svg class="w-5 h-5 text-red-500 hover:text-red-400" data-tippy-content="{{ __('Delete') }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>

                <form id="delete-post-{{ $post->id }}-form" action="{{ route('firefly.post.delete', [$post->discussion->id, $post->discussion->slug, $post]) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            @endcan
        </div>
    </div>

    <div class="mt-2 unreset">
        {!! $post->isRichlyFormatted ? $post->content : nl2br(e($post->content)) !!}
    </div>
</x-card>
