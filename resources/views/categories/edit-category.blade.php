@extends('template')

@section('title', 'Editar categoría')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col mx-auto items-center justify-items-center">
            <form action="" method="POST">
                @csrf
                @method('PUT')

                {{-- Image --}}
                <div class="mt-4 mb-2 mx-auto">
                    <div class="mx-auto mb-2">
                        <img 
                        src="{{ Storage::url($category->image) }}" 
                        alt="{{ $category->name }}">
                    </div>
                    <div class="mt-2 mb-1">
                        <input type="file">
                    </div>
                </div>

                {{-- Nombre --}}
                <div class="mt-2 mb-2 mx-auto">
                    <label for="name" class="w-full">
                        <input type="text" name="name" id="name" value="{{ $category->name }}">
                    </label>
                </div>

                {{-- Descripción --}}
                <div class="mt-2 mb-2 mx-auto">
                    <label for="description" class="w-full">
                        <textarea name="description" id="description" value="{{ $category->description }}"></textarea>
                    </label>
                </div>
            </form>
        </div>
    </div>
@endsection