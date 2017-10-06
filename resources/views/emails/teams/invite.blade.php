@component('mail::message')
<h2 style="text-align: center">{{ __("Invitation to the Team") }}</h2>

<p style="text-align: center">{{__('You was invited into the Team')}}</p>

@component('mail::button', ['url' => $url, 'color' => 'green'])
	<span style="white-space: nowrap;">{{ __("Accept Invitation") }}</span>
@endcomponent

<p style="text-align: center">Thanks,
	{{ config('app.name') }} team
</p>
@endcomponent
