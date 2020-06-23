@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($products->chunk(4) as $row)
            <div class="row mb-3">
                @foreach($row as $product)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header"><strong>{{ $product->title }}</strong></div>
                            <div class="card-body">
                                <p class="card-text">{{ $product->description }}</p>
                                <a href="/products/{{ $product->id }}" class="btn btn-primary">جزئیات محصول</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
