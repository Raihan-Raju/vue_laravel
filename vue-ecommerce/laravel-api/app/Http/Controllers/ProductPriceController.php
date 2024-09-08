<?php

namespace App\Http\Controllers;

//.use App\Models\Product;

use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductPriceController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ProductPrice = ProductPrice::with('product')->get();
        return $this->sendResponse($ProductPrice, 'product price list fetched successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        {
            
            $product_price = Product::get();
    
            $data = [
                'product_price' => $product_price,
            ];
    
            return $this->sendResponse($data, 'Product list fetched successfully!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $input = $request->all();
        $ProductPrice = ProductPrice::create($input);
        return $this->sendResponse($ProductPrice, 'product price created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ProductPrice = ProductPrice::with('user', 'product')->find($id);
        return $this->sendResponse($ProductPrice, 'product price list fetched successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ProductPrice = ProductPrice::find($id);
        return $this->sendResponse($ProductPrice, 'product price fetched successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',

        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $input = $request->all();
        $ProductPrice = ProductPrice::find($id)->update($input);
        return $this->sendResponse($ProductPrice, 'product price updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ProductPrice = ProductPrice::find($id)->delete();
        return $this->sendResponse($ProductPrice, 'product price deleted successfully!');
    }
}
