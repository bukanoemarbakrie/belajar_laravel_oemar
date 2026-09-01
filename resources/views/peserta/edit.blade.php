@extends('app')
@section('content')

<form action="{{ route('update.peserta', $peserta->id) }}" method="post">
    @csrf
    @method('PUT')
    {{-- @dd($peserta) --}}
    <div class="mb3">
        <label for="" class="form-label">Nama</label>
        <input
            type="text"
            class="form-control" placeholder="Masukkan Nama Lengkap Anda" name="nama" value="{{ $peserta->name }}">
    </div>
    <div class="mb3">
        <label for="" class="form-label">Umur</label>
        <input
            type="number"
            class="form-control" placeholder="Masukkan Umur Anda" name="umur" value="{{ $peserta->age }}">
    </div>
    <div class="mb3">
        <label for="" class="form-label">Email</label>
        <input
            type="email"
            class="form-control" placeholder="Masukkan Email Anda" name="email" value="{{ $peserta->email }}">
    </div>
    <div class="mb3">
        <label for="" class="form-label">Address</label>
        <input
            type="text"
            class="form-control" placeholder="Masukkan Alamat Anda" name="address" value="{{ $peserta->address }}">
    </div> <br>
    <div class="mb3">
        <button class="btn btn-outline-primary" type="submit">Simpan</button>
    </div>
</form>
@endsection
