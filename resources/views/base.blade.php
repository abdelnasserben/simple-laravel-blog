<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

    @php
        $currentRouteName = Route::currentRouteName();
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/blog">Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => $currentRouteName == 'blog.index']) aria-current="page" href="{{ route('blog.index') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => $currentRouteName == 'blog.create']) href="{{ route('blog.create')}}">Nouveau</a>
                    </li>
                </ul>
            </div>

            @guest
                <div class="nav-item">
                    <a class="nav-link text-white" href="{{ route('auth.login') }}">Se connecter</a>
                </div>
            @endguest
            @auth
                <span class="text-white me-2">Welcome {{ Auth::user()->name }}</span>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-light">Se déconnecter</button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="container pt-4">

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success')}}
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>