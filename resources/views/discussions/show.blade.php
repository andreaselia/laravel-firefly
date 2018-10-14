@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            @foreach ($posts as $post)
                <div class="list-group-item list-group-item-action">
                    <p>{{ $post->user->name }} {{ $post->created_at->diffForHumans() }}</p>

                    <p>{{ $post->content }}</p>
                </div>
            @endforeach

            <div class="mt-5">
                <new-post :discussion="{{ $discussion }}"  inline-template>
                    <form role="form" @submit.prevent="submit">
                        <div class="form-group">
                            <label for="content">{{ __('Content') }}</label>
                            <textarea v-model="content" id="content" class="form-control" rows="3">{{ old('content') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-blue">{{ __('Submit Reply') }}</button>
                    </form>
                </new-post>
            </div>
        </div>
    </div>
</div>
@endsection
