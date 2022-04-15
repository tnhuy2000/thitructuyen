@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý thông báo
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Chi tiết thông báo</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item active">Chi tiết thông báo</li>
	  
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
            
            <div class="alert alert-primary alert-dismissible fade show mt-3" role="alert">
               <h5 class="text-uppercase fw-bold">{{$thongbao->tieude}}</h5>
            </div>
           
            <h6 class="text-muted"><i class="bx bxs-calendar"></i>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $thongbao->created_at)->format('d/m/Y') }}</h6>
            <hr>
            <p class="mt-3"> {!! $thongbao->noidung !!}</p>

        @if($thongbao->loai=='dinhkem')
		  	<h5 class="card-title">Tập tin đính kèm thông báo:</h5>

			
		  <!-- Table with stripped rows -->
		  <table class="table table-hover table-bordered">
		  	<thead>
				<tr>
						<th width="4%">#</th>
						<th width="45%">Tên tài liệu</th>
						<th width="10%">Lượt tải</th>
						<th width="10%">Tải về</th>
						
				</tr>
			</thead>
			<tbody>
			@foreach($vanban as $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    
                    <td class="text-justify">
                        <span class="font-weight-bold text-primary">{{ $value->tenvanban }}</span>
                    </td>
                    <td>{{ $value->luotdownload }}</td>
                    <td ><a class="btn btn-primary btn-sm" target="_blank" href="{{route('admin.dashboard.taivanban',['id'=>$value->id])}}"><i class="bx bxs-download"></i></a></td>
                    
                </tr>
			@endforeach
			</tbody>
		  </table>
		  <!-- End Table with stripped rows -->
          @endif

		</div>
	  </div>

	</div>
  </div>
</section>

</main>


<!-- End #main -->
   
<

@endsection
@section('javascript')    
<script type="text/javascript">
  		
		
  </script>
  
@endsection
