@extends('welcome1')
@section('content')
            @foreach($save_nk as $key => $save_value)
                <form class="modal-content animate" action="{{ URL::to('/save-chi-tiet-ao/'.$save_value->ma_ao) }}" method="post">
                    {{ csrf_field() }}
                    <div class="box box-primary">
                        <div class="box-header with-border" style="text-align: center;">
                            <p class="box-title" >THÊM NHẬT KÝ NUÔI</p>
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
                        <input type="hidden" name="lay_ma_ao" value="{{ $save_value->ma_ao }}">
                        <input type="hidden" name="lay_ma_khu" value="{{ $save_value->ma_khu }}">
                        <input type="hidden" name="lay_ma_vu" value="{{ $save_value->ma_vu }}">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày nuôi *</label>
                                    <input type="date" name="ngay"class="form-control"  placeholder="Ngày">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tuổi tôm *</label>
                                    <input type="number" name="tuoi_tom" class="form-control"  placeholder="Tuổi tôm">
                                </div>
                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Lượng thức ăn</label>
                                    <input type="number" name="luong_thuc_an"class="form-control"  placeholder="Lượng thức ăn">
                                </div> --}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lượng tôm giống (Null)</label>
                                    <input type="number" name="luong_tom_giong"class="form-control"  placeholder="Lượng tôm giống (Null)">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lượng tôm si phong</label>
                                    <input type="number" name="luong_tom_sp"class="form-control"  placeholder="Lượng tôm si phong (Null)">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Size tôm (số lượng tôm/ 1 kg) (Null)</label>
                                    <input type="number" name="size"class="form-control"  placeholder="Size tôm (số con tôm/ 1 kg) (Null)">
                                </div>
                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">ADG</label>
                                    <input type="number" name="ADG"class="form-control"  placeholder="ADG / NULL">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">FCR</label>
                                    <input type="number" name="FCR"class="form-control"  placeholder="FCR / NULL">
                                </div> --}}

                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Hao hụt</label>
                                    <input type="number" name="hao_hut"class="form-control"  placeholder="Hao hụt / NULL">
                                </div> --}}
                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Tình trạng</label>
                                    <input type="text" name="tinh_trang"class="form-control"  placeholder="Tình trạng / NULL">
                                </div> --}}
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="/chi-tiet-ao">
                                    <p type="" class="btn btn-default">Thoát</p>
                                </a>
                                <button type="submit" class="btn btn-info pull-right">Thêm nhật ký</button>
                              </div>
                        </form>
                    </div>
                    {{-- <div class="container">
                        <h2 style="text-align: center;">THÊM CHI TIẾT AO NUÔI</h2>
                        <input type="hidden" name="lay_ma_ao" value="{{ $save_value->ma_ao }}">
                        <input type="hidden" name="lay_ten_khu" value="{{ $save_value->ten_khu }}">
                        <input type="hidden" name="lay_ten_vu" value="{{ $save_value->ten_vu }}">

                        <p><b>Ngày</b></p>
                        <input type="date" name="ngay"class="form-control"  placeholder="Ngày">
                        <p><b>Tuổi tôm</b></p>
                        <input type="number" name="tuoi_tom" class="form-control"  placeholder="Tuổi tôm">
                        <p><b>Lượng thức ăn</b></p>
                        <input type="number" name="luong_thuc_an"class="form-control"  placeholder="Lượng thức ăn">
                        <p><b>Lượng tôm giống</b></p>
                        <input type="number" name="luong_tom_giong"class="form-control"  placeholder="Lượng tôm giống">
                        <p><b>ADG</b></p>
                        <input type="number" name="ADG"class="form-control"  placeholder="ADG / NULL">
                        <p><b>FCR</b></p>
                        <input type="number" name="FCR"class="form-control"  placeholder="FCR / NULL">
                        <p><b>Size</b></p>
                        <input type="number" name="size"class="form-control"  placeholder="Size / NULL">
                        <p><b>Hao hụt</b></p>
                        <input type="number" name="hao_hut"class="form-control"  placeholder="Hao hụt / NULL">
                        <p><b>Tình trạng</b></p>
                        <input type="text" name="tinh_trang"class="form-control"  placeholder="Tình trạng / NULL">
                        <div class="btn-add" style="text-align: center;">
                            <button type="submit" name="edit_khu_nuoi" class="edit">Thêm chi tiết ao</button>
                            <a href="/thiet-lap">
                                <button type="button" name="cancel_khu_nuoi" class="cancel">Cancel</button>
                            </a>

                        </div>
                    </div> --}}
                </form>
            @endforeach
@endsection
