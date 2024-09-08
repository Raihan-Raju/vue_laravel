<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_item;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->with('user')->get();
        return $this->sendResponse($orders, 'Order list fetched successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required'
        // ]);
        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors(),422);
        // }
        $role_id = $request->userData['role_id'];

        if ($role_id == 2) {
            $products = $request->products;
            $total_price = $request->total_price;
            $order_date = date("Y-m-d H:i:s");
            $user_id = $request->userData['id'];

            $orders_table = [
                "total_price" => $total_price,
                "order_date" => $order_date,
                "user_id" => $user_id
            ];

            $order = Order::create($orders_table);
            $order_id = $order['id'];

            $pro_data = [];

            foreach ($products as $p) {
                $pro_data[] = [
                    "product_id" => $p['id'],
                    "order_id" => $order_id,
                    "quantity" => $p['quantity']
                ];
            }

            $order_items = Order_item::insert($pro_data);

            // making payment
            $payment_input = [
                'date' => $order_date,
                'method' => 'bkash',
                'amount' => $total_price,
                'status' => 'complete',
                'order_id' => $order_id
            ];

            $payment = Payment::create($payment_input);

            return $this->sendResponse($payment, 'Order Placed Successfully!');

        } else {
            $info = "your user id is " . $role_id;
            return $this->sendResponse($info, 'Order not placed!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $Order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orders = Order::find($id);
        return $this->sendResponse($orders, 'Order fetched successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $input = $request->all();
        $orders = Order::find($id)->update($input);
        return $this->sendResponse($orders, 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orders = Order::find($id)->delete();
        return $this->sendResponse($orders, 'Order deleted successfully!');
    }

    public function getCustomerOrders(Request $r)
    {
        $orders = Order::where('user_id', $r->id)->with('order_items.product','payment','shipment')->orderBy('created_at', 'desc')->get();
        return $this->sendResponse($orders, 'Order deleted successfully!');
    }
}
