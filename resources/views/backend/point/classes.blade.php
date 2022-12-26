@extends('backend.layouts.master')

@section('contents')
    <div class="wrapper">
        <!-- .page -->
        <div class="page">
            <!-- .page-inner -->
            <div class="page-inner">
                <!-- .page-title-bar -->
                <header class="page-title-bar">
                    <!-- .breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">
                                <a href="#"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Tables</a>
                            </li>
                        </ol>
                    </nav><!-- /.breadcrumb -->
                    <!-- title -->
                    <h1 class="page-title"> Chọn lớp </h1>

                </header><!-- /.page-title-bar -->
                <!-- .page-section -->
                <div class="page-section">
                    <div class="section-block">
                        <!-- metric row -->
                        <div class="metric-row">
                            @foreach($classes as $class)

                            <div class="col-lg-4">
                                <div class="metric-row metric-flush">
                                    <!-- metric column -->
                                            <!-- .metric -->
                                <a href="{{route('admin.point.class',['id'=>$class->id,'exId'=>$exam_id])}}" class="metric metric-bordered align-items-center">
                                    <h1 class="metric-label">Lớp {{$class->name}} </h1>
                                </a> <!-- /.metric -->
                                </div>
                            </div><!-- metric column -->
                            @endforeach
                        </div><!-- /metric row -->
                    </div><!-- /.section-block -->

                </div><!-- /.page-section -->
            </div><!-- /.page-inner -->
        </div><!-- /.page -->
    </div>
@endsection

