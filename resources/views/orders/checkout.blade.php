<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-sm-12">

                                <div class="card checkout-card">

                                    <div class="card-body">
                                        <header class="checkout-header">
                                            <div>
                                                <img src="{{ asset('images\main_logo.png') }}" alt="">
                                            </div>
                                            <div>
                                                <h3>- SÂN VẬN ĐỘNG BÌNH ĐẠI -</h3>
                                                <h4>Hóa đơn sân {{ $order['yard']['number'] }}</h4>
                                            </div>
                                        </header>

                                        <div class="checkout-body">

                                            <div class="checkout-body-product">
                                                <table class="table">
                                                    <thead class="table-header">
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Tên</th>
                                                            <th scope="col">Loại</th>
                                                            <th scope="col">Giá</th>
                                                            <th scope="col">Số lượng</th>
                                                            <th scope="col">Thành tiền</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $total_product_cost = 0; ?>

                                                        @foreach($order['product'] as $key => $value)

                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $value['name'] }}</td>
                                                            <td>{{ $value['type']['name'] }}</td>
                                                            <td>{{ $value['cost'] }}.000</td>
                                                            <td>{{ $value['pivot']['quantity_order'] }}</td>
                                                            <td>{{ $value['pivot']['quantity_order'] * $value['cost'] }}.000</td>
                                                        </tr>

                                                        <?php $total_product_cost +=  $value['pivot']['quantity_order'] * $value['cost'] ?>

                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                            <hr>

                                            <div class="checkout-body-yard">
                                                <div>
                                                    <p><b>Giờ vào: </b>{{ substr($order['time_start'], 11, 5) }}</p>
                                                    <p><b>Giờ ra: </b>{{ substr($order['time_end'], 11, 5) }}</p>
                                                    <p><b>Tổng thời gian: </b>{{ floor($order['duration']).':'.(($order['duration'] - floor($order['duration'])) * 60) }}</p>
                                                    <p><b>Đơn giá:</b> {{ $order['yard']['cost'] }}.000 đ / h</p>
                                                </div>
                                                <div class="checkout-body-yard-summary">
                                                    <div>
                                                        <p><b>Tổng tiền sản phẩm: </b></p>
                                                        <p>{{ $total_product_cost }}.000 đ</p>
                                                    </div>
                                                    <div>
                                                        <p><b>Tổng tiền sân: </b></p>
                                                        <p>{{ round($order['duration'] * $order['yard']['cost']) }}.000 đ</p>
                                                    </div>
                                                    <div>
                                                        <p><b>Trả trước: </b></p>
                                                        <p>{{ $order['cost'] }}.000 đ</p>
                                                    </div>
                                                    <hr>
                                                    <div class="total-money">
                                                        <p><b>Thành tiền: </b></p>
                                                        <?php $total = ($total_product_cost + round($order['duration'] * $order['yard']['cost'])) - $order['cost']; ?>
                                                        <p>{{ $total }}.000 đ</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <footer class="checkout-footer">
                                            <form action="checkout_success" method="post">
                                                @csrf
                                                <input type="hidden" value="{{ $order['id'] }}" name="order_id">
                                                <input type="hidden" value="{{ $order['time_end'] }}" name="time_end">
                                                <input type="hidden" value="{{ $total + $order['cost'] }}" name="cost">
                                                <input type="hidden" value="{{ $order['duration'] }}" name="duration">
                                                <button type="submit" class="btn">
                                                    <i class="fas fa-check"></i>
                                                    Hoàn tất
                                                </button>
                                            </form>
                                        </footer>
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