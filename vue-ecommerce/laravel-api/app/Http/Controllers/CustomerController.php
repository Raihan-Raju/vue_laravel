<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_item;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerController extends Controller
{
    use ApiResponse;

    public function customerReport(string $id, $period = null)
    {
        // Determine the date range based on the period
        $dateRange = $this->getDateRange($period);

        // Fetch orders within the specified date range
        $orders = Order::where('user_id', $id)
            ->with('order_items.product')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $this->calculateOrderData($orders);

        return $this->sendResponse($data, 'Order report retrieved successfully!');
    }

    private function getDateRange($period)
    {
        switch ($period) {
            case 'weekly':
                return ['start' => Carbon::now()->startOfWeek(), 'end' => Carbon::now()->endOfWeek()];
            case 'monthly':
                return ['start' => Carbon::now()->startOfMonth(), 'end' => Carbon::now()->endOfMonth()];
            case 'annual':
                return ['start' => Carbon::now()->startOfYear(), 'end' => Carbon::now()->endOfYear()];
            default:
                return ['start' => Carbon::minValue(), 'end' => Carbon::now()]; // No period specified
        }
    }

    private function calculateOrderData($orders)
    {
        $data = [];
        foreach ($orders as $o) {
            $orderData = $o->toArray();
            $orderData['order_items'] = [];
            $totalProfitOnOrder = 0;
            $totalBuyingPriceOnOrder = 0;
            $totalSellingPriceOnOrder = 0;
            $order_price = $o['total_price'];

            foreach ($o['order_items'] as $i) {
                $quantity = $i['quantity'];
                $selling_price = $i['product']['price'];
                $product_id = $i['product_id'];
                

                $price_data = ProductPrice::where('product_id', $product_id)->first();
                $buying_price = $price_data['buying_price'];

                $total_selling_price = $quantity * $selling_price;
                $total_buying_price = $quantity * $buying_price;
                $total_profit_on_item = $total_selling_price - $total_buying_price;

                $itemData = $i->toArray();
                $itemData['profit'] = $total_profit_on_item;
                $itemData['buying_price'] = $total_buying_price;
                $itemData['selling_price'] = $total_selling_price;

                $orderData['order_items'][] = $itemData;

                $totalProfitOnOrder += $total_profit_on_item;
                $totalBuyingPriceOnOrder += $total_buying_price;
                $totalSellingPriceOnOrder += $total_selling_price;
            }

            $orderData['total_profit_on_order'] = $order_price - $totalBuyingPriceOnOrder;
            $orderData['total_buying_price_on_order'] = $totalBuyingPriceOnOrder;
            $orderData['total_selling_price_on_order'] = $order_price;

            $data[] = $orderData;
        }

        return $data;
    }

    public function customerOrderDetails(string $oid) {
        
        $order_items = Order_item::where('order_id', $oid)->get();
        $data = [];

        foreach ($order_items as $i) {

            $quantity = $i['quantity'];
            $selling_price = $i['product']['price'];
            $product_id = $i['product_id'];
            

            $price_data = ProductPrice::where('product_id', $product_id)->first();
            $buying_price = $price_data['buying_price'];

            $total_selling_price = $quantity * $selling_price;
            $total_buying_price = $quantity * $buying_price;
            $total_profit_on_item = $total_selling_price - $total_buying_price;

            $itemData = $i->toArray();
            $itemData['profit'] = $total_profit_on_item;
            $itemData['buying_price'] = $total_buying_price;
            $itemData['selling_price'] = $total_selling_price;

            $data[] = $itemData;

        }

        return $this->sendResponse($data, 'Order report retrieved successfully!');

    }
}
