<?php

namespace App\Http\Controllers;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::orderBy('id', 'desc')->with('user', 'product')->get()->groupBy('invoice_number');
        return $this->sendResponse($purchases, 'Purchase list fetched successfully!');

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
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required',
            'user_id' => 'required',
            'date' => 'required',
            'purchases' => 'required',
            // 'quantity' => 'required',
            // 'product_id' => 'required',
            // 'price' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $invoice_number = $request->invoice_number;
        $date = $request->date;
        $user_id = $request->user_id;
        $purchase = $request->purchases;
        $allPurchase = [];
        foreach ($purchase as $s) {
            unset($s['product_name']);
            unset($s['totalPrice']);
            $s += ['invoice_number' => $invoice_number, 'date' => $date, 'user_id' => $user_id];
            $allPurchase[] = $s;
        }
        // $input = $request->all();
         $purchases = Purchase::insert($allPurchase);
         return $this->sendResponse($purchases, 'Purchase created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchases = Purchase::with('user', 'product')->find($id);
        return $this->sendResponse($purchases, 'Purchase list fetched successfully!');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $purchases = Purchase::with('user', 'product')->find($id);
        return $this->sendResponse($purchases, 'Purchase list fetched successfully!');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
            'invoice_number' => 'required',
            'unit' => 'required',
            'date' => 'required',
            'product_id' => 'required',
            'user_id' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $input = $request->all();
        $purchases = Purchase::find($id)->update($input);
        return $this->sendResponse($purchases, 'Purchase updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchases = Purchase::find($id)->delete();
        return $this->sendResponse($purchases, 'Purchase deleted successfully!');
    }
}

