@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">
            <h1>Benvenuto {{ $user->name }} nell'area protetta</h1>
        </div>
    </section>
@endsection