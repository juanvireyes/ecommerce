@if (!empty($categoryId))
            <div class="flex flex-row justify-left gap-4 mt-3 py-2 px-6">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="flex">
                        <select name="subcategoryId" id="subcategoryId" class="text-left text-red-500 font-bold w-1/2">
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" 
                                    @if ($subcategory->id == $subcategoryId)
                                        selected
                                    @endif class="font-bold">{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                        
                        <input type="hidden" name="categoryId" value={{ $categoryId }}>

                        <button type="submit" 
                        class="ml-4 px-4 py-2 rounded-md bg-red-500 text-black hover:text-white text-md font-bold inline-block w-full">
                            Filtrar productos
                        </button>
                    </div>
                </form>

            </div>
        @endif