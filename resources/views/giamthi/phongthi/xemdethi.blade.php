@extends('layouts.giamthi-layout')
@section('pagetitle')
	Xem đề thi
@endsection

@section('css')

@endsection('css')
@section('content')

<!-- Pricing Start -->
<div class="container-xxl">
	<div class="container py-3">
		<h5>
		<nav aria-label="breadcrumb animated slideInDown">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a class="text-primary" href="{{route('giamthi.dashboard')}}"><i class="fas fa-home"></i> Trang chủ</a></li>
				<li class="breadcrumb-item"><a class="text-primary" href="{{route('giamthi.phongthi',['phongthi_id'=>$ktphongthi->id])}}">Phòng thi của tôi</a></li>
				<li class="breadcrumb-item text-primary" aria-current="page">{{$dethi_phongthi->maphong}}</li>
				<li class="breadcrumb-item text-danger active" aria-current="page">2. Làm bài thi</li>
			</ol>
		</nav>
		</h5>
		<div class="wow mt-2 mb-2" data-wow-delay="0.1s">
			<h3 class="">{{$dethi_phongthi->mahocphan}} - {{$dethi_phongthi->tenhocphan}}</h3>
			<button disabled class="btn" id="remaining_time">  </button>
		</div>
		<br>
		<div class="row">
			<div class="col-md-8">
				<div class="card" style="border-width: 5px;border: solid;">
					
					<div class="card-body text-center">
				
						@php 
							$count=0; 
						
						@endphp
							
						@foreach($dulieudethi as $value)
						@php
							$ex=pathinfo($value->duongdan, PATHINFO_EXTENSION);
						@endphp
						@if ($ex=='png' || $ex=='jpg')

							<h6 class="card-title bg-dark text-white">Trang {{($count++)+1}}</h6>
							<img src="{{$path_dethi. $value->duongdan}}" class="img-thumnail" width="650px"/>
							<hr>
						@else
						<div style="padding: 5px 10px 10px 10px;">
							<button class="btn btn-primary btn-rounded" id="prev">Trang trước</button>
							<button class="btn btn-warning btn-rounded" id="next">Trang sau</button>
							&nbsp; &nbsp;
							<span>Trang: <input id="page_num" value="" onchange="onOfPage(this);" style="width: 40px; text-align: right;"/> / <span id="page_count"></span></span>
						  </div>
						  
						  <canvas id="the-canvas" width="600px !important;" ></canvas>
						  <?php
						  //Khai báo biến lấy nội dung file và encode base64
						  
							$file=$path_dethi . $value->duongdan;
							$getPDF = base64_encode(file_get_contents($file));
						
						  ?>
					 	 @endif							
						@endforeach
						@if($count!=0)
						<h6>Đề thi có tổng số: {{$count}} trang</h6>
						@endif

					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card" style="border-width: 5px;border: solid #ff0000;">
					<div class="card-body">
						<h5><img class="" src="{{asset('public/img/clock.png')}}" width="60px" alt="">	Thời gian làm bài: {{$dethi_phongthi->thoigianlambai}} phút</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection
@section('javascript')    
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script>
	//doc pdf
	var pdfData = atob('<?php if(!empty($getPDF)) echo $getPDF; ?>');
              
          var pdfjsLib = window['pdfjs-dist/build/pdf'];
          
          pdfjsLib.GlobalWorkerOptions.workerSrc = "//mozilla.github.io/pdf.js/build/pdf.worker.js";
        
          var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.2,
            canvas = document.getElementById('the-canvas'),
            ctx = canvas.getContext('2d');
          canvas.oncontextmenu = function() {return false};
          var loadingTask = pdfjsLib.getDocument({data: pdfData});
          loadingTask.promise.then(function(pdf) {
            pdfDoc = pdf;
            document.getElementById('page_count').textContent = pdf.numPages;
            renderPage(pageNum);
          }, function (reason) {
            console.error(reason);
          });
          
          function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function(page) {
              var viewport = page.getViewport({scale: scale});
              canvas.height = viewport.height;
              canvas.width = viewport.width;
              var renderContext = {
                canvasContext: ctx,
                viewport: viewport
              };
              var renderTask = page.render(renderContext);
              renderTask.promise.then(function() {
                pageRendering = false;
                if (pageNumPending !== null) {
                  renderPage(pageNumPending);
                  pageNumPending = null;
                }
              });
            });
            document.getElementById('page_num').value = num;
          }
          
          function queueRenderPage(num) {
            if (pageRendering)
              pageNumPending = num;
            else
              renderPage(num);
          }
          
          function onPrevPage() {
            if(pageNum <= 1)
              return;
            pageNum--;
            queueRenderPage(pageNum);
          }
          document.getElementById('prev').addEventListener('click', onPrevPage);
        
          function onNextPage() {
            if (pageNum >= pdfDoc.numPages)
              return;
            pageNum++;
            queueRenderPage(pageNum);
          }
          document.getElementById('next').addEventListener('click', onNextPage);
        
          function onOfPage(e) {
            var num = parseInt(e.value);
            if(Number.isInteger(num) == false)
              return;
            if(num > pdfDoc.numPages || num < 1)
              return;
            pageNum = num;
            queueRenderPage(pageNum);
          }
</script>
@endsection
