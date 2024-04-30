<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\OrderProduct;
use App\Models\Orders;
use App\Models\OrdersProduct;
use App\Models\Type;
use App\Models\Yard;
use App\Models\Product;
use App\Models\Statistical;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrdersController extends Controller
{
    public function index()
    {
        $order = Orders::whereDate('time_start', '<', Carbon::now())->where('time_end', null)->get();

        foreach ($order as $key => $value) {
            OrdersProduct::where('orders_id', $value['id'])->delete();
            Orders::where('id', $value['id'])->delete();
        }

        $yard = Yard::with(['order' => function ($query) {
            $query->where('time_end', null)->with('product');
        }])->where('active', 1)->get();

        $data = [
            'yard' => $yard->toArray(),
        ];

        return view('layout', [
            'data' => $data,
            'content' => 'orders/orders'
        ]);
    }

    public function add(Request $request)
    {
        $yard_id = $request->yard_id;

        $duration = $request->duration;

        if ($request->start_hour) {
            $start_time = Carbon::now('Asia/Ho_Chi_Minh')->setTime($request->start_hour, $request->start_minute);
        }
        else{
            $start_time = Carbon::now('Asia/Ho_Chi_Minh');
        }

        $prepay_money = $request->prepay_money ? $request->prepay_money : '0';

        $order = new Orders([
            'yard_id' => $yard_id,
            'time_start' => $start_time,
            'time_end' => null,
            'duration' => $duration,
            'cost' => $prepay_money,
            'artisan' => 0
        ]);

        $yard = Yard::find($yard_id);

        $yard->order()->save($order);

        return redirect('/orders');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $order = Orders::find($id)->product;

        foreach ($order as $value) {
            Product::where('id', $value['id'])->update([
                'quantity' => DB::raw('quantity + ' . $value['pivot']['quantity_order'])
            ]);
        }

        DB::table('orders_product')->where('orders_id', $id)->delete();

        DB::table('orders')->delete($id);

        return redirect('/orders');
    }

    public function deleteProduct(Request $request)
    {
        $product_id = $request->product_id;
        $orders_id = $request->orders_id;

        $order_product_quantity = Orders::find($orders_id)->product()->where('id', $product_id)->get();

        Product::where('id', $product_id)->update([
            'quantity' => DB::raw('quantity + ' . $order_product_quantity[0]['pivot']['quantity_order'])
        ]);

        DB::table('orders_product')
            ->where('orders_id', $orders_id)
            ->where('product_id', $product_id)
            ->delete();

        $total = $this->totalOrderProduct($orders_id);

        $orders_product = Orders::with(['product' => function ($query) {
            $query->with('type');
        }])->where('id', $orders_id)->get()->toArray();

        return json_encode([
            'total' => $total,
            'orderProduct' => $orders_product[0]['product']
        ]);
    }

    private function totalOrderProduct($orders_id)
    {
        $total = [
            'quantity' => 0,
            'cost' => 0
        ];

        $product = Orders::find($orders_id)->product;

        foreach ($product as $value) {
            $total['quantity'] += $value['pivot']['quantity_order'];
            $total['cost'] += $value['pivot']['quantity_order'] * $value['cost'];
        }

        return $total;
    }

    public function showOrdersProduct(Request $request)
    {
        $orders_id = $request->orders_id;

        $orders_product = Orders::with(['product' => function ($query) {
            $query->with('type');
        }])->where('id', $orders_id)->get()->toArray();

        return json_encode($orders_product[0]['product']);
    }

    public function showMenu()
    {
        $product_type = Type::with(['product' => function ($query) {
            $query->where('quantity', '>', 0);
        }])->get()->toArray();

        return json_encode($product_type);
    }

    public function addProduct(Request $request)
    {
        $orders_id = $request->orders_id;

        $data_insert = [];

        foreach ($request->product as $value) {
            $order = Orders::find($orders_id)->product()->where('product_id', $value['id'])->get();

            if (isset($order[0])) {
                $order_quantity = $order[0]['pivot']['quantity_order'];
            } else {
                $order_quantity = 0;
            }

            $data_insert[] = [
                'orders_id' => $orders_id,
                'product_id' => $value['id'],
                'quantity_order' => $value['quantity'] + $order_quantity
            ];

            Product::where('id', $value['id'])->update([
                'quantity' => DB::raw('quantity - ' . $order_quantity)
            ]);
        }

        OrdersProduct::upsert(
            $data_insert,
            ['orders_id', 'product_id'],
            ['quantity_order']
        );

        $total = $this->totalOrderProduct($orders_id);

        return json_encode($total);
    }

    public function checkout(Request $request)
    {
        $order_id = $request->id;

        $order = Orders::with('yard')->with(['product' => function ($query) {
            $query->with('type');
        }])->where('id', $order_id)->get()[0];

        $startTime = Carbon::parse($order['time_start']);
        $duration = Carbon::parse($order['time_start'])->setTime((int)$startTime->hour + (int)$order['duration'], (int)$startTime->minute + (($order['duration'] * 60) % 60));

        if ($order['artisan']) {
            $finishTime = $duration;
        } else {
            if (Carbon::parse($order['time_end'])->lessThan($duration) && $order['duration'] != null) {
                $finishTime = $duration;
            } else {
                $finishTime = Carbon::now('Asia/Ho_Chi_Minh');
            }
        }

        $order['duration'] = ($finishTime->hour + ($finishTime->minute / 60)) - ($startTime->hour + ($startTime->minute / 60));

        $order['time_end'] = $finishTime;

        $data = [
            'order' => $order->toArray(),
        ];

        return view('layout', [
            'data' => $data,
            'content' => 'orders/checkout'
        ]);
    }

    public function checkoutSuccess(Request $request)
    {
        $order_id = $request->order_id;
        $time_end = $request->time_end;
        $duration = $request->duration;
        $cost = $request->cost;

        Orders::where('id', $order_id)->update([
            'time_end' => $time_end,
            'cost' => $cost,
            'duration' => $duration
        ]);

        return redirect('/orders');
    }

    public function changeYard(Int $current_yard, Int $swap_yard)
    {
        Orders::where('id', $current_yard)->update([
            'yard_id' => $swap_yard
        ]);

        return redirect('/orders');
    }

    public function payMore(Request $request)
    {
        $id = $request->id;
        $cost = $request->cost;

        Orders::where('id', $id)->update([
            'cost' => DB::raw('cost + ' . $cost)
        ]);

        return redirect('/orders');
    }

    public function artisan(Request $request)
    {
        $yard_id = $request->yard_id;

        $hour_in = (int)$request->start_hour;
        $minute_in = (int)$request->start_minute;
        $hour_out = (int)$request->end_hour;
        $minute_out = (int)$request->end_minute;

        $order = new Orders([
            'yard_id' => $yard_id,
            'time_start' => Carbon::now('Asia/Ho_Chi_Minh')->setTime($hour_in, $minute_in),
            'time_end' => null,
            'duration' => ($hour_out + ($minute_out / 60)) - ($hour_in + ($minute_in / 60)),
            'cost' => 0,
            'artisan' => 1
        ]);

        $yard = Yard::find($yard_id);

        $yard->order()->save($order);

        return redirect('/orders');
    }
}
