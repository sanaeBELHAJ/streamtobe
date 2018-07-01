<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>{{ __('Welcome on') }} {{ setting('site.title') }}</h2>
    <p>{{ __('This is your login memo, keep them safely') }}:</p>
    <ul>
      <li><strong>{{ __('E-Mail Address') }}</strong> : {{ $email }}</li>
      <li><strong>{{ __('Pseudo') }}</strong> : {{ $pseudo }}</li>
    </ul>
    <p>{{ __('To enable your account, please check this link') }}:</p>
    {{ route('verify', ['confirmation_code' => $confirmation_code]) }}
  </body>
</html>