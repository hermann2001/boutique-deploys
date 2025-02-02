<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Reset Password Code</title>
</head>

<body class="bg-light">

    <div class="m-5 text-center">
        <h1>Voici votre code de réinitialisation de votre mot de passe : {{ $code }}</h1>
        <p>Entrez ce code dans le champ 'Code de réinitialisation' pour définir un nouveau mot de passe et pouvoir vous
            connecter à nouveau.</p>
        <p class="text-info">NB: le code expire dans 15 minutes.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
