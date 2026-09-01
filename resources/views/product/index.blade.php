@extends('app')
@section('content')
<div class="table table-responsive">
    <div align="right" class="mb-3">
        <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Category Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $value)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <div class="d-flex" align-items-center gap-2></div>
                    <img src="{{ asset('storage/' . $value->photo) }}" alt="" width="40" height="40" style="object-fit: cover">
                    <div>
                        {{ $value->name }}
                    </div>
                </td>
                <td>{{ $value->category->name }}</td>
                <td>Rp.{{ number_format($value->price) }}</td>
                <td>{{ $value->description }}</td>
                <td>This is Image</td>
                <td class="d-flex gap-3">
                    <a href="{{ route('product.edit', $value->id) }}" class="btn btn-success">Edit</a>
                    <form action="{{ route('product.destroy', $value->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('for real?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
