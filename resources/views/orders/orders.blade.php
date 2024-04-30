<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-sm-12">

                                <div style="display:flex; align-items:center; justify-content:space-between">
                                    <h5 class="mt-4 aaa">SÂN ĐANG TRỐNG: </h5>
                                </div>

                                <!-- <ul class="nav nav-pills mb-3 comment-add" id="pills-tab" role="tablist">
                                    <div>
                                        <input form="unvalid" value="" name="string" class="form-control" type="text" placeholder="String...">
                                        <button class="btn btn-primary" form="unvalid" type="submit">Add</button>
                                    </div>
                                </ul> -->

                                <div class="card">

                                    <div class="card-body order-manager yard-free">

                                        @foreach($yard as $value)

                                        @empty($value['order'])

                                        <div class="yard">
                                            <h4 class="yard-header">
                                                Sân {{ $value['number'] }}
                                            </h4>
                                            <div class="yard-body yard-off">

                                                <div class="yard-off-btn">
                                                    <button class="btn btn-warning artisan-order-btn">Nhập tay</button>
                                                    <button class="btn btn-success open-yard-btn">Mở sân</button>
                                                </div>

                                                <form action="{{ URL::to('orders/artisan') }}" method="post" class="artisan-order-form hidden">
                                                    @csrf
                                                    <input type="hidden" name="yard_id" value="{{ $value['id'] }}">

                                                    <div class="input-group">
                                                        <input name="start_hour" type="number" min="0" max="24" class="form-control" placeholder="Giờ vào">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="">:</span>
                                                        </div>
                                                        <input name="start_minute" type="number" min="0" max="59" class="form-control" placeholder="Phút">
                                                    </div>

                                                    <div class="input-group">
                                                        <input name="end_hour" type="number" min="0" max="24" class="form-control" placeholder="Giờ ra">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="">:</span>
                                                        </div>
                                                        <input name="end_minute" type="number" min="0" max="59" class="form-control" placeholder="Phút">
                                                    </div>

                                                    <button class="btn btn-warning" type="submit">Nhập</button>
                                                </form>

                                                <form action="{{ URL::to('orders/add') }}" method="post" class="open-yard-form hidden">
                                                    @csrf
                                                    <input type="hidden" name="yard_id" value="{{ $value['id'] }}">

                                                    <div class="input-group mb-3">
                                                        <input class="form-control" name="prepay_money" type="number" placeholder="Nhập số tiền trả trước">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="border-radius:0 2px 2px 0" id="basic-addon1">.000 đ</span>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <input class="form-control" name="duration" type="text" pattern="[0-9.0-9]+" placeholder="Nhập thời lượng">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="border-radius:0 2px 2px 0" id="basic-addon1">Giờ</span>
                                                        </div>
                                                    </div>

                                                    <div class="input-group">
                                                        <input name="start_hour" type="number" min="0" max="24" class="form-control" placeholder="Giờ vào">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="">:</span>
                                                        </div>
                                                        <input name="start_minute" type="number" min="0" max="59" class="form-control" placeholder="Phút">
                                                    </div>

                                                    <button class="btn btn-success" type="submit">Mở</button>
                                                </form>
                                            </div>

                                        </div>

                                        @endempty

                                        @endforeach

                                    </div>
                                </div>

                                <div style="display:flex; align-items:center; justify-content:space-between">
                                    <h5 class="mt-4">SÂN ĐANG HOẠT ĐỘNG: </h5>
                                </div>

                                <div class="card">
                                    <div class="card-body order-manager yard-active">

                                        @foreach($yard as $value)

                                        @if(!empty($value['order']))

                                        <div class="yard">
                                            <h4 class="yard-header">
                                                Sân {{ $value['number'] }}
                                                <?php if ($value['order'][0]['artisan']) {
                                                    echo " - Nhập tay";
                                                } ?>
                                                <form action="orders/delete" method="post" class="yard-cancel-form">
                                                    @csrf
                                                    <input class="order-id-input" type="hidden" name="id" value="{{ $value['order'][0]['id'] }}">
                                                    <button class="btn yard-cancel" type="submit">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </h4>
                                            <div class="yard-body yard-on">
                                                <p>
                                                    <b>Giờ vào:</b>
                                                    {{ substr($value['order'][0]['time_start'], 11, 5) }}
                                                </p>
                                                <p>
                                                    <b>Thời gian:</b>
                                                    @if($value['order'][0]['duration'])

                                                    {{ $value['order'][0]['duration'] }} Giờ

                                                    @else

                                                    Chưa hẹn giờ

                                                    @endif

                                                </p>
                                                <p>
                                                    <b>Đã thu:</b>
                                                    {{ $value['order'][0]['cost'].'.000 đ' }}
                                                </p>
                                                <p class="yard-body-product">
                                                    <?php $cost = 0;
                                                    $quantity = 0 ?>

                                                    @foreach($value['order'][0]['product'] as $item)

                                                    <?php
                                                    $cost += $item['cost'] * $item['pivot']['quantity_order'];
                                                    $quantity += $item['pivot']['quantity_order'];
                                                    ?>

                                                    @endforeach

                                                    <b>Sản phẩm khác ( {{ $quantity }} ):</b>

                                                    @if(count($value['order'][0]['product']) > 0)

                                                    <span>{{ $cost.'.000 đ' }}</span>
                                                    <a href="#" id="{{ $value['order'][0]['id'] }}" class="yard-product-info">Xem chi tiết</a>

                                                    @else

                                                    <span></span>
                                                    <a href="#" id="{{ $value['order'][0]['id'] }}" class="yard-product-info"></a>

                                                    @endif

                                                </p>
                                            </div>
                                            <div class="yard-footer">

                                                <div class="pay-more">
                                                    <button class="btn one" type="submit">
                                                        <i class="fas fa-hand-holding-usd"></i>
                                                        Thu
                                                    </button>

                                                    <div class="pay-more-model hidden">
                                                        <form action="{{ URL::to('orders/pay_more') }}" method="post" id="pay-more-form">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $value['order'][0]['id'] }}">

                                                            <div class="input-group mb-3">
                                                                <input type="number" class="form-control" name="cost" placeholder="Tiền thu thêm">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">.000</span>
                                                                </div>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-success" type="submit" id="button-addon2">
                                                                        <i class="fas fa-check"></i>
                                                                        Ok
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="dropdown">

                                                    <button class="btn btn-secondary dropdown-toggle two" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-exchange-alt"></i>
                                                        Đổi sân
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                        @foreach($yard as $item)

                                                        @empty($item['order'])

                                                        <a class="dropdown-item" href="orders/change_yard/{{ $value['order'][0]['id'] }}/{{ $item['id'] }}">Sân {{ $item['number'] }}</a>

                                                        @endempty

                                                        @endforeach

                                                    </div>
                                                </div>


                                                <button class="btn yard-add-product three">
                                                    <i class="fas fa-plus"></i>
                                                    Thêm
                                                </button>

                                                <form action="{{ URL::to('orders/checkout') }}" method="post" id="checkout-form">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $value['order'][0]['id'] }}">
                                                    <button class="btn four" type="submit">
                                                        <i class="fas fa-money-bill-wave-alt"></i>
                                                        Thanh toán
                                                    </button>
                                                </form>
                                            </div>

                                        </div>

                                        @endif

                                        @endforeach

                                    </div>
                                </div>

                                <!-- <div style="display:flex; align-items:center;" class="artisan-order">
                                    <h5 class="mt-4 aaa">NHẬP TAY: </h5>

                                    <div class="input-group" style="width:30%">

                                        <input style=" margin-left:10px" type="number" class="form-control artisan-order-input" name="cost" placeholder="Tổng tiền">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">.000</span>
                                        </div>
                                    </div>
                                    <button class="btn artisan-order-product">
                                        <i class="fas fa-feather-alt"></i>
                                        Nhập sản phẩm
                                    </button>
                                    <button class="btn artisan-order-submit">
                                        <i class="fas fa-check"></i>
                                        Hoàn tất
                                    </button>

                                </div> -->

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="model-layout hidden">
    <div class="model hidden">
        <div class="model-header">
            <h3></h3>
        </div>
        <div class="model-body">
            <table class="table">
                <thead class="table-header">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Loại</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Xóa</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="model-footer">
            <div class="model-footer-summary">
                <!-- <b>Tổng:</b> 2 sản phẩm - 100.000 đ -->
            </div>
            <button class="btn model-footer-plus">
                <i class="fas fa-plus"></i>
                Thêm
            </button>
            <button class="btn model-footer-cancel">
                <i class="fas fa-check"></i>
                Ok
            </button>
        </div>
    </div>

    <div class="model-product hidden">
        <div class="model-product-header">
            <h3></h3>
        </div>
        <div class="model-product-body">
            <ul>

            </ul>
            <div>
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thêm</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="model-product-footer">
            <b style="font-weight:bold; font-size:1.2rem">Đã chọn:</b>
            <ul class="model-product-selected">

            </ul>
            <b class="product-total-cost" style="font-weight:bold; font-size:1.2rem; margin-left:12px">
                Tổng: 0.000 đ
            </b>
            <button class="btn model-footer-cancel">
                <i class="fas fa-times"></i>
                Hủy
            </button>
            <button class="btn model-product-footer-plus">
                <i class="fas fa-check"></i>
                Ok
            </button>
        </div>
    </div>

    <div class="model-delete hidden">
        <p>Bạn có chắc muốn xóa?</p>
        <div>
            <button class="btn model-delete-accept">Có</button>
            <button class="btn model-delete-cancel">Không</button>
        </div>
    </div>
</div>

<script>
    $('.artisan-order-btn').each(function(index) {
        $(this).click(function(e) {
            e.stopPropagation();
            document.querySelectorAll('.artisan-order-form')[index].classList.remove("hidden");
            document.querySelectorAll('.yard-off-btn')[index].classList.add("hidden");
        });
    });

    $('.open-yard-btn').each(function(index) {
        $(this).click(function(e) {
            e.stopPropagation();
            document.querySelectorAll('.open-yard-form')[index].classList.remove("hidden");
            document.querySelectorAll('.yard-off-btn')[index].classList.add("hidden");
        });
    });

    $('.artisan-order-form, .open-yard-form').click(function(e) {
        e.stopPropagation();
    });

    $('.yard-free .yard').each(function(index) {
        $(this).click(function() {
            document.querySelectorAll('.artisan-order-form')[index].classList.add("hidden");
            document.querySelectorAll('.open-yard-form')[index].classList.add("hidden");
            document.querySelectorAll('.yard-off-btn')[index].classList.remove("hidden");
        });
    });

    function toggleShowEmptyYard(index) {

    }

    $('.pay-more').each(function(index) {
        $(this).click(function() {
            payMoreForm[index].classList.toggle('hidden');
        });
    })

    $('.pay-more-model').click(function(e) {
        e.stopPropagation();
    });

    var selectedProduct = [];
    var totalCost = 0;

    var payMoreForm = document.querySelectorAll('.pay-more-model');
    var emptyYardForm = document.querySelectorAll('.open-yard-form');
    var emptyYardStatus = document.querySelectorAll('.yard-off .empty-yard');
    var yardProductInfoButton = document.querySelectorAll('.yard-product-info');
    var modelLayout = document.querySelector('.model-layout');
    var model = document.querySelector('.model-layout .model');
    var modelProduct = document.querySelector('.model-layout .model-product');
    var modelDelete = document.querySelector('.model-delete');
    var exitModelBtn = document.querySelectorAll('.model-footer-cancel');
    var yardAddProductBtn = document.querySelectorAll('.yard-add-product');

    function turnOffModel() {
        modelLayout.classList.add('hidden');
        modelLayout.classList.remove('layout-model-appear');

        model.classList.add('hidden');
        modelProduct.classList.add('hidden');
        modelDelete.classList.add('hidden');

        model.classList.remove('model-appear');
        modelProduct.classList.remove('model-appear');
        modelDelete.classList.remove('model-appear');
    }

    function turnOnModel() {
        modelLayout.classList.remove('hidden');
        modelLayout.classList.add('layout-model-appear');
    }

    function updateSelectedProduct() {
        let selectedProductMsg = '';

        selectedProduct.forEach(item =>
            selectedProductMsg += `
                    <li>
                        ${item.name} - ${item.quantity}
                        <a href="#" class="selected-product-delete">
                            <i class="fas fa-times"></i>
                        </a>
                    </li>
                    `
        );

        $('.product-total-cost').html('Tổng: ' + totalCost + '.000 đ');

        $('.model-product-selected').html(selectedProductMsg == '' ? 'Chưa có sản phẩm nào' : selectedProductMsg);

        $('.selected-product-delete').each(function(key) {
            $(this).click(function() {
                totalCost -= selectedProduct[key].quantity * selectedProduct[key].cost;

                $('.product-total-cost').html('Tổng: ' + totalCost + '.000 đ');

                selectedProduct.splice(key, 1);

                updateSelectedProduct();
            });
        });
    }

    function handleOrderProduct(key) {
        $.ajax({
            url: "{{ URL::to('orders/add_product') }}",
            method: 'post',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                orders_id: $('.order-id-input')[key].value,
                product: selectedProduct,
            },
            success: (res) => {
                $('.yard-body-product b')[key].innerHTML = `
                    Sản phẩm khác ( ${res.quantity} ):
                `;

                $('.yard-body-product span')[key].innerHTML = `
                    ${res.cost}.000 đ
                `;

                $('.yard-body-product a')[key].innerHTML = `
                    Xem chi tiết
                `;

                turnOffModel();
            }
        });
    }

    function handleAddProduct(typeId, yardId) {
        $.ajax({
            url: `{{ URL::to('orders/show_menu') }}`,
            type: 'post',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: (res) => {
                let navMsg = '';
                let tableMsg = '';

                res.forEach((item, key) => {
                    navMsg += `
                    <li>
                        <a id="${key}" href="#" class="${typeId == key?'active':''}">${item.name}</a>
                    </li>
                    `;
                })

                res[typeId].product.forEach((item, key) => {
                    tableMsg += `
                    <tr>
                        <th>${key + 1}</th>
                        <td class="product-id hidden">${item.id}</td>
                        <td>
                            <img class="order-product-image" src="{{ asset('images/${item.image_url}') }}">
                        </td>
                        <td class="product-name">${item.name}</td>
                        <td class="product-cost">${item.cost + '.000'}</td>
                        <td class="add-product-quantity">
                            <button class="add-product-quantity-minus">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" min="1" max="${item.quantity}" value="1" class="product-quantity">

                            <button class="add-product-quantity-plus">
                                <i class="fas fa-plus"></i>
                            </button>
                        </td>
                        <td class="add-product-btn">
                            <a href="#">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </td>
                    </tr>
                    `;
                });

                $('.model-product-body table tbody').html(tableMsg);

                $('.model-product-body>ul').html(navMsg);

                $('.model-product-header h3').html("Menu - Sân " + yardId);

                $('.model-product-header h3').prop('id', yardId);

                $('.add-product-quantity-plus').each(function(key) {
                    $(this).click(() => {
                        if ($('.add-product-quantity input')[key].value < Number($('.add-product-quantity input')[key].max)) {
                            $('.add-product-quantity input')[key].value = Number($('.add-product-quantity input')[key].value) + 1;
                        }
                    })
                })

                $('.add-product-quantity-minus').each(function(key) {
                    $(this).click(() => {
                        if ($('.add-product-quantity input')[key].value > 1) {
                            $('.add-product-quantity input')[key].value = Number($('.add-product-quantity input')[key].value) - 1;
                        }
                    })
                })

                $('.add-product-btn a').each(function(key) {
                    $(this).click(() => {
                        let name = $('.product-name')[key].innerText;
                        let id = Number($('.product-id')[key].innerText);
                        let quantity = Number($('.product-quantity')[key].value);
                        let cost = Number($('.product-cost')[key].innerText);

                        totalCost += cost * quantity;

                        $('.product-total-cost').html('Tổng: ' + totalCost + '.000 đ');

                        let checkExist = 1;

                        for (let key in selectedProduct) {
                            if (selectedProduct[key].name == name) {
                                selectedProduct[key].quantity += quantity;
                                checkExist = 0;
                                break;
                            }
                        }

                        if (checkExist) {
                            selectedProduct.push({
                                id: id,
                                name: name,
                                quantity: quantity,
                                cost: cost
                            });
                        }

                        updateSelectedProduct();
                    })
                })

                $('.model-product-body ul li a').each(function(typeKey) {
                    $(this).click(function() {
                        if (typeId != typeKey) {
                            handleAddProduct(typeKey, yardId);
                        }
                    })
                });
            }
        })
    }

    function startProductModel(key, check, _selectedProduct, _totalCost, okHidden) {
        selectedProduct = _selectedProduct;
        totalCost = _totalCost;
        updateSelectedProduct();
        handleAddProduct(0, Number(key) + 1);
        turnOnModel();
        modelProduct.classList.remove('hidden');
        modelProduct.classList.add('model-appear');

        if (okHidden) {
            document.querySelector('.model-product-footer-plus').classList.add('hidden');
        } else {
            document.querySelector('.model-product-footer-plus').classList.remove('hidden');
        }
    }

    $('.yard-cancel-form').each(function(index) {
        $(this).submit(function(e) {
            turnOnModel();
            modelDelete.classList.remove('hidden');
            modelDelete.classList.add('model-appear');
            $('.model-delete').prop('id', index);
            e.preventDefault();
        });
    });

    $('.model-delete-accept').click(function() {
        $('.yard-cancel-form')[$('.model-delete').prop('id')].submit();
    });

    $('.model-delete-cancel').click(function() {
        turnOffModel();
    });

    //nut them san pham o model menu
    $('.model-product-footer-plus').click(function() {
        if (selectedProduct.length > 0) {
            handleOrderProduct($('.model-product-header h3').prop('id') - 1);
            console.log(selectedProduct)
        } else {
            turnOffModel();
        }
    });

    //nut mo model menu tu model danh sach san pham da mua
    $('.model-footer-plus').click(function() {
        turnOffModel();
        startProductModel($('.model-header h3').prop('id'), 1, [], 0, 0)
    });

    //nut mo model san pham
    yardAddProductBtn.forEach((item, key) => {
        item.onclick = () => {
            startProductModel(key, 1, [], 0, 0)
        }
    })

    //nut thoat model danh sach san pham
    exitModelBtn.forEach(item => {
        item.onclick = () => {
            turnOffModel();
        }
    })

    modelLayout.onclick = () => {
        turnOffModel();
    }

    model.onclick = (e) => {
        e.stopPropagation();
    }

    modelProduct.onclick = (e) => {
        e.stopPropagation();
    }

    modelDelete.onclick = (e) => {
        e.stopPropagation();
    }

    //nut mo model danh sach san pham
    yardProductInfoButton.forEach((item, key) => {
        item.onclick = (e) => {
            $.ajax({
                url: "{{ URL::to('orders/show_product') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    orders_id: item.id
                },
                success: (res) => {
                    let quantity = 0;
                    let msg = '';
                    let cost = 0;

                    res.forEach((item, key) => {
                        quantity += item.pivot.quantity_order;

                        msg += `
                        <tr class="model-show-product" id="${item.id}">
                            <th scope="row">${key + 1}</th>
                            <td>
                                <img class="order-product-image" src="{{ asset('images/${item.image_url}') }}">
                            </td>
                            <td>${item.name}</td>
                            <td>${item.type.name}</td>
                            <td>${item.cost}.000</td>
                            <td>${item.pivot.quantity_order}</td>
                            <td class="model-show-delete"><i class="fas fa-times"></i></td>
                        </tr>
                        `;

                        cost += item.cost * item.pivot.quantity_order;
                    });

                    $('.model-header h3').html('Sân ' + (key + 1) + ' (' + quantity + ')');
                    $('.model-header h3').prop('id', key);
                    $('.model-body table tbody').html(msg);
                    $('.model-footer-summary').html('<b>Tổng:</b> ' + quantity + ' - ' + cost + '.000 đ');

                    $('.model-show-delete').each(function(index) {
                        $(this).click(function() {
                            $.ajax({
                                url: "{{ URL::to('orders/delete_product') }}",
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    orders_id: item.id,
                                    product_id: $('.model-show-product')[index].id
                                },
                                success: (res) => {
                                    $('.model-footer-summary').html(`
                                        <b>Tổng: </b>
                                        ${res.total.quantity} - ${res.total.cost}.000 đ
                                    `);

                                    $('.yard-body-product b')[key].innerHTML = `
                                        Sản phẩm khác ( ${res.total.quantity} ):
                                    `;

                                    let cost = '';
                                    let aTagMsg = '';
                                    let msg = '';

                                    if (res.total.cost > 0) {
                                        cost = res.total.cost + '.000 đ';
                                        aTagMsg = 'Xem chi tiết';
                                    }

                                    $('.yard-body-product span')[key].innerHTML = `
                                        ${cost}
                                    `;

                                    $('.yard-body-product a')[key].innerHTML = `
                                        ${aTagMsg}
                                    `;

                                    res.orderProduct.forEach((item, key) => {
                                        msg += `
                                        <tr class="model-show-product" id="${item.id}">
                                            <th scope="row">${key + 1}</th>
                                            <td>
                                                <img class="order-product-image" src="{{ asset('images/${item.image_url}') }}">
                                            </td>
                                            <td>${item.name}</td>
                                            <td>${item.type.name}</td>
                                            <td>${item.cost}.000</td>
                                            <td>${item.pivot.quantity_order}</td>
                                            <td class="model-show-delete"><i class="fas fa-times"></i></td>
                                        </tr>
                                        `;
                                    });

                                    $('.model-header h3').html('Sân ' + (key + 1) + ' (' + res.total.quantity + ')');

                                    $('.model-body table tbody').html(msg);
                                }
                            });
                        });
                    });

                    turnOnModel();
                    model.classList.remove('hidden');
                    model.classList.add('model-appear');
                }
            });
        }
    })
</script>