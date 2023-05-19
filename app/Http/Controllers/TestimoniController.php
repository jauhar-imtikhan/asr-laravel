<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TestimoniController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'index']);
    }

    public function index()
    {
        $testi = Testimoni::all();

        return response()->json([
            'message' => 'success',
            'data' => $testi
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_testimoni' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,svg'
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input  = $request->all();
        if ($request->has('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }

        $testi =   Testimoni::create($input);
        return response()->json([
            'message' => 'success',
            'data' => $testi
        ]);
    }


    public function show(Category $category)
    {
        //
    }


    public function edit(Category $category)
    {
        //
    }


    public function update(Request $request, Testimoni $testimoni)
    {
        $validator = Validator::make($request->all(), [
            'nama_testimoni' => 'required',
            'deskripsi' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input  = $request->all();
        if ($request->has('gambar')) {
            File::delete('uploads/' . $testimoni->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        $testimoni->update($input);
        return response()->json([
            'message' => 'berhasil update kategori',
            'data' => $testimoni
        ]);
    }


    public function destroy(Testimoni $testimoni)
    {
        File::delete('uploads/' . $testimoni->gambar);
        $testimoni->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }
}
