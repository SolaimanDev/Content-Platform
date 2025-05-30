@component('mail::message')
# Post Status Changed

Your post "{{ $post->title }}" status has been changed to: 
<strong>{{ $status == 1 ? 'Active' : 'Inactive' }}</strong>

@component('mail::button', ['url' => url('/posts/'.$post->id)])
View Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent