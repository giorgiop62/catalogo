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
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cat as $categoria)
                <tr>
                    <td>{{ $categoria->nome }}</td>
                    <td>{{ $categoria->descrizione }}</td>
                    <td class="d-flex">
                        <a class="btn btn-sm btn-secondary"
                            href="{{ route('categoria.edit', $categoria->id) }}">Modifica</a>
                        <form action="{{ route('categoria.destroy', $categoria->id) }}" method="post">
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
        <a class="btn btn-sm btn-success" href={{ route('categoria.create') }}>Crea la categoria</a>
    </div>
    <!--è una funziona che permette la paginazione-->
    <div class="container">
        {{ $cat->links() }}
    </div>
</body>


</html>
