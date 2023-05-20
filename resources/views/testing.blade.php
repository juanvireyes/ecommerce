@extends('template')

@section('title', 'Testing')

@section('content')
    <div class="container mx-auto">
        <h1>Pruebas de filtro</h1>

        <form action="{{ route('testing') }}" method="get">
            
            <select name="categoryId" id="categoryId">
                <option value="">Selecciona categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <button type="submit">Ver subcategorías</button>

            @if (!empty($categoryId))
                <select name="subcategoryId" id="subcategoryId">
                    <option value="">Selecciona Subcategoría</option>
                    @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </select>
            

                <input type="hidden" name="selectedCategory" value="{{ $categoryId }}">

                <button type="submit">Filtrar productos</button>
            @endif

            <select name="price" id="price">
                <option value=""></option>
                <option value="asc">Menor a mayor</option>
                <option value="desc">Mayor a menor</option>
            </select>

            <button type="submit">Ordenar por precio</button>

        </form>

        <ul>
            @foreach ($products as $product)
                <li>{{ $product->name }} - {{ $product->price }}</li>
            @endforeach
        </ul>
        {{ $products->links() }}

    </div>
@endsection