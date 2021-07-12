@component('mail::message')
{{ __('A new post has been added to the discussion ":discussion"', ['discussion' => $post->discussion->title]) }}

@component('mail::button', ['url' => route('firefly.discussion.show',[$post->discussion->id, $post->discussion->slug])])
    {{ __('View Post') }}
@endcomponent

<small>{{ __('If you no longer want to receive these emails, you can unwatch the discussion') }}</small>
@endcomponent

