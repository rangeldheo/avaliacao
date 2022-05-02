@component('mail::message')
# Olá {{ $user->name }},

### Sua conta foi criada.
### Ative sua conta no botão abaixo

@component('mail::button', ['url' => config('app.url_front') . '/register/activation/' . $user->activation_hash])
Ativar minha conta
@endcomponent

Agradecemos pelo seu cadastro,<br>
{{ config('app.name') }}
@endcomponent
