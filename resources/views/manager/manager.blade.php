<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-sm-12">

                                <div style="display:flex; align-items:center; justify-content:space-between">
                                    <h5 class="mt-4">KẾT NGÀY:</h5>
                                </div>

                                <div class="card" style="flex-direction:row">

                                    <div class="card-body" style="display:flex; justify-content:center">

                                        <form action="{{ URL::to('manager/summary_price') }}" method="post">
                                            @csrf

                                            <button class="btn update-product-submit" type="submit">
                                                <i class="fas fa-check"></i>
                                                Tổng kết
                                            </button>
                                        </form>

                                    </div>

                                </div>

                                <div style="display:flex; align-items:center; justify-content:space-between">
                                    <h5 class="mt-4">THỐNG KÊ:</h5>
                                </div>

                                <div class="card">

                                    <div class="card-body">

                                        <form action="{{ URL::to('manager/receive_statistical') }}" method="post">
                                            @csrf
                                            <div class="statistical-form">
                                                <div class="form-group">

                                                    <input value="{{ old('day') }}" pattern="[0-9]{1,2}" min="1" max="31" name="day" type="text" class="form-control" id="day" placeholder="Nhập ngày">
                                                </div>

                                                <div class="form-group">

                                                    <input value="{{ old('month') }}" pattern="[0-9]{1,2}" min="1" max="12" name="month" type="text" class="form-control" id="month" placeholder="Nhập tháng">
                                                </div>

                                                <div class="form-group">

                                                    <input value="{{ old('year') }}" pattern="[0-9]{4}" name="year" type="text" class="form-control" id="year" placeholder="Nhập năm" required>
                                                </div>

                                                <div>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-check"></i>
                                                        Ok
                                                    </button>
                                                </div>
                                            </div>

                                        </form>

                                        @if(session()->has('statistical'))

                                        <?php
                                        $statistical = session()->get('statistical');
                                        $total = 0;
                                        $pro_total = 0;
                                        $duration = 0;
                                        ?>
                                        <h5>Thu nhập</h5>
                                        <table class="table table-bordered">
                                            <thead class="table-header">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">
                                                        @if($statistical['type'] == 'year' || $statistical['type'] == 'year_day')
                                                        Tháng
                                                        @elseif($statistical['type'] == 'year_month')
                                                        Ngày
                                                        @else
                                                        Thời gian
                                                        @endif

                                                    </th>
                                                    <th scope="col">Giờ hoạt động</th>
                                                    <th scope="col">Tiền sân</th>
                                                    <th scope="col">Tiền sản phẩm</th>
                                                    <th scope="col">Thu nhập</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($statistical['income'] as $key => $value)

                                                <tr>
                                                    <th>{{ $key + 1 }}</th>
                                                    <td>{{ $value['dates'] }}</td>
                                                    <td>{{ $value['duration'] }}</td>
                                                    <td>{{ $value['cost'] - $value['product_sum_cost'] }}.000</td>
                                                    <td>{{ $value['product_sum_cost'] }}.000</td>
                                                    <td>{{ $value['cost'] }}.000</td>
                                                </tr>
                                                <?php
                                                $total += $value['cost'];
                                                $pro_total += $value['product_sum_cost'];
                                                $duration += $value['duration'];
                                                ?>
                                                @endforeach
                                                @if(count($statistical['income']) > 1)
                                                <tr>
                                                    <th> Tổng </th>
                                                    <td>---</td>
                                                    <td>{{ $duration }}</td>
                                                    <td>{{ $total - $pro_total}}.000</td>
                                                    <td>{{ $pro_total }}.000</td>
                                                    <td>{{ $total }}.000</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>

                                        @endif

                                    </div>
                                    @if(session()->has('statistical'))

                                    @if($statistical['type'] != 'year_day')

                                    <div class="card-body">
                                        <h5>Sân cầu -
                                            @if($statistical['type'] == 'year')
                                            Năm
                                            @elseif($statistical['type'] == 'year_month')
                                            Tháng
                                            @else
                                            Ngày
                                            @endif
                                        </h5>

                                        <table class="table table-bordered">
                                            <thead class="table-header">
                                                <tr>
                                                    <th scope="col">Sân</th>
                                                    <th scope="col">Giờ hoạt động</th>
                                                    <th scope="col">Tiền sân</th>
                                                    <th scope="col">Tiền sản phẩm</th>
                                                    <th scope="col">Tổng tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($statistical['yard'] as $key => $value)
                                                <?php
                                                if (!$value['pro_cost']) {
                                                    $value['pro_cost'] = 0;
                                                }
                                                ?>
                                                <tr>
                                                    <th>{{ $value['number'] }}</th>
                                                    <td>{{ $value['duration'] }}</td>
                                                    <td>{{ $value['cost'] - $value['pro_cost'] }}.000</td>
                                                    <td>{{ $value['pro_cost'] }}.000</td>
                                                    <td>{{ $value['cost'] }}.000</td>
                                                </tr>

                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                    @endif
                                    @endif

                                </div>

                                <div style="display:flex; align-items:center; justify-content:space-between">
                                    <h5 class="mt-4">CÀI ĐẶT SÂN CẦU:</h5>
                                </div>

                                <div class="card" style="flex-direction:row">

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
                                                <form action="{{ URL::to('manager/handle_update_info') }}" method="post" id="manager-form">
                                                    @csrf

                                                    <tr>
                                                        <th>Số lượng sân cầu</th>
                                                        <td>{{ $yard_quantity }}</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="hidden" name="old_quantity" class="form-control" value="{{ $yard_quantity }}">
                                                                <input type="number" name="quantity" class="form-control" placeholder="Nhập số lượng sân mới">
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Giá tiền</th>
                                                        <td>{{ $yard_price }}.000 / H</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="hidden" name="old_cost" class="form-control" value="{{ $yard_price }}">
                                                                <input type="number" name="cost" class="form-control" placeholder="Nhập giá mới">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3">.000</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Mật khẩu</th>
                                                        <td>{{ $password }}</td>
                                                        <td>
                                                            <div class="input-group">

                                                                <input type="text" name="password" class="form-control" placeholder="Nhập mật khẩu mới">

                                                            </div>
                                                        </td>
                                                    </tr>

                                                </form>
                                            </tbody>
                                        </table>

                                        <button class="btn update-product-submit" type="submit" form="manager-form">
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