<x-app-layout>
<h2>Average Score: {{ number_format($averageScore, 1) }}</h2>

@foreach($product->reviews as $review)
    <p>{{ $review->user->name }}</p>
    <p>Rating:{{ $review->rating }}</p>
    <p>Comment: {{ $review->comment }}</p>
@endforeach

</x-app-layout>