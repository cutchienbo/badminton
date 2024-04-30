<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-sm-12">

                                <div style="display:flex; align-items:center; justify-content:space-between">
                                    <h5 class="mt-4 aaa">{{ $title }}: </h5>
                                </div>

                                <div class="card">
                                    <div class="card-body">

                                        <form action="{{ $action }}" method="post">
                                            @csrf

                                            <div class="form-group">
                                                <label for="product-type-name">Tên loại sản phẩm</label>

                                                @if(isset($id))

                                                <input type="hidden" name="pro_type_id" value="{{ $id }}">

                                                @endif

                                                <input id="product-type-name" type="text" class="form-control" value="{{ isset($name)?$name:'' }}" name="pro_type_name" placeholder="Tên loại sản phẩm mới">
                                            </div>

                                            <button class="btn" style="color:#fff; background-color: #248b50; border-radius: 0 2px 2px 0">
                                                @if(isset($id))

                                                <i class="fas fa-check"></i>
                                                Lưu tên mới

                                                @else

                                                <i class="fas fa-plus"></i>
                                                Thêm

                                                @endif
                                            </button>

                                        </form>

                                        @if(isset($can_delete))

                                        @if($can_delete)

                                        <form action="delete_product_type" method="post">
                                            @csrf
                                            <input type="hidden" name="pro_type_id" value="{{ $id }}" required>
                                            <button type="submit" class="btn" style="color:#fff; background-color: #c21d17">
                                                <i class="fas fa-times"></i>
                                                Xóa loại sản phẩm
                                            </button>
                                        </form>

                                        @endif

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