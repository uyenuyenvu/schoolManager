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
                    <h1 class="page-title"> Danh sách khối </h1>

                </header><!-- /.page-title-bar -->
                <!-- .page-section -->
                <div class="page-section">
                    <div class="section-block">
                        <!-- metric row -->
                        <div class="metric-row">
                            <div class="col-lg-9">
                                <div class="metric-row metric-flush">
                                    <!-- metric column -->
                                    @foreach($divisions as $division)
                                    <div class="col">
                                        <!-- .metric -->
                                        <a href="user-teams.html" class="metric metric-bordered align-items-center">
                                            <h1 class="metric-label">Khối {{$division->name}} </h1>
                                            <p class="metric-value h3">
                                                <sub><i class="oi oi-home"></i></sub>
                                                <span class="metric-label">Tổng số lớp: {{count(\App\Models\Team::where('division_id', $division->id)->get())}}</span>
                                            </p>
                                           
                                        </a> <!-- /.metric -->
                                    </div>
                                    @endforeach
                                </div>
                            </div><!-- metric column -->
                        </div><!-- /metric row -->
                    </div><!-- /.section-block -->

                </div><!-- /.page-section -->
            </div><!-- /.page-inner -->
        </div><!-- /.page -->
    </div>
@endsection

