@extends('welcome1')
@section('content')
    <form class="modal-content animate" action="{{ URL::to('/save-moi-truong/'.$id_chi_tiet_ao) }}" method="post">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border" style="text-align: center;">
                <p class="box-title" >Thêm chỉ số môi trường</p>
            </div>
            <div class="message" style="text-align: center;">
                <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="thong-bao-mess">', $message . '</span>';
                        Session::put('message', null);
                    }
                ?>
            </div>
            <input type="hidden" name="id_chi_tiet_ao" value="{{ $id_chi_tiet_ao }}">
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Độ kiềm (mg/L) <span style="color: red">*</span></label>
                        <input name="do_kiem" type="number" class="form-control" placeholder="Độ kiềm (mg/L)">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Độ pH <span style="color: red">*</span></label>
                        <input name="do_ph" type="number" step="any" class="form-control" placeholder="Độ pH">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nhiệt độ không khí sáng (°C) <span style="color: red">*</span></label>
                        <input name="to_khong_khi_sang" type="number" class="form-control"
                        placeholder="Nhiệt độ không khí sáng (°C)">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nhiệt độ không khí chiều (°C) <span style="color: red">*</span></label>
                        <input name="to_khong_khi_chieu" type="number" class="form-control"
                        placeholder="Nhiệt độ không khí chiều (°C)">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nhiệt độ nước sáng (°C) <span style="color: red">*</span></label>
                        <input name="to_nuoc_sang" type="number" class="form-control" placeholder="Nhiệt độ nước sáng (°C)">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nhiệt độ nước chiều (°C) <span style="color: red">*</span></label>
                        <input name="to_nuoc_chieu" type="number" class="form-control"
                        placeholder="Nhiệt độ nước chiều (°C)">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="/chi-tiet-ao">
                        <p type="" class="btn btn-default">Thoát</p>
                    </a>
                    <button type="submit" class="btn btn-info pull-right">Thêm chi tiết</button>
                  </div>
            </form>
        </div>
        {{-- <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Horizontal Form</h3>
            </div>
            <input type="hidden" name="id_chi_tiet_ao" value="{{ $id_chi_tiet_ao }}">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Độ kiềm</label>
                        <div class="col-sm-10">
                            <input name="do_kiem" type="number" class="form-control" placeholder="Độ kiềm">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Độ pH</label>
                        <div class="col-sm-10">
                            <input name="do_ph" type="number" class="form-control" placeholder="Độ pH">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nhiệt độ KK sáng</label>
                        <div class="col-sm-10">
                            <input name="to_khong_khi_sang" type="number" class="form-control"
                                placeholder="Nhiệt độ không khí sáng">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nhiệt độ KK chiều</label>
                        <div class="col-sm-10">
                            <input name="to_khong_khi_chieu" type="number" class="form-control"
                                placeholder="Nhiệt độ không khí chiều">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nhiệt độ nước sáng</label>
                        <div class="col-sm-10">
                            <input name="to_nuoc_sang" type="number" class="form-control" placeholder="Nhiệt độ nước sáng">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nhiệt độ nước chiều</label>
                        <div class="col-sm-10">
                            <input name="to_nuoc_chieu" type="number" class="form-control"
                                placeholder="Nhiệt độ nước chiều">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="/chi-tiet-ao">
                        <p type="" class="btn btn-default">Thoát</p>
                    </a>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div> --}}
    </form>
@endsection
