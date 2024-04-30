<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yard;
use App\Models\Orders;
use App\Models\Password;
use App\Models\Statistical;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function index()
    {
        $yard = Yard::where('active', 1)->get();
        $password = Password::get()[0]['password'];

        return view('layout', [
            'data' => [
                'yard_quantity' => count($yard),
                'yard_price' => $yard[0]['cost'],
                'password' => $password
            ],
            'content' => 'manager/manager'
        ]);
    }

    private function editYardQuantity(Int $quantity, Int $old_quantity, Int $cost)
    {
        if ($quantity > $old_quantity) {
            for ($i = $old_quantity; $i < $quantity; $i++) {
                $yard = Yard::where('number', $i + 1)->get()->toArray();

                if (empty($yard)) {
                    Yard::insert([
                        'number' => $i + 1,
                        'cost' => $cost,
                        'active' => 1
                    ]);
                } else {
                    Yard::where('id', $yard[0]['id'])->update([
                        'active' => 1
                    ]);
                }
            }
        } else {
            $yard = Yard::with('order')->where('number', '>', $quantity)->get()->toArray();

            $check = true;

            foreach ($yard as $value) {
                if (!empty($value['order'])) {
                    $check = false;
                    break;
                }
            }

            if ($check) {
                Yard::where('number', '>', $quantity)->update([
                    'active' => 0
                ]);
            }
        }
    }

    public function handleUpdateInfo(Request $request)
    {
        if ($request->quantity) {
            $this->editYardQuantity($request->quantity, $request->old_quantity, $request->old_cost);
        }

        if ($request->cost) {
            DB::table('yard')->update([
                'cost' => $request->cost
            ]);
        }

        if ($request->password) {
            DB::table('password')->update([
                'password' => $request->password
            ]);
        }

        return redirect('/manager');
    }

    public function receiveStatistical(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;
        $type_of_time = 0;

        if ($year && $month && $day) {
            $type_of_time = 'full';

            $yard_statistical = Yard::select('yard.number', DB::raw('SUM(orders.cost) as cost, SUM(orders.duration) as duration, SUM(product.cost) as pro_cost'))
                ->where('yard.active', 1)
                ->leftJoin('orders', 'orders.yard_id', 'yard.id')
                ->leftJoin('orders_product', 'orders.id', 'orders_product.orders_id')
                ->leftJoin('product', 'orders_product.product_id', 'product.id')
                ->whereDate('orders.time_end', $year . '/' . $month . '/' . $day)
                ->groupBy('yard.number')->get();

            $income = Statistical::select(DB::raw('date as dates, duration, cost, product_sum_cost'))->whereDate('date', $year . '/' . $month . '/' . $day)->get()->toArray();
        } else if ($year && $month && !$day) {
            $type_of_time = 'year_month';

            $yard_statistical = Yard::select('yard.number', DB::raw('SUM(orders.cost) as cost, SUM(orders.duration) as duration, SUM(product.cost) as pro_cost'))
                ->where('yard.active', 1)
                ->leftJoin('orders', 'orders.yard_id', 'yard.id')
                ->leftJoin('orders_product', 'orders.id', 'orders_product.orders_id')
                ->leftJoin('product', 'orders_product.product_id', 'product.id')
                ->whereYear('orders.time_end', $year)
                ->whereMonth('orders.time_end', $month)
                ->groupBy('yard.number')->get();

            $income = Statistical::select(DB::raw('SUM(cost) as cost, SUM(product_sum_cost) as product_sum_cost, SUM(duration) as duration, DAY(date) as dates'))
                ->whereYear('date', $year)->whereMonth('date', $month)->groupBy('dates')->get()->toArray();
        } else if ($year && !$month && $day) {
            $type_of_time = 'year_day';

            $yard_statistical = [];

            $income = Statistical::select(DB::raw('SUM(cost) as cost, SUM(product_sum_cost) as product_sum_cost, SUM(duration) as duration, MONTH(date) as dates'))
                ->whereYear('date', $year)->whereDay('date', $day)->groupBy('dates')->get()->toArray();
        } else {
            $type_of_time = 'year';

            $yard_statistical = Yard::select('yard.number', DB::raw('SUM(orders.cost) as cost, SUM(orders.duration) as duration, SUM(product.cost) as pro_cost'))
                ->where('yard.active', 1)
                ->leftJoin('orders', 'orders.yard_id', 'yard.id')
                ->leftJoin('orders_product', 'orders.id', 'orders_product.orders_id')
                ->leftJoin('product', 'orders_product.product_id', 'product.id')
                ->whereYear('orders.time_end', $year)
                ->groupBy('yard.number')->get();

            $income = Statistical::select(DB::raw('MONTH(date) as dates, SUM(cost) as cost, SUM(product_sum_cost) as product_sum_cost, SUM(duration) as duration'))
                ->whereYear('date', $year)->groupBy('dates')->get()->toArray();
        }

        $request->flash();

        return redirect()->route('manager_info')->with([
            'statistical' => [
                'income' => $income,
                'yard' => $yard_statistical,
                'type' => $type_of_time
            ]
        ]);
    }

    public function summaryPrice()
    {
        $orders = Orders::select(DB::raw('DATE(time_start) as date, SUM(cost) as cost, SUM(duration) as duration'))
            ->withSum('product', 'cost')->where("time_end", '!=', null)->where('statistical', 0)
            ->groupBy('date', 'id')->get()->toArray();

        foreach ($orders as $value) {
            $id = Statistical::where('date', $value['date'])->get();

            if (isset($id[0]['id'])) {
                $value['product_sum_cost'] = $value['product_sum_cost'] ? $value['product_sum_cost'] : 0;

                Statistical::where('id', $id[0]['id'])->update([
                    'cost' => DB::raw('cost + ' . $value['cost']),
                    'duration' => DB::raw('duration + ' . $value['duration']),
                    'product_sum_cost' => DB::raw('product_sum_cost + ' . $value['product_sum_cost']),
                ]);
            } else {
                Statistical::insert($value);
            }
        }

        foreach ($orders as $value) {
            Orders::whereDate('time_end', $value['date'])->update([
                'statistical' => 1
            ]);
        }

        return redirect('/manager');
    }
}

// $yard_statistical = Yard::withSum('order', 'cost')
//             ->withSum('order', 'duration')->with(['order' => function ($query) {
//                 $query->withSum('product', 'cost');
//             }])->get();

//         foreach ($yard_statistical as $key => $value) {
//             foreach ($value['order'] as $index => $item) {
//                 $yard_statistical[$key]['product_cost'] += $item['product_sum_cost'];
//             }

//             unset($yard_statistical[$key]['order']);
//         }

//         return $yard_statistical;
