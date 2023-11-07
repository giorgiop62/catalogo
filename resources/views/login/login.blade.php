@extends('login/layout')
@section('title', 'Login')
@section('content')
    <div class="container">
        <h1 class="text-center">Entra nel tuo catalogo</h1>
        <form action="{{ route('login.post') }}" method="POST" class="ms-auto me-auto" style="width: 500px">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <span>
                <a href="{{ route('register.post') }}">Registrati</a>
            </span>
        </form>

    </div>

@endsection
