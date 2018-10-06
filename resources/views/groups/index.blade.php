@extends('firefly::layouts.app')

@section('hero')
<header class="hero">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Groups</h1>
                    <a href="#" class="btn btn-green">Add Group</a>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="container">
    <div class="row">
        @foreach ($groups as $group)
            <div class="col-sm-6 col-md-4 col-lg-2">
                <a href="{{ route('group.show', $group) }}" class="group-item" style="background-color: {{ $group->color }};">
                    {{ $group->name }}
                </a>
            </div>
        @endforeach

        <div class="pagination">
            {!! $groups->links() !!}
        </div>
    </div>
</div>
@endsection
