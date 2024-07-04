@extends('welcome1')
@section('content')
            <form class="modal-content animate" action="{{ URL::to('/save-nhat-ky/'.$id_chi_tiet_ao) }}" method="post">
                {{ csrf_field() }}
                <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">THÊM CHI TIẾT AO NUÔI</h3>
                        <div class="message" style="text-align: center;">
                            <?php
                                $message = Session::get('message');
                                if ($message) {
                                    echo '<span class="thong-bao-mess">', $message . '</span>';
                                    Session::put('message', null);
                                }
                            ?>
                        </div>
                    </div>
                    <input type="hidden" name="id_chi_tiet_ao" value="{{ $id_chi_tiet_ao }}">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal">
                      <div class="box-body">
                        <div class="form-group">
                            <p  class="col-sm-2 ">Tên cử</p>
                            <div class="col-sm-10">
                                <input name="ten_cu" type="text" class="form-control" placeholder="Tên cử">
                            </div>
                        </div>
                        <div class="form-group">
                            <p  class="col-sm-2 ">Tên vật tư</p>
                            <div class="col-sm-10">
                                <select name="ma_vat_tu">
                                    @foreach ($vat_tu as $value)
                                        <option value="{{ $value->ma_vat_tu }}">{{ $value->ten_vat_tu }} ({{ $value->don_vi }})</option>
                                    @endforeach
                                </select>
                                {{-- <input name="ten_vat_tu" type="text" class="form-control" placeholder="Tên vật tư"> --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="col-sm-2 ">Số lượng</p>
                            <div class="col-sm-10">
                                <input name="so_luong" type="number" class="form-control" placeholder="Số lượng">
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <p class="col-sm-2 ">Đơn vị</p>
                            <div class="col-sm-10">
                                <input name="don_vi" type="text" value="{{ $value->don_vi }}" class="form-control" placeholder="Đơn vị">
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <p class="col-sm-2 ">Ghi chú</p>
                            <div class="col-sm-10">
                                <input name="ghi_chu" type="text" class="form-control" placeholder="Ghi chú">
                            </div>
                        </div>

                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <a href="/chi-tiet-ao">
                            <p type="" class="btn btn-default">Thoát</p>
                        </a>

                        <button type="submit" class="btn btn-info pull-right">Thêm chi tiết</button>
                      </div>
                      <!-- /.box-footer -->
                    </form>
                </div>
                {{-- <div class="container">
                    <h2 style="text-align: center;">THÊM NHẬT KÝ AO NUÔI</h2>
                    <div style="">
                        <input type="hidden" name="id_chi_tiet_ao" value="{{ $id_chi_tiet_ao }}">

                    <p><b>Cử ăn 1</b></p>
                    <input type="number" name="cu_an_1"class="form-control"  placeholder="Cử ăn 1">
                    <p><b>Cử ăn 2</b></p>
                    <input type="number" name="cu_an_2" class="form-control"  placeholder="Cử ăn 2">
                    <p><b>Cử ăn 3</b></p>
                    <input type="number" name="cu_an_3"class="form-control"  placeholder="Cử ăn 3">
                    <p><b>Cử ăn 4</b></p>
                    <input type="number" name="cu_an_4"class="form-control"  placeholder="Cử ăn 4">
                    <p><b>Cử ăn 5</b></p>
                    <input type="number" name="cu_an_5"class="form-control"  placeholder="Cử ăn" 5>
                    <p><b>Cử ăn 6</b></p>
                    <input type="number" name="cu_an_6"class="form-control"  placeholder="Cử ăn 6">
                    <p><b>Ghi chú</b></p>
                    <input type="text" name="ghi_chu"class="form-control"  placeholder="Ghi chú">
                    </div>
                    <div class="btn-add" style="text-align: center;">
                        <button type="submit" name="edit_khu_nuoi" class="edit">Thêm môi trường</button>
                        <a href="/chi-tiet-ao">
                            <button type="button" name="cancel_khu_nuoi" class="cancel">Cancel</button>
                        </a>
                    </div>
                </div> --}}
            </form>
@endsection
