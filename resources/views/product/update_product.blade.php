<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-sm-12">

                                <div style="display:flex; align-items:center; justify-content:space-between">
                                    <h5 class="mt-4">CHỈNH SỬA SẢN PHẨM: </h5>
                                </div>

                                <div class="card">
                                    <div class="card-body">


                                        <table class="table table-bordered">
                                            <thead class="table-header">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Thông tin</th>
                                                    <th scope="col">Chỉnh sửa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <form action="{{ URL::to('product/handle_update_product') }}" method="post" id="update-product-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                                                    <tr>
                                                        <th>Tên</th>
                                                        <td>{{ $product['name'] }}</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" name="name" class="form-control" placeholder="Nhập tên mới của sản phẩm">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Loại</th>
                                                        <td>{{ $product['type']['name'] }}</td>
                                                        <td>
                                                            <div class="form-group">
                                                                <select class="form-control" name="type_id">
                                                                    <option selected hidden value="">Chọn tên loại mới của sản phẩm</option>

                                                                    @foreach($product_type as $value)

                                                                    <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>

                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Giá</th>
                                                        <td>{{ $product['cost'] }}.000</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="number" name="cost" class="form-control" placeholder="Nhập giá mới của sản phẩm">
                                                                <span class="input-group-text" id="basic-addon1">.000</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Số lượng</th>
                                                        <td>{{ $product['quantity'] }}</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="number" name="quantity" class="form-control" placeholder="Nhập số lượng mới của sản phẩm">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ảnh</th>
                                                        <td>
                                                            <img style="width:120px" src="{{ asset('images/'.$product['image_url']) }}" alt="">
                                                        </td>
                                                        <td class="update-product-image">
                                                            <div>
                                                                <label for="image">
                                                                    <img class="show-image update" src="{{ asset('images\no-image.png') }}" alt="">
                                                                </label>
                                                                <input id="image" name="image" type="file">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </form>
                                            </tbody>
                                        </table>

                                        <button class="btn update-product-submit" type="submit" form="update-product-form">
                                            <i class="fas fa-check"></i>
                                            Lưu
                                        </button>

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