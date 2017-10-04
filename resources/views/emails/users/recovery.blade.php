@component('mail::message')
# Recovery password

Email: {{$user->users_email}} <br>
{{__('New password')}}:: {{$user->users_password}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent