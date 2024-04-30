s<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-sm-12">

                                <div style="display:flex; align-items:center; justify-content:space-between">
                                    <h5 class="mt-4">LOẠI SẢN PHẨM: </h5>
                                </div>

                                <div class="card">
                                    <div class="card-body product-type-list">

                                        @foreach($product_type as $key => $value)

                                        <div>
                                            <form action="#" method="post" class="product-type-item">
                                                @csrf
                                                <input type="hidden" value="{{ $key }}" name="index">
                                                <input type="hidden" value="{{ $deleted }}" name="deleted">
                                                <button type="submit" class="btn {{ $key==$index?'active':'' }}">{{ $value['name'] }}</button>
                                            </form>

                                            <form action="product/update_product_type" method="post" class="delete_product-type">
                                                @csrf
                                                <input type="hidden" value="{{ $value['name'] }}" name="pro_type_name">
                                                <input type="hidden" value="{{ $value['id'] }}" name="pro_type_id">
                                                <button class="btn" type="submit">
                                                    <i class="fas fa-wrench"></i>
                                                </button>
                                            </form>

                                        </div>

                                        @endforeach

                                        <div class="add-product-type">
                                            <a href="product/add_product_type" class="btn">
                                                <i class="fas fa-plus"></i>
                                                Thêm
                                            </a>
                                        </div>

                                    </div>
                                </div>

                                <div style="display:flex; align-items:center; justify-content:space-between">
                                    <h5 class="mt-4">SẢN PHẨM: </h5>
                                </div>

                                <div class="card">
                                    <div class="card-body product-list">

                                        <div class="product-list-action">
                                            <a href="product/add_product" class="btn">
                                                <i class="fas fa-plus"></i>
                                                Thêm
                                            </a>
                                            <button type="submit" form="product-deleted" class="btn {{ $deleted?'product-deleted':'' }}">
                                                <i class="fas fa-trash-alt"></i>
                                                Đã xóa
                                            </button>
                                            <form action="{{ URL::to('/product') }}" method="post" id="product-deleted">
                                                @csrf
                                                <input type="hidden" value="{{ !$deleted }}" name="deleted">
                                                <input type="hidden" value="{{ $index }}" name="index">
                                            </form>
                                        </div>

                                        @if(empty($product_type[$index]['product']))
                                        Không có sản phẩm nào
                                        @else

                                        <table class="table">
                                            <thead class="table-header">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Ảnh</th>
                                                    <th scope="col">Tên</th>
                                                    <th scope="col">Giá</th>
                                                    <th scope="col">Số lượng</th>

                                                    <th scope="col">Hành động</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($product_type[$index]['product'] as $key => $value)

                                                <tr>
                                                    <th>{{ $key + 1 }}</th>
                                                    <td>
                                                        <img class="product-image" src="{{ asset('images/'.$value['image_url']) }}" alt="">
                                                    </td>
                                                    <td>{{ $value['name'] }}</td>
                                                    <td>{{ $value['cost'] }}.000</td>
                                                    <th>{{ $value['quantity'] }}</th>
                                                    <td>
                                                        @if($deleted)

                                                        <form id="product-undo" action="{{ URL::to('product/undo_product') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $value['id'] }}">
                                                        </form>
                                                        <button form="product-undo" type="submit" class="btn product-undo">
                                                            <i class="fas fa-redo"></i>
                                                        </button>

                                                        <form id="product-remove" action="{{ URL::to('product/remove_product') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $value['id'] }}">
                                                        </form>
                                                        <button form="product-remove" type="submit" class="btn product-remove">
                                                            <i class="fas fa-times"></i>
                                                        </button>

                                                        @else

                                                        <form id="product-delete" action="{{ URL::to('product/delete_product') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $value['id'] }}">
                                                            <button type="submit" class="btn product-delete">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>

                                                        <form id="product-update" action="{{ URL::to('product/update_product') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $value['id'] }}">
                                                            <button class="btn product-update">
                                                                <i class="fas fa-wrench"></i>
                                                            </button>
                                                        </form>

                                                        @endif
                                                    </td>
                                                </tr>

                                                @endforeach

                                            </tbody>
                                        </table>

                                        @endif

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>