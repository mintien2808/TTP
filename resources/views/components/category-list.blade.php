@props(['categoryList'])

<div {{ $attributes->merge(['class' => 'category-list col-lg-2 ']) }}>
    @if (!empty($categoryList))
        @foreach($categoryList as $category)
            <div class="content"> 
                <a href="{{ route('byCategory', $category) }}" class="cursor-pointer block py-3 px-6 hover:bg-black/10" style="color:black; font-family:'poppy'; font-size:25px; background-color:rgb(137, 239, 239) ; align-item: center; text-align: center; font-weight: bold;   border-radius: 10px;" >
                    {{$category->name}}
                </a>
                <x-category-list class="absolute left-0 top-[100%] z-50 hidden flex-col" :category-list="$category->children"/>
            </div>
        @endforeach
    @endif
</div>
