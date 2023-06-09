<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'index']);
    }

    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'message' => 'success',
            'data' => $categories
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
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

        $categories =   Category::create($input);
        return response()->json([
            'message' => 'success',
            'data' => $categories
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


    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
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
            File::delete('uploads/' . $category->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        $category->update($input);
        return response()->json([
            'message' => 'berhasil update kategori' . ' ' . $category->nama_kategori,
            'data' => $category
        ]);
    }


    public function destroy(Category $category)
    {
        File::delete('uploads/' . $category->gambar);
        $category->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }
}
