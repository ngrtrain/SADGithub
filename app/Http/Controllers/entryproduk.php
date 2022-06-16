<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class entryproduk extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('entryproduk',[
            "title" => "entryproduk"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        // $request->validate([
        //     'NamaKategori' => 'required|regex:/^[a-zA-Z ]*$/|max:100|min:3',
        //     'DeskripsiKategori' =>'required|regex:/(^[-0-9A-Za-z.,\/ ]+$)/|min:5'
        // ]);
        $id_kategori = $request->input('Kategori');
        $nama_produk = $request->input('NamaProduk');
        $deskripsi_produk = $request->input('DeskripsiProduk');
        $harga_produk = $request->input('HargaProduk');
        $foto_produk = $request->input('FotoProduk');
        $jumlah_produk = $request->input('JumlahProduk');
        $availableproduk = DB::table('PRODUK')
        ->where('NAMA_PRODUK', '=', $nama_produk)
        ->count();
        // check data availability
        if($availableproduk == 0){
            // generate id
             $substrdata = substr($nama_produk,0,1);
             $substrdata = strtoupper($substrdata);
             $count = DB::table('PRODUK')
             ->where('ID_PRODUK', 'like', '%P'. $substrdata .'%')
             ->latest('ID_PRODUK')
             ->count();
             if($count == 0){
                 $idproduk = "P". $substrdata. "001";
             }
             if($count > 0){
                 $lastid = DB::table('PRODUK')
                 ->where('ID_PRODUK', 'like', '%P'. $substrdata .'%')
                 ->latest('ID_PRODUK')
                 ->first('ID_PRODUK');
                 $arrayvalue = get_object_vars($lastid);
                 $substrid = substr($arrayvalue['ID_PRODUK'], -1);
                 $int = (int)$substrid+1;
                 $intlen = strlen((string)$int);
                 if($intlen > 0 and $intlen <9){
                     $idproduk = "P". $substrdata. "00". (string)$int;
                 }
                 if($intlen > 9 and $intlen <100){
                     $idproduk = "P". $substrdata."0". (string)$int;
                 }
             }
             // insert data
              $query = DB::table('PRODUK')->insert([
                  'ID_PRODUK' => $idproduk,
                  'ID_KATEGORI' => $id_kategori,
                  'NAMA_PRODUK' => $request->input('NamaProduk'),
                  'DESKRIPSI_PRODUK' => $request->input('DeskripsiProduk'),
                  'HARGA_PRODUK' => $request->input('HargaProduk'),
                  'FOTO_PRODUK' => $request->input('FotoProduk'),
                  'JUMLAHPRODUK_TRANSAKSI' => $request->input('JumlahProduk'),
                  'del' => 0
              ]);
            return back()->with('success','Produk Berhasil Dimasukkan');
        }
         else{
             return back()->with('fail','Produk Sudah Tersedia');
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
