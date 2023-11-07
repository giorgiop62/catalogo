<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    @include('include.header')

    <div class="container h-100 mt-5">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-10 col-md-8 col-lg-6">
                <h3>Aggiungi categoria</h3>
                <form action="{{ route('categoria.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="string" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="descrizione">Descrizione</label>
                        <input type="string" class="form-control" id="descrizione" name="descrizione" required>
                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit" class="btn btn-primary">Crea categoria</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
