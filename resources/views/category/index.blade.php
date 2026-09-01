@extends('app')
@section('content')
<div class="table table-responsive">
    <div align="right" class="mb-2">
        <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm">Create</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $v)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $v->name }}</td>
                <td>
                    <a href="{{ route('category.edit', $v->id) }}" class="btn btn-success btn-sm">Edit</a>
                    <form action="{{ route('category.destroy', $v->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin dihapus?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
