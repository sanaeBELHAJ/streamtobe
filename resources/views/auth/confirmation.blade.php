<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>Bienvenue sur StreamToBe</h2>
    <p>Voici un mémo de vos identifiants, conservez-les précieusement :</p>
    <ul>
      <li><strong>Email</strong> : {{ $email }}</li>
      <li><strong>Pseudo</strong> : {{ $pseudo }}</li>
    </ul>
    <p>Afin d'activer votre compte, veuillez cliquer sur ce lien:</p>
    {{ route('verify', ['confirmation_code' => $confirmation_code]) }}
  </body>
</html>