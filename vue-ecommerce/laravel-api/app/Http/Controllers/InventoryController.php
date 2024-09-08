<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventory=Inventory::orderBy('id','desc')->with('product')->get();
        return $this->sendResponse($inventory,'Inventory list fetched successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product_inventory = Product::get();
    
        $data = [
            'product_inventory' => $product_inventory,
        ];

        return $this->sendResponse($data, 'Product inventory list fetched successfully!'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
            'product_id' => 'required',
        
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $input = $request->all();
        $inventory = Inventory::create($input);
        return $this->sendResponse($inventory, 'Inventory created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventory = Inventory::with('quantity','product')->find($id);
        return $this->sendResponse($inventory, 'Inventory list fetched successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory = Inventory::with('product')->find($id);
        return $this->sendResponse($inventory, 'Inventory list fetched successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id )
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
            'product_id' => 'required',
          
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $input = $request->all();
        $inventory = Inventory::find($id)->update($input);
        return $this->sendResponse($inventory, 'Purchase updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::find($id)->delete();
        return $this->sendResponse($inventory, 'Inventory deleted successfully!');
    }
}
