@foreach ($discussion->groups as $group)
    @if ($discussion->stickied_at)
        <div class="badge badge-pill badge-success">{{ __('Stickied') }}</div>
    @endif

    @if ($discussion->locked_at)
        <div class="badge badge-pill badge-danger">{{ __('Locked') }}</div>
    @endif

    <div class="badge badge-pill" style="background: {{ $group->color }}">{{ $group->name }}</div>
@endforeach
