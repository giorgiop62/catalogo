<!-- Questo è l'header che si vede solo una volta fatto il login -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Catalogo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categoria') }}">Categorie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('prodotto') }}">Prodotti</a>
                </li>
            </ul>
            <span class="navbar-text">
                <a class="nav-link" href="{{ route('login') }}">Logout</a>
            </span>
        </div>
    </div>
</nav>