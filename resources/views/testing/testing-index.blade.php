@extends('template')

@section('title', 'Testing')

@section('content')
    {{-- <div id="app">
        <custom-component :products="{{ json_encode($products) }}" />

    </div> --}}

    <div class="container mx-auto">
        
        <div>
            {{ $response }}
        </div>

    </div>
@endsection