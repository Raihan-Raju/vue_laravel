
<?php

use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponUsagesController;
use App\Http\Controllers\CuponsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProductPriceController;
use App\Http\Controllers\ProductReviewsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::resource('users', UserController::class)->names('users');
    Route::get('customer-list', [UserController::class, 'customerList'])->name('customerlist');

    Route::get('customer/report/{id}/{period}', [CustomerController::class, 'customerReport']);
    Route::get('customer/oreport/{id}', [CustomerController::class, 'customerOrderDetails']);

    Route::get('flight', [FlightController::class, 'index'])->name('flight');
    Route::resource('carts', CartsController::class)->names('carts');
    Route::resource('categorys', CategoryController::class)->names('categorys');
    Route::resource('cupons', CuponsController::class)->names('cupons');
    Route::resource('couponusages', CouponUsagesController::class)->names('couponusages');
    Route::post('checkcoupon', [CuponsController::class, 'checkCoupon'])->name('checkcoupon');
    Route::resource('orderitems', OrderItemsController::class)->names('orderitems');
    Route::resource('orders', OrdersController::class)->names('orders');
    Route::post('customerorders', [OrdersController::class, 'getCustomerOrders'])->name('customerorders');
    Route::resource('payments', PaymentsController::class)->names('payments');
    Route::resource('products', ProductsController::class)->names('products');
    Route::resource('purchases', PurchaseController::class)->names('purchases');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('shipments', ShipmentController::class)->names('shipments');
    Route::resource('subcategorys', SubCategoryController::class)->names('subcategorys');
    Route::resource('wishlists', WishlistController::class)->names('wishlists');
    Route::resource('inventory', InventoryController::class)->names('inventory');
    Route::resource('productreviews', ProductReviewsController::class)->names('productreviews');
    Route::resource('productprice', ProductPriceController::class)->names('productprice');
    Route::resource('photos', PhotoController::class)->names('photos');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user()->load('photo');
    return $user;
});

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
