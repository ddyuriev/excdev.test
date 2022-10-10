@extends('layouts.app')

@section('content')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        @auth
        let refreshRate = {{ $refreshRate }};
        @endauth
    </script>
    <div class="container">
        <table class="table" id="operations-table">
            <thead>
            <tr>
                <th scope="col">uuid</th>
                <th scope="col">value</th>
                <th scope="col">description</th>
                <th scope="col">created_at</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($user->balance->lastFiveOperations as $lastFiveOperations)
                <tr>
                    <td>{{$lastFiveOperations->uuid}}</td>
                    <td>{{$lastFiveOperations->value}}</td>
                    <td>{{$lastFiveOperations->description}}</td>
                    <td>{{$lastFiveOperations->created_at}}</td>
                </tr>
            @endforeach


            </tbody>
        </table>

        @auth
            <a class="navbar-brand" href="{{ url('/') }}">
                ballance: <span id="main-balance">{{ $user->balance->balance }}</span>
            </a>
        @endauth
    </div>
@endsection
