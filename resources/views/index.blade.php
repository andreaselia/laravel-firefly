@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ __('Discussions') }}</h1>

        @if (Auth::check() && Auth::user()->can('create', Firefly\Discussion::class))
            <button type="button" class="btn btn-primary" @click.prevent="toggleModal('newDiscussion')">
                {{ __('New Discussion') }}
            </button>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            @foreach ($discussions as $discussion)
                <div class="discussion-item d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">
                            <a href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}">
                                {{ $discussion->title }}
                            </a>
                        </h3>

                        <div class="discussion-item-meta">
                            {{ $discussion->user->name }}
                            <span class="mx-2">{{ $discussion->created_at->diffForHumans() }}</span>
                            {{ count($discussion->posts) }} {{ __('replies') }}
                        </div>
                    </div>

                    <div class="d-flex">
                        @foreach ($discussion->groups as $group)
                            <div class="group-display rounded-circle mb-0" data-toggle="tooltip" data-placement="top" title="{{ $group->name }}" style="background: {{ $group->color }};"></div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-3">
        {!! $discussions->links() !!}
    </div>
</div>
@endsection
