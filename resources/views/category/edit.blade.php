@extends('app')
@section('content')
<form action="{{ route('category.update', $edit->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="" class"form-label">Name</label>
        <input type="text" name="name" value="{{ $edit->name }}" class="form-control">
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="is_active" id="radioDefault1" {{ $edit->is_active == 1 ? 'checked' : '' }} checked value="1">
            <label class="form-check-label" for="radioDefault1">
                Active
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="is_active" id="radioDefault2" {{ $edit->is_active == 0 ? 'checked' : '' }} value="0">
            <label class="form-check-label" for="radioDefault2">
                In-Active
            </label>
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Kirim</button>
    </div>
</form>
@endsection
