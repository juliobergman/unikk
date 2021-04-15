@component('mail::message')
# New Account on Unikk Ventures

Enter Here to create your password...

@component('mail::button', ['url' => route('password.create',['token' => $token, 'email' => $email])])
Enter
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
