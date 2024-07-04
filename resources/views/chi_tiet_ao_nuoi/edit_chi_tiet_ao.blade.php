
@extends('welcome1')
@section('content')
    <section class="">
            @foreach($edit_chi_tiet_ao as $key => $edit_value)
                <form class="modal-content animate" action="{{ URL::to('/update-chi-tiet-ao/'.$edit_value->id_chi_tiet_ao) }}" method="post">
                    {{ csrf_field() }}
                    <div class="box box-primary">
                        <div class="box-header with-border" style="text-align: center;">
                          <h3 class="box-title">CHỈNH SỬA CHI TIẾT AO NUÔI</h3>
                          @foreach ($ten_ao as $value)
                            <p style="color: rgb(232, 85, 85)">({{ $value->ten_ao }} - {{ $value->ten_khu }}
                                - {{ $value->ten_vu }} - {{ Carbon\Carbon::parse($value->ngay)->format('d/m/Y') }})</p>
                          @endforeach
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
                        <!-- /.box-header -->

                        <!-- form start -->
                        <form role="form">
                            <div class="box-body">
                                <input type="hidden" name="ma_ao" value="{{ $edit_value->ma_ao }}">
                                <div class="form-group">
                                    <label for="">Ngày nuôi <span style="color: red">*</span></label>
                                    <input type="date" name="ngay"class="form-control" value="{{ $edit_value->ngay }}" placeholder="Ngày">
                                </div>
                                <div class="form-group">
                                    <label for="">Tuổi tôm <span style="color: red">*</span></label>
                                    <input type="number" name="tuoi_tom" class="form-control" value="{{ $edit_value->tuoi_tom }}" placeholder="Tuổi tôm">

                                </div>
                                {{-- <div class="form-group">
                                    <label for="exampleInputPassword1">Lượng thức ăn (Kg)</label>
                                    <input type="number" name="luong_thuc_an"class="form-control" value="{{ $edit_value->luong_thuc_an }}"  placeholder="Lượng thức ăn">
                                </div> --}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lượng tôm si phong <span style="color: red">*</span></label>
                                    <input type="number" name="luong_tom_sp"class="form-control" value="{{ $edit_value->luong_tom_sp }}" placeholder="Lượng tôm si phong">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Size tôm</label>
                                    <input type="number" name="size"class="form-control" value="{{ $edit_value->size }}" placeholder="Size / NULL">
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Lượng tôm giống</label>
                                  <input type="number" name="luong_tom_giong"class="form-control" value="{{ $edit_value->luong_tom_giong }}" placeholder="Lượng tôm giống">
                                </div>
                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">ADG</label>
                                    <input type="number" name="ADG"class="form-control" value="{{ $edit_value->ADG }}" placeholder="ADG / NULL">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">FCR</label>
                                    <input type="number" name="FCR"class="form-control" value="{{ $edit_value->FRC }}" placeholder="FCR / NULL">
                                </div> --}}
                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Hao hụt</label>
                                    <input type="number" name="hao_hut"class="form-control" value="{{ $edit_value->hao_hut }}" placeholder="Hao hụt / NULL">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tình trạng</label>
                                    <input type="text" name="tinh_trang"class="form-control" value="{{ $edit_value->tinh_trang }}" placeholder="Tình trạng / NULL">
                                </div> --}}
                            </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer" style="justify-content: right;display: flex;grid-gap: 10px;">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="/bao-cao-ao/{{ $edit_value->ma_ao }}/{{ $edit_value->ma_khu }}/{{ $edit_value->ma_vu }}">
                                    <span class="btn btn-primary" style="background-color: rgb(245, 132, 132)">Thoát</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </form>
            @endforeach
    </section>
@endsection
