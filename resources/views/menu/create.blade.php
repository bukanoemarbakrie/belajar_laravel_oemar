@extends('app')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('menu.store') }}" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                </div>
                <div class="col-6">
                    <label for="parent_id" class="form-label">Parent</label>
                    <select name="parent_id" id="parent_id" class="form-select">
                        <option value="">Select Parent</option>
                    </select>
                </div>
                <div class="col-6">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter Icon">
                </div>
                <div class="col-6">
                    <label for="url" class="form-label">Url</label>
                    <input type="text" class="form-control" id="url" name="url" placeholder="Enter Url">
                </div>
                <div class="col-6">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order">
                </div>
                <div class="col-6">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="statusActive" value="1" checked>
                        <label class="form-check-label" for="statusActive">Active</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="statusInactive" value="0">
                        <label class="form-check-label" for="statusInactive">In-Active</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
