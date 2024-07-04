@extends('welcome1')
@section('content')
    <section class="">
            @foreach($edit_moi_truong as $key => $edit_value)
                <form class="modal-content animate" action="{{ URL::to('/update-moi-truong/'.$edit_value->id_moi_truong) }}" method="post">
                    {{ csrf_field() }}
                    <div class="box box-primary">
                        <div class="box-header with-border" style="text-align: center;">
                          <h3 class="box-title">CHỈNH SỬA MÔI TRƯỜNG</h3>
                          <p style="color: rgb(224, 73, 73)">{{ $ten_ao }} - {{ $ten_khu }} - {{ $ten_vu }} - {{ $ngay }}</p>
                        </div>
                        <div class="message" style="text-align: center;">
                            @php
                                $message = session('message');
                                if ($message) {
                                    echo '<span class="thong-bao-mess">', $message . '</span>';
                                    session()->forget('message');
                                }
                            @endphp
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                          <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Độ kiềm (mg/L) <span style="color: red">*</span></label>
                                <input name="do_kiem" type="number" class="form-control" value="{{ $edit_value->do_kiem }}" placeholder="Độ kiềm (mg/L)">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Độ pH <span style="color: red">*</span></label>
                                <input name="do_ph" type="number" step="any" class="form-control" value="{{ $edit_value->do_ph }}" placeholder="Độ pH">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhiệt độ không khí sáng (°C) <span style="color: red">*</span></label>
                                <input name="to_khong_khi_sang" type="number" class="form-control"
                                value="{{ $edit_value->to_khong_khi_sang }}" placeholder="Nhiệt độ không khí sáng (°C)">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhiệt độ không khí chiều (°C) <span style="color: red">*</span></label>
                                <input name="to_khong_khi_chieu" type="number" class="form-control"
                                value="{{ $edit_value->to_khong_khi_chieu }}" placeholder="Nhiệt độ không khí chiều (°C)">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhiệt độ nước sáng (°C) <span style="color: red">*</span></label>
                                <input name="to_nuoc_sang" type="number" class="form-control" value="{{ $edit_value->to_nuoc_sang }}" placeholder="Nhiệt độ nước sáng (°C)">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhiệt độ nước chiều (°C) <span style="color: red">*</span></label>
                                <input name="to_nuoc_chieu" type="number" value="{{ $edit_value->to_nuoc_chieu }}" class="form-control"
                                placeholder="Nhiệt độ nước chiều (°C)">
                            </div>
                          </div>
                          <!-- /.box-body -->
                          <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ url()->previous() }}">
                                <span class="btn btn-primary" style="background-color: rgb(245, 132, 132)">Thoát</span>
                            </a>
                        </div>
                        </form>
                    </div>
                </form>
            @endforeach
    </section>
@endsection
