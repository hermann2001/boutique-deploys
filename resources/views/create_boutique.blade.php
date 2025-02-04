<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer votre boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="bg-light">

    <!-- Navbar avec le bouton de déconnexion -->
    <nav class="navbar navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Mon Déployeur de Boutique</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-pill">Déconnexion</button>
            </form>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Créer votre Boutique</h3>
                    </div>
                    <div class="card-body">

                        <!-- Affichage des erreurs de validation -->
                        @if (isset($successCreateBtq))
                            <div class="alert alert-success text-center">
                                Boutique créée avec success ! Allez sur le lien
                                <a href="{{ env('APP_URL') . '/' . $btqName }}"
                                    target="_blank">{{ $btqName }}.domain.xxx</a> pour acéder à la boutique.
                            </div>
                        @endif

                        <!-- Formulaire de création de la boutique -->
                        <form action="{{ route('createBtq') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="boutique_name" class="form-label">Nom de la Boutique</label>
                                <input type="text" name="boutique_name" id="boutique_name"
                                    class="form-control @error('boutique_name') is-invalid @enderror"
                                    placeholder="Entrez le nom de votre boutique" value="{{ old('boutique_name') }}"
                                    required>

                                @error('boutique_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success rounded-pill">Déployer la
                                    Boutique</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
