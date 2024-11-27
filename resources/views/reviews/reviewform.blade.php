
<h2>Average Score: {{ number_format($averageScore, 1) }}</h2>

@foreach($product->reviews as $review)
    <p>Design: {{ $review->design }} | Quality: {{ $review->quality }}</p>
    <p>Features: {{ $review->features }} | Price: {{ $review->price }}</p>
    <p>Brand: {{ $review->brand }}</p>
    <p>Comment: {{ $review->comment }}</p>
@endforeach

