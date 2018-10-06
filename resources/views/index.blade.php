@extends('firefly::layouts.app')

@section('hero')
<header class="hero">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Discussions</h1>

                    {{-- TODO: auth/policy check --}}
                    <a href="#" class="btn btn-yellow">New Discussion</a>
                </div>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis quos aut sequi totam ducimus nihil, vitae repellendus expedita quas nemo.</p>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if (! count($discussions))
                <div class="notification notification-yellow">
                    {{ __('Uh oh, there are no discussions.') }}
                </div>
            @endif

            <ul class="discussion-list">
                @foreach ($discussions as $discussion)
                    <li class="list-item">
                        <a href="{{ route('discussion.show', $discussion) }}"></a>
                    </li>
                @endforeach
            </ul>

            <div class="pagination">
                {!! $discussions->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
