@extends('clients.vitrina-template')

@section('categories')
@section('content-name', 'Subcategorías')
    <div>
        <ul>
            @foreach ($subCategories as $subCategory)
                <li>{{ $subCategory['name'] }}</li>
            @endforeach
        </ul>
    </div>
@endsection