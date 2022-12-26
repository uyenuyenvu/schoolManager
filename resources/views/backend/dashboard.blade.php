@extends('backend.layouts.master')
@section('title')
  Bảng điều khiển
@endsection
@section('contents')
<div class="wrapper">
    <!-- .page -->
    <div class="page">
      <!-- .page-inner -->
      <div class="page-inner">
        <!-- .page-title-bar -->
        <header class="page-title-bar">
          <div class="d-flex flex-column flex-md-row">
            <p class="lead">
              <span class="font-weight-bold">Hi, Phùng xuân thực.</span> <span class="d-block text-muted">Here’s what’s happening with your business today.</span>
            </p>
            <div class="ml-auto">
              <!-- .dropdown -->
              <div class="dropdown">
                <button class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>This Week</span> <i class="fa fa-fw fa-caret-down"></i></button> <!-- .dropdown-menu -->
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-md stop-propagation">
                  <div class="dropdown-arrow"></div><!-- .custom-control -->
                  <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="dpToday" name="dpFilter" data-start="2019/03/27" data-end="2019/03/27"> <label class="custom-control-label d-flex justify-content-between" for="dpToday"><span>Today</span> <span class="text-muted">Mar 27</span></label>
                  </div><!-- /.custom-control -->
                  <!-- .custom-control -->
                  <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="dpYesterday" name="dpFilter" data-start="2019/03/26" data-end="2019/03/26"> <label class="custom-control-label d-flex justify-content-between" for="dpYesterday"><span>Yesterday</span> <span class="text-muted">Mar 26</span></label>
                  </div><!-- /.custom-control -->
                  <!-- .custom-control -->
                  <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="dpWeek" name="dpFilter" data-start="2019/03/21" data-end="2019/03/27" checked> <label class="custom-control-label d-flex justify-content-between" for="dpWeek"><span>This Week</span> <span class="text-muted">Mar 21-27</span></label>
                  </div><!-- /.custom-control -->
                  <!-- .custom-control -->
                  <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="dpMonth" name="dpFilter" data-start="2019/03/01" data-end="2019/03/27"> <label class="custom-control-label d-flex justify-content-between" for="dpMonth"><span>This Month</span> <span class="text-muted">Mar 1-31</span></label>
                  </div><!-- /.custom-control -->
                  <!-- .custom-control -->
                  <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="dpYear" name="dpFilter" data-start="2019/01/01" data-end="2019/12/31"> <label class="custom-control-label d-flex justify-content-between" for="dpYear"><span>This Year</span> <span class="text-muted">2022</span></label>
                  </div><!-- /.custom-control -->
                  <!-- .custom-control -->
                  <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="dpCustom" name="dpFilter" data-start="2019/03/27" data-end="2019/03/27"> <label class="custom-control-label" for="dpCustom">Custom</label>
                    <div class="custom-control-hint my-1">
                      <!-- datepicker:range -->
                      <input type="text" class="form-control" id="dpCustomInput" data-toggle="flatpickr" data-mode="range" data-disable-mobile="true" data-date-format="Y-m-d"> <!-- /datepicker:range -->
                    </div>
                  </div><!-- /.custom-control -->
                </div><!-- /.dropdown-menu -->
              </div><!-- /.dropdown -->
            </div>
          </div>
        </header><!-- /.page-title-bar -->
        <!-- .page-section -->
        <div class="page-section">
          <!-- .section-block -->
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
          <!-- grid row -->
          <!-- card-deck-xl -->
          <div class="card-deck-xl">
            <!-- .card -->
            <div class="card card-fluid pb-3">
              <div class="card-header"> Danh sách kì thi </div><!-- .lits-group -->
              <div class="lits-group list-group-flush">
                <!-- .lits-group-item -->
                  @foreach($exams as $exam)
                <div class="list-group-item">
                  <!-- .lits-group-item-figure -->
                  <div class="list-group-item-figure">
                    <div class="has-badge">
                      <a href="page-project.html" class="tile tile-md bg-purple">EX</a>
                        <a href="#team" class="user-avatar user-avatar-xs">
                            <img src="{{ asset('backend') }}/assets/images/avatars/team4.jpg" alt=""></a>
                    </div>
                  </div><!-- .lits-group-item-figure -->
                  <!-- .lits-group-item-body -->
                  <div class="list-group-item-body">
                    <h5 class="card-title">
                      <a href="page-project.html">{{$exam->name}}</a>
                    </h5>
                    <p class="card-subtitle text-muted mb-1"> Học kì: {{$exam->semester}} ; Năm học:  {{$exam->year}} </p><!-- .progress -->
                    <div class="progress progress-xs bg-transparent">
                      <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="2181" aria-valuemin="0" aria-valuemax="100" style="width: 74%">
                        <span class="sr-only">74% Complete</span>
                      </div>
                    </div><!-- /.progress -->
                  </div><!-- .lits-group-item-body -->
                </div>
                  @endforeach

              </div><!-- /.lits-group -->
            </div><!-- /.card -->
            <!-- .card -->
            <div class="card card-fluid">
              <div class="card-header">Danh sách giáo viên </div><!-- .card-body -->
              <div class="card-body">
                <!-- .todo-list -->
                  <div class="table-teacher">
                      <table style="width: 100%; text-align: center">
                          <tr>
                              <th>STT</th>
                              <th>Họ và tên</th>
                              <th>Số điện thoại</th>
                          </tr>
                          <tbody>
                          @php($index = 0)
                          @foreach($teachers as $teacher)
                              @php($index++)
                          <tr>
                              <td>{{$index}}</td>
                              <td>{{$teacher->name}}</td>
                              <td>{{$teacher->phone}}</td>
                          </tr>
                          @endforeach
                          </tbody>
                      </table>
                  </div>

              </div><!-- /.card-body -->
              <!-- .card-footer -->
              <div class="card-footer">
                <a href="#" class="card-footer-item">View all <i class="fa fa-fw fa-angle-right"></i></a>
              </div><!-- /.card-footer -->
            </div><!-- /.card -->
          </div><!-- /card-deck-xl -->
        </div><!-- /.page-section -->
      </div><!-- /.page-inner -->
    </div><!-- /.page -->
  </div><!-- .app-footer -->
@endsection
