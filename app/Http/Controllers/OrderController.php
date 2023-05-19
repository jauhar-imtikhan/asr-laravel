<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'index']);
    }

    public function index()
    {
        $orders = Order::all();

        return response()->json([
            'message' => 'success',
            'data' => $orders
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_member' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input  = $request->all();
        $orders =   Order::create($input);
        for ($i = 0; $i < count($input['id_produk']); $i++) {
            OrderDetail::create([
                'id_order' => $orders['id'],
                'id_produk' => $input['id_produk'][$i],
                'jumlah' => $input['jumlah'][$i],
                'size' => $input['size'][$i],
                'color' => $input['color'][$i],
                'total' => $input['total'][$i],
            ]);
        }
        return response()->json([
            'message' => 'success',
            'data' => $orders
        ]);
    }


    public function show(Order $Order)
    {
        //
    }


    public function edit(Order $Order)
    {
        //
    }


    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'id_member' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input  = $request->all();

        $order->update($input);
        OrderDetail::where('id_order', $order['id'])->delete();

        for ($i = 0; $i < count($input['id_produk']); $i++) {
            OrderDetail::create([
                'id_order' => $order['id'],
                'id_produk' => $input['id_produk'][$i],
                'jumlah' => $input['jumlah'][$i],
                'size' => $input['size'][$i],
                'color' => $input['color'][$i],
                'total' => $input['total'][$i],
            ]);
        }
        return response()->json([
            'message' => 'berhasil update order',
            'data' => $order
        ]);
    }

    public function ubah_status(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'berhasil update order',
            'data' => $order
        ]);
    }

    public function dikonfirmasi()
    {
        $orders = Order::where('status', 'Dikonfirmasi')->get();

        return response()->json([
            'message' => 'success',
            'data' => $orders
        ]);
    }

    public function dikemas()
    {
        $orders = Order::where('status', 'Dikemas')->get();

        return response()->json([
            'message' => 'success',
            'data' => $orders
        ]);
    }

    public function dikirim()
    {
        $orders = Order::where('status', 'Dikirim')->get();

        return response()->json([
            'message' => 'success',
            'data' => $orders
        ]);
    }

    public function diterima()
    {
        $orders = Order::where('status', 'Diterima')->get();

        return response()->json([
            'message' => 'success',
            'data' => $orders
        ]);
    }
    public function selesai()
    {
        $orders = Order::where('status', 'Selesai')->get();

        return response()->json([
            'message' => 'success',
            'data' => $orders
        ]);
    }


    public function destroy(Category $order)
    {

        $order->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }
}
