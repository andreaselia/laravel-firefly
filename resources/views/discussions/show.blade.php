@extends('firefly::layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">{{ $discussion->title }}</div>
        </div>
    </div>
@endsection
