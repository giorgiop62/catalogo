@extends('login/layout')
@section('title', 'Register')
@section('content')
    <div class="container">
        <form action="{{ route('register.post') }}" method="POST" class="ms-auto me-auto" style="width: 500px">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="string" class="form-control" name="name">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Registrati</button>
        </form>

    </div>

@endsection
