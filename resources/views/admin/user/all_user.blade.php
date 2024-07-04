@extends('welcome1')
@section('content')
    <section class="khoi-tao">
        <div class="box-data-table" >
            <div class="box-header">
                <h3>QUẢN LÝ TÀI KHOẢN</h3>
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
                <!-- The Modal -->
                <div id="myModal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <p class="close-form" style="font-size: 30px;" onclick="document.getElementById('myModal').style.display='none'">&times;</p>
                        <form action="{{ URL::to('/admin-add-user') }}" method="post">
                            {{ csrf_field() }}
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <p class="box-title">THÊM NGƯỜI DÙNG</p>
                                </div>
                          <div class="form-group has-feedback">
                            <input type="text" name="name" class="form-control" placeholder="Full name">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                          </div>
                          <div class="form-group has-feedback">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                          </div>
                          <div class="form-group has-feedback">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                          </div>
                          <div class="form-group has-feedback">
                            <input type="password" name="retype_password" class="form-control" placeholder="Retype password">
                            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                          </div>
                          <div class="row">

                            <!-- /.col -->
                            <div class="col-xs-2">
                              <button type="submit" class="btn btn-primary btn-block btn-flat">Thêm người dùng</button>
                            </div>
                            <!-- /.col -->
                          </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="box-body" style="margin-bottom: 40px" >
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="padding: 5px;">
                    <div class="row" style="overflow-x: scroll;">
                        <div class="" style="margin-bottom: 95px;">
                            <table id="table-user" class="table table-bordered table-striped dataTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Tên</th>
                                        <th>Email</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                            <script>
                                $(document).ready(function() {
                                    var dataTable = $('#table-user').DataTable({
                                        processing: true,
                                        serverSide: true,
                                        repornSive: true,
                                        ajax: {
                                            url: "{{ route('thiet-lap.user') }}",
                                            data: function(d) {
                                                d.lay_user_loc = $('select[name="lay_user_loc"]').val();
                                            }
                                        },
                                        columns: [{
                                                data: 'name',
                                                name: 'name'
                                            },
                                            {
                                                data: 'email',
                                                name: 'email'
                                            },
                                            // {
                                            //     data: 'password',
                                            //     name: 'password'
                                            // },
                                            {
                                                data: 'Action',
                                                name: 'Action'
                                            },
                                        ]
                                    });
                                    $('#form-sub-user').on('submit', function(e) {
                                        e.preventDefault();
                                        dataTable.ajax.reload(); // Tải lại dữ liệu DataTables sau khi thay đổi lọc
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="box">
                <div class="box-header-1" style="color: #444;display: block; padding: 10px; position: relative;margin-bottom: -20px;">
                    <p class="box-title" style="font-size: 18px;">Danh sách tài khoản</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow-x: scroll;">
                    <div class="group-btn" style="margin-bottom: 10px;">
                        <form action="{{ URL::to('/loc-user') }}" method="get" id="form-sub-user" style="justify-content: space-between;">
                            {{ csrf_field() }}
                            <div class="khu" style="display: flex; grid-gap: 15px;">
                                {{-- <p>Khu nuôi</p> --}}
                                <select name="lay_user_loc" value="" style="width: 200px;">
                                    <option value="">Chọn tài khoản</option>
                                    @foreach ($lay_user as $val)
                                        <option value="{{ $val->email}}">{{ $val->email }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-block btn-primary">Lọc</button>
                                {{-- <a href="all-khu-nuoi">
                                    <button type="" class="btn-sub-loc">All</button>
                                </a> --}}
                            </div>
                            <div style="margin-left: 15px;">
                                {{-- <button id="myBtn" style="width: auto;" class="btn-sub-loc">Tạo khu</button> --}}
                                <button id="myBtn" class="btn btn-block btn-info">Tạo tài khoản</button>
                            </div>
                        </form>
                    </div>
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="font-size: 14px;width: 100%; font-family: Source Sans Pro;">
                        <div class="row" style="margin-bottom: 55px;">
                            <div class="col-sm-12">
                                <table id="table-user" style="width: 100%; font-size: 14px;overflow-x: scroll;"
                                class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Email</th>
                                            {{-- <th>Password</th> --}}
                                            {{-- <th>Vai trò (Roles)</th>
                                            <th>Quyền (Permissions)</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Email</th>
                                            {{-- <th>Password</th> --}}
                                            {{-- <th>Vai trò (Roles)</th>
                                            <th>Quyền (Permissions)</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <script>
                                    $(document).ready(function() {
                                        var dataTable = $('#table-user').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            repornSive: true,
                                            ajax: {
                                                url: "{{ route('thiet-lap.user') }}",
                                                data: function(d) {
                                                    d.lay_user_loc = $('select[name="lay_user_loc"]').val();
                                                }
                                            },
                                            columns: [{
                                                    data: 'name',
                                                    name: 'name'
                                                },
                                                {
                                                    data: 'email',
                                                    name: 'email'
                                                },
                                                // {
                                                //     data: 'password',
                                                //     name: 'password'
                                                // },
                                                {
                                                    data: 'Action',
                                                    name: 'Action'
                                                },
                                            ]
                                        });
                                        $('#form-sub-user').on('submit', function(e) {
                                            e.preventDefault();
                                            dataTable.ajax.reload(); // Tải lại dữ liệu DataTables sau khi thay đổi lọc
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="row">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
    </section>
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
@endsection
