<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Welcome</title>
</head>

<body class="bg-light">

    <div class="m-5 text-center">
        <h1>Bienvenue sur notre site, {{ $name }}</h1>
        <p>Ici, vous déployer bien facilement votre boutique en ligne. Nous vous souhaitons de passer une très belle
            expérience avec nous.</p>
        <p>Cliquez <a href="{{ url('login') }}">ici</a> pour vous connecter et commencer l'aventure</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
