@component('mail::message')
<h2 style="text-align: center">{{ __("Account Activation") }}</h2>

<p style="text-align: center">{{__('To continue your registration please click on the button below')}}</p>

@component('mail::button', ['url' => $user->activate_link, 'color' => 'green'])
	<span style="white-space: nowrap;">{{ __("Activate Account") }}</span>
@endcomponent

<p style="text-align: center">Thanks,
	{{ config('app.name') }} team
</p>
@endcomponent
