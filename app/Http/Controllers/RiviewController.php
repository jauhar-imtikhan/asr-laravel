<?php

namespace App\Http\Controllers;

use App\Models\Riview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RiviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'index']);
    }

    public function index()
    {
        $riviews = Riview::all();

        return response()->json([
            'message' => 'success',
            'data' => $riviews
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_produk' => 'required',
            'id_member' => 'required',
            'riview' => 'required',
            'rating' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input  = $request->all();


        $riviews =   Riview::create($input);
        return response()->json([
            'message' => 'success',
            'data' => $riviews
        ]);
    }


    public function show(Riview $category)
    {
        //
    }


    public function edit(Riview $category)
    {
        //
    }


    public function update(Request $request, Riview $riview)
    {
        $validator = Validator::make($request->all(), [
            'id_produk' => 'required',
            'id_member' => 'required',
            'riview' => 'required',
            'rating' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input  = $request->all();

        $riview->update($input);
        return response()->json([
            'message' => 'berhasil update riview',
            'data' => $riview
        ]);
    }


    public function destroy(Riview $riview)
    {
        File::delete('uploads/' . $riview->gambar);
        $riview->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }
}
