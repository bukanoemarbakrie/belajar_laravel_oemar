<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;

class PesertaController extends Controller
{
    // GET
    public function index()
    {
        // GET
        // select * from pesertas;
        $pesertas = Peserta::get();
        $title = "Data Peserta Baru";
        return view('peserta.index', compact('pesertas', 'title'));
    }

    public function create()
    {
        $title = "Tambah Peserta Baru";
        return view('peserta.create', compact('title'));
    }

    //post
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'email' => 'required|email|unique:pesertas,email',
            'umur' => 'required',
            'address' => 'nullable'
        ]);

        // INSERT INTO peserta () VALUES ()
        Peserta::create([
            'name' => $request->nama,
            'email' => $request->email,
            'age' => $request->umur,
            'address' => $request->address
        ]);

        return redirect()->to('peserta')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $title = 'Edit';
        // SELECT * FROM pesertas WHERE id=$id
        $peserta = Peserta::findOrFail($id);
        return view('peserta.edit', compact('peserta', 'title'));
    }

    public function update(Request $request, string $id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->name = $request->nama;
        $peserta->age = $request->umur;
        $peserta->email = $request->email;
        $peserta->address = $request->address;
        $peserta->save();

        return redirect()->to('peserta')->with('success', 'Data berhasil diperbarui!');
    }

    public function delete(string $id) {
        $peserta = Peserta::findOrFail($id);
        //DELETE FROM pesertas WHERE id=$id
        $peserta->delete();

        return redirect()->to('peserta');
    }
}
