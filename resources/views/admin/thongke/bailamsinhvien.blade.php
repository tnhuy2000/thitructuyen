@extends('layouts.admin-layout')
@section('pagetitle')
Thống kê bài làm
@endsection

@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Thống kê bài làm Sinh viên</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item"><a href="#">Thống kê bài làm Sinh viên</a></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.thongke.tkbailamtimkiem') }}" method="POST"
                            class="row gx-3 gy-2 align-items-center">
                            @csrf
                            <div class="row">
                               
                                    <div class="col-md-3 col-sm-3 pl-1 mt-3"></div>
                                    <div class="col-md-3 col-sm-3 pl-1 mt-3">
                                        <div class="form-group" id="filter_col1" data-column="1">
                                            <label class="form-label">Theo ca thi</label>


                                            @if (!empty($tenca))
                                                <input type="text" name="tenca" class="form-control"
                                                    value="{{ $tenca }}" placeholder="Nhập tên ca thi">
                                            @else
                                                <input type="text" name="tenca" class="form-control"
                                                    placeholder="Nhập tên ca thi">
                                            @endif


                                        </div>

                                    </div>
                                    <div class="col-md-3 pl-1 mt-3">
                                        <div class="form-group" id="filter_col2" data-column="2">
                                            <label class="form-label">Ngày thi</label>
                                            @if (!empty($ngaythi))
                                                <input type="date" name="ngaythi" class="form-control"
                                                    placeholder="dd/mm/YY" value="{{ $ngaythi }}">
                                            @else
                                                <input type="date" name="ngaythi" class="form-control"
                                                    placeholder="dd/mm/YY">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-2 pl-1 mt-3"></div>
                                    
                               
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 pl-1 mt-3"></div>
                                <div class="col-md-4 col-sm-4 pl-1 mt-3">
                                    <button class="btn btn-primary form-control mt-2" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Tìm
                                        kiếm</button>
                                </div>
                                
                                <div class="col-md-4 col-sm-2 pl-1 mt-3"></div>
                            </div>
                        </form>
                            <br>


                            <a href="{{ route('admin.thongke.xuat') }}" class="btn btn-success "><i class="fa-solid fa-download"></i> Xuất ra Excel</a>

                            <br>

                            <br>
                            <table class="table table-bordered table-hover ">
                                <thead>
                                    <tr class="table-danger">
                                        <th width="8%">#</th>
                                        <th>Ca thi</th>
                                        <th class="text-center" width="30%">Ngày thi</th>
                                        <th class="text-center" width="30%">Giờ bắt đầu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $dem=0; @endphp
                                    @foreach ($cathi_phongthi as $value)
                                        <tr>
                                            @php $dem++; @endphp
                                            <td>
                                                <div id="buttonthem{{ $dem }}">
                                                    <a href="#"><span id="span_{{ $dem }}"
                                                            class="fw-bold text-danger"><i class="bx bx-plus-circle"></i>
                                                            Hiện</span></a>
                                                </div>
                                            </td>
                                            <td>{{ $value->tenca }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y') }}</td>
                                            <td class="text-center">{{ $value->giobatdau }}</td>
                                        </tr>

                                        <tr id="table_phong{{ $dem }}" class="table-info">
                                            <td></td>
                                            <td colspan="4">


                                                <table class="table mb-0 table-bordered border-secondary table-sm ">

                                                    <thead>
                                                        <tr class="table-primary">
                                                            <th>#</th>
                                                            <th>Phòng thi</th>
                                                            <th width="30%" class="text-center">Số lượng thí sinh</th>
                                                            <th width="30%" class="text-center">Tổng số bài làm</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $count = 0;
                                                            $tongbaithi = 0;
                                                            $tongts = 0;
                                                        @endphp
                                                        @foreach ($baithi as $value1)
                                                            @if ($value1->cathi_id == $value->cathi_id)
                                                                <tr>
                                                                    <td class="text-center">{{ $count++ }}</a></td>
                                                                    <td>{{ $value1->maphong }}</a></td>
                                                                    <td class="text-center">
                                                                        {{ $value1->soluongthisinh }}</td>
                                                                    <td class="text-center">{{ $value1->slbaithi }}
                                                                    </td>
                                                                    @php
                                                                        $tongbaithi += $value1->slbaithi;
                                                                        $tongts += $value1->soluongthisinh;
                                                                    @endphp
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @if ($count == 0)
                                                            <tr>
                                                                <td colspan="4" class="text-center">Chưa có dữ liệu</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td colspan="2" align="right">Tổng</td>
                                                                <td class="text-center">{{ $tongts }}</td>
                                                                <td class="text-center">{{ $tongbaithi }}</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>

                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>


    <!-- End #main -->


@endsection
@section('javascript')

    {{-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}

    <script type="text/javascript">
        // 	function filterGlobal() {
        //     $('#ex').DataTable().search(
        //         $('#global_filter').val(),

        //     ).draw();
        // }

        // function filterColumn(i) {
        //     $('#ex').DataTable().column(i).search(
        //         $('#col' + i + '_filter').val()
        //     ).draw();
        // }


        // $(document).ready(function() {

        // 	$('#ex').DataTable();
        //     $('input.global_filter').on('keyup click', function() {
        //         filterGlobal();
        //     });

        //     $('input.column_filter').on('keyup click', function() {
        //         filterColumn($(this).parents('div').attr('data-column'));
        //     });


        // });

        // $('select.column_filter').on('change', function() {
        //     filterColumn($(this).parents('div').attr('data-column'));
        // });
        $(document).ready(function() {

            var dong = <?php echo $dem; ?>

            for (let i = 0; i <= dong; i++) {
                $('#table_phong' + i).hide();

                $('#buttonthem' + i).click(function() {

                    var span = document.getElementById("span_" + i).innerText;


                    if (span == ' Hiện') {

                        var htmlObj = document.getElementById("span_" + i);
                        var abc = htmlObj.innerHTML = "<i class='bx bx-no-entry'></i> Ẩn";

                    } else {
                        var htmlObj1 = document.getElementById("span_" + i);
                        htmlObj1.innerHTML = "<i class='bx bx-plus-circle'></i> Hiện";
                    }

                    $('#table_phong' + i).toggle(300);
                    return false;
                });
            }

        });
    </script>

@endsection
