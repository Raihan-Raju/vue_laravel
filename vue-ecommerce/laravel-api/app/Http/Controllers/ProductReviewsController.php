<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_Reviews;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductReviewsController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product_Reviews::orderBy('id', 'desc')->with('user', 'product')->get();
        return $this->sendResponse($product, 'product review list fetched successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role_id', 2)
            ->orderBy('id', 'desc')
            ->get();

        $product_reviews = Product::get();

        $data = [
            'users' => $users,
            'product_reviews' => $product_reviews,
        ];

        return $this->sendResponse($data, 'User list fetched successfully!');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content_text' => 'required',
            'rating' => 'required',
            'user_id' => 'required',
            'product_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $input = $request->all();
        $product_reviews = Product_Reviews::create($input);
        return $this->sendResponse($product_reviews, 'product_reviews created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product_reviews = Product_Reviews::with('user', 'product')->find($id);
        return $this->sendResponse($product_reviews, 'product_reviews list fetched successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product_reviews = Product_Reviews::find($id);
        return $this->sendResponse($product_reviews, 'product_reviews fetched successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'content_text' => 'required',
            'rating' => 'required',
            'user_id' => 'required',
            'product_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $input = $request->all();
        $product_reviews = Product_Reviews::find($id)->update($input);
        return $this->sendResponse($product_reviews, 'product_reviews updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product_reviews = Product_Reviews::find($id)->delete();
        return $this->sendResponse($product_reviews, 'product_reviews deleted successfully!');
    }
}
