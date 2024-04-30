<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-sm-12">

                                <div style="display:flex; align-items:center; justify-content:space-between">
                                    <h5 class="mt-4">THÊM SẢN PHẨM MỚI:</h5>
                                </div>

                                <div class="card" style="flex-direction:row">

                                    <div class="card-body col-sm-6 col-12">

                                        <form id="add-product-form" action="handle_add_product" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label for="name">Tên</label>
                                                <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Nhập tên sản phẩm" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">Tên loại</label>
                                                <select class="form-control" name="type" required>
                                                    <option selected hidden>Chọn tên loại sản phẩm</option>

                                                    @foreach($product_type as $value)

                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>

                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="cost">Giá tiền</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" name="cost" class="form-control" id="cost" placeholder="Nhập giá tiền sản phẩm" required>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">.000 đ</span>
                                                    </div>
                                                </div>
                                                <small id="emailHelp" class="form-text text-muted">Giá tiền nhập theo đơn vị chục ngàn</small>
                                            </div>

                                            <div class="form-group">
                                                <label for="quantity">Số lượng</label>
                                                <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Nhập số lượng sản phẩm" required>
                                            </div>

                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-plus"></i>
                                                Thêm
                                            </button>
                                        </form>

                                    </div>
                                    <div class="card-body col-sm-6 col-12 add-product-image">

                                        <label for="image">
                                            <img class="show-image" src="{{ asset('images\no-image.png') }}" alt="">
                                        </label>
                                        <input id="image" name="image" type="file" form="add-product-form" required>

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
