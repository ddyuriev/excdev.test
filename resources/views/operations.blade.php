@extends('layouts.app')

<!-- Scripts -->
<script src="{{ asset('js/op.js') }}" defer></script>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="description..." aria-label="description..." aria-describedby="basic-search" id="op-search-inp">
                    <span class="input-group-text" id="op-search-btn">search</span>
                </div>
            </div>
        </div>

        <table class="table" id="operations-table">
            <thead>
            <tr>
                <th scope="col">uuid</th>
                <th scope="col">value</th>
                <th scope="col">description</th>
                <th data-sortable="true" scope="col" id="th-date" style="cursor: pointer"><i>date</i></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($operations as $operation)
                <tr>
                    <td>{{$operation->uuid}}</td>
                    <td>{{$operation->value}}</td>
                    <td>{{$operation->description}}</td>
                    <td>{{$operation->created_at}}</td>
                </tr>
            @endforeach


            </tbody>
        </table>
        <div class="d-felx justify-content-center">
            {{ $operations->links() }}
        </div>
    </div>
@endsection
