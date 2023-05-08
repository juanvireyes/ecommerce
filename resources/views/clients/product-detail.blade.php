@extends('template')

@section('title', 'Detalle producto')

@section('content')
    <div>
        <h1 class="text-red-500">{{$product->name}}</h1>
    </div>
@endsection