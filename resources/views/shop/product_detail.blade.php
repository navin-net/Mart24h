@extends('shop.layouts.app')

@section('title', $product['name'])

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-md-6">
      <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-6">
      <h2>{{ $product['name'] }}</h2>
      <p class="text-muted">
        @if($product['old_price'])
          <del>${{ number_format($product['old_price'], 2) }}</del>
        @endif
        <strong class="fs-4">${{ number_format($product['price'], 2) }}</strong>
      </p>
      <div class="mb-3 text-warning">
        {!! str_repeat('★', $product['rating']) !!}
        {!! str_repeat('☆', 5 - $product['rating']) !!}
      </div>

      <p>{{ $product['description'] ?? 'No description available.' }}</p>

      <a href="#" class="btn btn-primary btn-lg">Add to Cart</a>
    </div>
  </div>
</div>
@endsection
