@extends('clients.vitrina-template')

@section('categories')
    @if (Auth::user())
        <div class="flex justify-center mx-auto">
        @foreach ($categories as $category)
            <div class="mx-auto px-4 py-2 mt-2">
                <img src="{{ asset(Storage::url($category['image'])) }}" 
                alt="{{ $category['name'] }}"
                class="w-48 h-auto text-center">
                <p class="text-center text-red-500 text-medium font-semibold mt-2 mx-auto">{{ $category['name'] }}</p>
            </div>
        @endforeach
        </div>
    @endif
@endsection