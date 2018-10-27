@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ __('Groups') }}</h1>

        @if (Auth::check() && Auth::user()->can('create', Firefly\Discussion::class))
            <button type="button" class="btn btn-primary" @click.prevent="toggleModal('newGroup')">
                {{ __('New Discussion') }}
            </button>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            @foreach ($discussions as $discussion)
                <div class="discussion">
                    <h3>
                        <a href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}">
                            {{ $discussion->title }}
                        </a>
                    </h3>

                    <div class="list-item-meta">
                        {{ __('Posted by') }} {{ $discussion->user->name }}
                        <span class="mx-2">{{ $discussion->created_at->diffForHumans() }}</span>
                        3 {{ __('replies') }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- @include('firefly::partials.discussion-list') --}}
</div>
@endsection
