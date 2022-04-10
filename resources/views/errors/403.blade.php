
@extends('layouts.admin-layout')

@section('content')
	


    <main id="main" class="main">

        <div class="pagetitle">
          <h1>Cấm truy xuất</h1>
          
        </div><!-- End Page Title -->
    
        <section class="section dashboard">
          <div class="row">
            <!-- Left side columns -->
            <div class="card">
                <br>
                <div class="card-body">
                    @if (session('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                            <i class="bi bi-exclamation-circle"></i> Lỗi 403 - {{ session('error_message') }}
                        </div>
                    @endif
                </div>
            </div>
            
          </div>
        </section>
    
      </main><!-- End #main -->
@endsection