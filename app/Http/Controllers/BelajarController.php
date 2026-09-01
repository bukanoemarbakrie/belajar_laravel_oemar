<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BelajarController extends Controller
{
    public function index() {
        return view("counting");
    }
    public function indexKurang() {
        return view('kurang');
    }

    public function indexKali() {
        return view('kali');
    }

    public function indexBagi() {
        return view('bagi');
    }
    public function greeting()
    {
        return "Selamat datang di Kelas Laravel";
    }

public function tambah()
{
    $nilai1 = 5;
    $nilai2 = 7;
    $hasil = $nilai1 + $nilai2;

    return "$nilai1 + $nilai2 = $hasil";

}
public function kurang(Request $request)
{
    // $_POST['angka1']; $request->angka1
    $angka1 = $request->angka1;
    $angka2 = $request->angka2;
    $hasil = $angka1 - $angka2;
    return view('kurang', compact('hasil'));
}
    public function kali(Request $request)
    {
        // $_POST['angka1']; $request->angka1
        $angka1 = $request->angka1;
        $angka2 = $request->angka2;
        $hasil = $angka1 * $angka2;
        return view('kali', compact('hasil'));
    }
public function bagi(Request $request)
{
    // $_POST['angka1']; $request->angka1
    $angka1 = $request->angka1;
    $angka2 = $request->angka2;
    $hasil = $angka1 / $angka2;
    return view('bagi', compact('hasil'));
}
}
