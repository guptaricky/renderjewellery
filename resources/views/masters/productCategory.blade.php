@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Product Categories</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('productCategories.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" id="code" name="code" class="form-control" value="{{ old('code') }}">
            @error('code') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>

    <ul class="mt-4">
        @foreach($categories as $category)
            <li>{{ $category->name }} ({{ $category->code }})</li>
        @endforeach
    </ul>
</div>
@endsection
