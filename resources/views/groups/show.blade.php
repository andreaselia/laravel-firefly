@extends('firefly::layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center space-x-5">
            <div class="text-3xl font-bold">{{ $group->name }}</div>

            <div class="rounded-full text-white font-medium text-xs px-2 py-1" style="background-color: {{ $group->color }};">
                {{ $group->name }}
            </div>

            @if ($group->is_private)
                <x-icon name="private" />
            @endif
        </div>

        @if (Auth::check() && Auth::user()->can('create', \Firefly\Models\Discussion::class))
            <div class="flex space-x-1">
                <a href="{{ route('firefly.discussion.create', $group) }}">
                    <x-button>
                        {{ __('New Discussion') }}
                    </x-button>
                </a>

                @can ('update', $group)
                    <a href="{{ route('firefly.group.edit', $group) }}">
                        <x-button>
                            {{ __('Edit') }}
                        </x-button>
                    </a>
                @endcan

                @can ('delete', $group)
                    <a href="{{ route('firefly.group.delete', $group) }}" onclick="event.preventDefault(); document.getElementById('delete-group-form').submit();">
                        <x-button>
                            {{ __('Delete') }}
                        </x-button>
                    </a>

                    <form id="delete-group-form" action="{{ route('firefly.group.delete', $group) }}" method="POST" style="display: none;">
                        @method('DELETE')
                        @csrf
                    </form>
                @endcan
            </div>
        @endif
    </div>

    @if (! count($discussions))
        <div class="card">
            <div class="card-body">
                <div class="alert alert-yellow mb-0" role="alert">
                    <strong>{{ __('Holy guacamole!') }}</strong><br>
                    {{ __('There are no discussions; You could be the first to create one.') }}
                </div>
            </div>
        </div>
    @endif

    <div class="space-y-5">
        @foreach ($discussions as $discussion)
            <x-discussion-item :discussion="$discussion" :show-tag="false" />
        @endforeach
    </div>
</div>
@endsection
