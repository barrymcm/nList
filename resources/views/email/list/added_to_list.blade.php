@component('mail::message')
# Added to list confirmation!!

@component('mail::panel')
Thank you {{ $applicant->first_name }} have been added to the list !
I will need to figure out how to pass the details of the event and list
shortly!
@endcomponent

@component('mail::button', ['url' => 'http://localhost:8000/home'])
back to addme.com
@endcomponent

Thanks for using addme,<br>
{{ config('app.name') }}
@endcomponent
