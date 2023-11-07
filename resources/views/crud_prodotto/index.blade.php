<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Catalogo</title>
</head>

<body>
    @include('include.header')


    <table class="table">
        <thead>
            <tr>
                <th scope="col">NOME</th>
                <th scope="col">DESCRIZIONE</th>
                <th scope="col">PREZZO</th>
                <th scope="col">CATEGORIE</th>
                <th scope="col">AZIONI</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prodotto as $prod)
                <tr>
                    <td>{{ $prod->nome }}</td>
                    <td>{{ $prod->descrizione }}</td>
                    <td>{{ $prod->prezzo }}</td>
                    <td>
                        @foreach ($mapCategorie[$prod->id_prodotto] as $categoria)
                            <a title="Modifica categoria"
                                href="{{ route('categoria.edit', $categoria->id) }}">{{ $categoria->nome }}</a>
                        @endforeach
                    </td>
                    <td class="d-flex">
                        <a class="btn btn-sm btn-secondary"
                            href="{{ route('prodotto.edit', $prod->id_prodotto) }}">Modifica</a>
                        <form action="{{ route('prodotto.destroy', $prod->id_prodotto) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <a class="btn btn-sm btn-success" href={{ route('prodotto.create') }}>Crea prodotto</a>
    </div>
</body>


</html>
