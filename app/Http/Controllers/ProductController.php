<?php

namespace App\Http\Controllers;

use App\Models\OrdersProduct;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if(isset($request->deleted)){
            $deleted = $request->deleted;
        }
        else{
            $deleted = 0;
        }

        if (isset($request->index)) {
            $index = $request->index;
        } else {
            $index = 0;
        }

        if (!$deleted) {
            $product_type = Type::with(['product' => function ($query) {
                $query->where('status', 1);
            }])->get()->toArray();
        } else {
            $product_type = Type::with(['product' => function ($query) {
                $query->where('status', 0);
            }])->get()->toArray();
        }

        $product = $product_type[$index]['product'];

        $data = [
            'product_type' => $product_type,
            'product' => $product,
            'index' => $index,
            'deleted' => $deleted
        ];

        return view('layout', [
            'data' => $data,
            'content' => 'product/product'
        ]);
    }

    public function deleteProductType(Request $request)
    {
        $pro_type_id = $request->pro_type_id;

        Type::where('id', $pro_type_id)->delete();

        return redirect('/product');
    }

    public function handleAddProType(Request $request)
    {
        $pro_type_name = $request->pro_type_name;

        Type::insert([
            'name' => $pro_type_name,
        ]);

        return redirect('/product');
    }

    public function updateProductType(Request $request)
    {
        $pro_type_id = $request->pro_type_id;
        $pro_type_name = $request->pro_type_name;

        $can_delete = empty(Type::find($pro_type_id)->product->toArray());

        return view('layout', [
            'data' => [
                'title' => 'CHỈNH SỬA LOẠI SẢN PHẨM',
                'action' => 'handle_update_product_type',
                'id' => $pro_type_id,
                'name' => $pro_type_name,
                'can_delete' => $can_delete
            ],
            'content' => 'product/action_product_type'
        ]);
    }

    public function handleUpdateProType(Request $request)
    {
        $pro_type_name = $request->pro_type_name;
        $pro_type_id = $request->pro_type_id;

        Type::where('id', $pro_type_id)->update([
            'name' => $pro_type_name
        ]);

        return redirect('/product');
    }

    public function handleAddProduct(Request $request)
    {
        $name = $request->name;
        $type = $request->type;
        $cost = $request->cost;
        $quantity = $request->quantity;
        $image = $request->file('image');

        $product = new Product([
            'name' => $name,
            'cost' => $cost,
            'type_id' => $type,
            'quantity' => $quantity,
            'image_url' => $image->getClientOriginalName(),
            'status' => 1
        ]);

        $type = Type::find($type);

        $type->product()->save($product);

        $image->move(base_path('/public/images'), $image->getClientOriginalName());

        return redirect('/product');
    }

    public function deleteProduct(Request $request)
    {
        $id = $request->product_id;

        Product::where('id', $id)->update([
            'status' => 0
        ]);

        return redirect('/product');
    }

    public function undoProduct(Request $request)
    {
        $id = $request->product_id;

        Product::where('id', $id)->update([
            'status' => 1
        ]);

        return redirect('/product1');
    }

    public function updateProduct(Request $request)
    {
        $id = $request->product_id;

        $product = Product::with('type')->where('id', $id)->get()->toArray();
        $product_type = Type::all()->toArray();

        $data = [
            'product' => $product[0],
            'product_type' => $product_type,
        ];

        return view('layout', [
            'data' => $data,
            'content' => 'product/update_product'
        ]);
    }

    public function handleUpdateProduct(Request $request)
    {
        $data_request =  $request->all();

        $id = $data_request['id'];

        unset($data_request['_token']);
        unset($data_request['image']);
        unset($data_request['id']);

        $old_image_url = Product::where('id', $id)->get()->toArray()[0]['image_url'];

        $data_update = [];

        foreach ($data_request as $key => $value) {
            if ($value) {
                $data_update[$key] = $value;
            }
        }

        if ($request->hasFile('image')) {
            $image =  $request->file('image');
            $data_update['image_url'] = $image->getClientOriginalName();
            File::delete(base_path('public/images/' . $old_image_url));
            $image->move(base_path('/public/images'), $data_update['image_url']);
        }

        Product::where('id', $id)->update($data_update);

        return redirect('/product');
    }

    public function removeProduct(Request $request)
    {
        $id = $request->product_id;

        $can_remove = empty(OrdersProduct::where('product_id', $id)->get()->toArray());

        if ($can_remove) {
            Product::where('id', $id)->delete();
        }

        return redirect('/product');
    }
}
