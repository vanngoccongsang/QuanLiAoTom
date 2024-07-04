@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table" >
            <div class="box-header">
                <h2>PHÂN VAI TRÒ</h2>
            </div>
            @if (Session::has('message'))
                <script>
                    swal("Thông báo", "{{ Session::get('message') }}", 'success',{
                    button: true,
                    button: "OK",
                    timer: 3000,
                    dangerMode: true,
                    });
                </script>
                @php
                    Session::put('message', null);
                @endphp
            @elseif(Session::has('error'))
                <script>
                    swal("Thông báo", "{{ Session::get('error') }}", 'error',{
                    button: true,
                    button: "OK",
                    timer: 3000,
                    dangerMode: true,
                    });
                </script>
                @php
                    Session::put('error', null);
                @endphp
            @endif
            <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->

                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-aqua-active">
                          <h2 class="widget-user-username">{{ $lay_user->name }}</h2>
                          <h4 class="widget-user-desc">{{ $lay_user->email }}</h4>
                        </div>
                        <div class="widget-user-image">
                            <img src="{{ asset('assets/images/uploads/avatar.png') }}" class="img-circle" alt="">
                        </div>
                        <div class="box-footer">
                          <!-- /.row -->
                        </div>
                    </div>
                    <div style="padding: 5px;display: flex;justify-content: space-between;">
                        <div>
                            <button id="myBtn" style="width: 150px;" class="btn btn-block btn-info">Tạo vai trò mới</button>
                        </div>
                        <a href="/quan-ly-tai-khoan">
                            <span class="btn btn-primary" style="background-color: rgb(245, 132, 132)">Thoát</span>
                        </a>
                    </div>
                    <!-- The Modal -->
                <div id="myModal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <p class="close-form" style="font-size: 30px;" onclick="document.getElementById('myModal').style.display='none'">&times;</p>
                        <form class="" action="{{ URL::to('/save-vai-tro') }}" method="post">
                            {{ csrf_field() }}
                            <div class="box box-primary">
                            <div class="box-header with-border">
                                <p class="box-title">THÊM VAI TRÒ</p>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tên vai trò</label>
                                    <input type="text" name="ten_vai_tro" class="form-control" value="" placeholder="Tên vai trò">
                                </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Thêm</button>
                                </div>
                        </form>
                    </div>
                </div>
                <script>
                    // Get the modal
                    var modal = document.getElementById("myModal");
                    // Get the button that opens the modal
                    var btn = document.getElementById("myBtn");
                    // Get the <span> element that closes the modal
                    var span = document.getElementsByClassName("close")[0];
                    // When the user clicks the button, open the modal
                    btn.onclick = function() {
                      modal.style.display = "block";
                    }
                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function(event) {
                      if (event.target == modal) {
                        modal.style.display = "none";
                      }
                    }
                </script>
                    <form action="{{ URL::to('/them-vai-tro/'.$lay_user->id) }}" method="post">
                        {{ csrf_field() }}
                    <div class="box-body" >

                        <div style="">
                            @foreach ($role as $value)
                                @if (isset($all_column_roles))
                                <div>
                                    <input class="form-check-input" {{ $value->id==$all_column_roles->id ? 'checked': ''}} type="radio" name="role" id="{{$value->id}}" value="{{$value->name}}">
                                    <label class="form-check-label" for="{{$value->id}}">{{$value->name}}</label>
                                </div>
                                @else
                                <div>
                                    <input class="form-check-input" type="radio" name="role" id="{{$value->id}}" value="{{$value->name}}">
                                    <label class="form-check-label" for="{{$value->id}}">{{$value->name}}</label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        {{-- <hr>
                        @foreach ($permission as $per)
                            <div class="checkbox">
                                <label for="{{ $per->id }}">
                                <input type="checkbox" id="{{ $per->id }}" value="{{ $per->name }}">
                                {{ $per->name }}
                                </label>
                            </div>
                        @endforeach --}}
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Phân vai trò</button>
                    </div>
                    </form>

              </div>


        </div>
    </section>
@endsection
