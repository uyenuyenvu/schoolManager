@extends('backend.layouts.master')
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{asset('backend/custom/post.js')}}"></script>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .error{
            color: red;
        }
        .day{
            border: 0.5px solid #e0d8d8;
        }

        .select2-selection__rendered {
            line-height: 32px !important;
        }

        .select2-selection {
            height: 34px !important;
        }
    </style>
@endsection

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
                    <h1 class="page-title"> Quản lý người dùng </h1>

                </header><!-- /.page-title-bar -->
                <!-- .page-section -->
                <div class="page-section">
                    <!-- .card -->
                    <div class="card card-fluid">
                        <div class="card-header">
                            <div>
                                <button class="btn btn-success" id="btnAddPost">Thêm mới</button>
                            </div>
                        </div>
                        <!-- .card-body -->
                        <div class="card-body">
                            <!-- .table -->
                            <div id="dt-responsive_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="table-responsive">
                                    <table id="postTable"
                                           class="table dt-responsive nowrap w-100 dataTable dtr-inline" role="grid"
                                           aria-describedby="dt-responsive_info">
                                        <thead>
                                        <tr role="row">
                                            <th>STT</th>
                                            <th>Tiêu đề</th>
                                            <th>Ngày tuyển dụng</th>
                                            <th>Loại hình công việc</th>
                                            <th>Số lượng</th>
                                            <th>Mức lương</th>
                                            <th>Công ty</th>
                                            <th>Trang thái tuyển dụng</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        </tfoot>
                                        <tbody>
                                        <tr class="odd">
                                            <td valign="top" colspan="6" class="dataTables_empty">Loading...</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- /.table -->
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div><!-- /.page-section -->
            </div><!-- /.page-inner -->
        </div><!-- /.page -->
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thêm mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAddPost">
                        <!-- .fieldset -->
                        <fieldset>
                            <div class="form-group">
                                <label for="title">Tiêu đề</label> <input type="text" class="form-control" id="title" name="title" aria-describedby="tf1Help" placeholder="Nhập vào tiêu đề">
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label for="category_id">Danh mục</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value=""></option>
                                    @forelse($list_category as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <!-- .form-group -->
                            <div class="form-group">
                                <label for="descriptions">Mô tả</label>
                                <textarea name="descriptions" id="descriptions" rows="5" placeholder="Nhập vào mô tả"></textarea>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label for="content">Nội dung</label>
                                <textarea name="content" id="content" cols="30" rows="10" placeholder="Nhập vào mô tả"></textarea>
                            </div><!-- /.form-group -->

                            <div class="row">
                                <div class="form-group col-3">
                                    <label for="date_public">Ngày tuyển dụng</label>
                                    <input type="text" class="form-control" id="date_public" name="date_public"  placeholder="Nhập vào ngày tuyển dụng">
                                </div><!-- /.form-group -->

                                <div class="form-group col-3">
                                    <label for="deadline">Hạn nộp hồ sơ</label>
                                    <input type="text" class="form-control" id="deadline" name="deadline"  placeholder="Nhập vào hạn nộp hồ sơ">
                                </div><!-- /.form-group -->

                                <div class="form-group col-3">
                                    <label for="vacancy">Số lượng tuyển dụng</label>
                                    <input type="number" class="form-control" id="vacancy" name="vacancy"  placeholder="Nhập vào số lượng tuyển dụng">
                                </div><!-- /.form-group -->

                                <div class="form-group col-3">
                                    <label for="job_nature">Loại hình công việc</label>
                                    <select name="job_nature" id="job_nature" class="form-control">
                                        <option value=""></option>
                                        <option value="3">Linh động</option>
                                        <option value="2">Full time</option>
                                        <option value="1">Part time</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-4">
                                    <label for="salary">Mức lương</label>
                                    <input type="text" class="form-control" id="salary" name="salary"  placeholder="Nhập vào mức lương (vd: 10-15 triệu)">
                                </div><!-- /.form-group -->


                                <div class="form-group col-4">
                                    <div class="row">
                                        <label for="salart_start">Mức lương tối thiểu</label>
                                        <input type="text" class="form-control col-10" id="salart_start" name="salart_start"  placeholder="Mức lương tối thiểu bằng số (vd: 10.000.000)" onChange="format_curency(this);">
                                        <span class="col-2" style="padding-top: 10px;">VNĐ</span>
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group col-4">
                                    <div class="row">
                                        <label for="salart_end">Mức lương tối đa</label>
                                        <input type="text" class="form-control col-10" id="salart_end" name="salart_end"  placeholder="Mức lương tối đa bằng số (vd: 10.000.000)" onChange="format_curency(this);">
                                        <span class="col-2" style="padding-top: 10px;">VNĐ</span>
                                    </div>
                                </div><!-- /.form-group -->
                            </div>



                            <div class="row">
                                <div class="form-group col-5">
                                    <label for="company_id">Chọn công ty</label>
                                    <select name="company_id" id="company_id" class="form-control">
                                        <option value=""></option>
                                        @forelse($companies as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group col-4">
                                    <label for="location">Địa chỉ nơi làm việc</label>
                                    <input type="text" class="form-control" id="location" name="location"  placeholder="Nhập vào địa chỉ cụ thể">
                                </div><!-- /.form-group -->

                                <div class="form-group col-3">
                                    <label for="position">Chức vụ</label>
                                    <input type="text" class="form-control" id="position" name="position"  placeholder="Nhập vào chức vụ">
                                </div><!-- /.form-group -->

                            </div>
                            <h5>Yêu cầu:</h5>
                            <div class="row">

                                <div class="form-group col-3">
                                    <label for="request_degree">Bằng cấp</label>
                                    <select name="request_degree" id="request_degree" class="form-control">
                                        <option value=""></option>
                                        <option value="1">Có</option>
                                        <option value="0">Không</option>
                                    </select>
                                </div>

                                <div class="form-group col-3">
                                    <label for="request_old">Độ tuổi</label>
                                    <input type="text" name="request_old" id="request_old" class="form-control"  placeholder="Nhập vào độ tuổi">
                                </div>

                                <div class="form-group col-3">
                                    <label for="request_experience">Kinh nghiệm</label>
                                    <select name="request_experience" id="request_experience" class="form-control">
                                        <option value=""></option>
                                        <option value="1">Có</option>
                                        <option value="0">Không</option>
                                    </select>
                                </div>

                                <div class="form-group col-3">
                                    <label for="request_sex">Giới tính</label>
                                    <select name="request_sex" id="request_sex" class="form-control">
                                        <option value=""></option>
                                        <option value="0">Không yêu cầu</option>
                                        <option value="1">Nam</option>
                                        <option value="2">Nữ</option>
                                    </select>
                                </div>

                            </div>




                        </fieldset><!-- /.fieldset -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btnSubmitFormPost">Tạo mới</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditPost">
                        <!-- .fieldset -->
                        <fieldset>
                            <div class="form-group">
                                <label for="edit_title">Tiêu đề</label> <input type="text" class="form-control" id="edit_title" name="title" aria-describedby="tf1Help" placeholder="Nhập vào tiêu đề">
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label for="cedit_ategory_id">Danh mục</label>
                                <select name="category_id" id="edit_category_id" class="form-control">
                                    <option value=""></option>
                                    @forelse($list_category as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <!-- .form-group -->
                            <div class="form-group">
                                <label for="edit_descriptions">Mô tả</label>
                                <textarea name="descriptions" id="edit_descriptions" rows="5" placeholder="Nhập vào mô tả"></textarea>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label for="edit_content">Nội dung</label>
                                <textarea name="content" id="edit_content" cols="30" rows="10" placeholder="Nhập vào mô tả"></textarea>
                            </div><!-- /.form-group -->

                            <div class="row">
                                <div class="form-group col-3">
                                    <label for="edit_date_public">Ngày tuyển dụng</label>
                                    <input type="text" class="form-control" id="edit_date_public" name="date_public"  placeholder="Nhập vào ngày tuyển dụng">
                                </div><!-- /.form-group -->

                                <div class="form-group col-3">
                                    <label for="edit_deadline">Hạn nộp hồ sơ</label>
                                    <input type="text" class="form-control" id="edit_deadline" name="deadline"  placeholder="Nhập vào hạn nộp hồ sơ">
                                </div><!-- /.form-group -->

                                <div class="form-group col-3">
                                    <label for="edit_vacancy">Số lượng tuyển dụng</label>
                                    <input type="number" class="form-control" id="edit_vacancy" name="vacancy"  placeholder="Nhập vào số lượng tuyển dụng">
                                </div><!-- /.form-group -->

                                <div class="form-group col-3">
                                    <label for="edit_job_nature">Loại hình công việc</label>
                                    <select name="job_nature" id="edit_job_nature" class="form-control">
                                        <option value=""></option>
                                        <option value="3">Linh động</option>
                                        <option value="2">Full time</option>
                                        <option value="1">Part time</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-4">
                                    <label for="edit_salary">Mức lương</label>
                                    <input type="text" class="form-control" id="edit_salary" name="salary"  placeholder="Nhập vào mức lương (vd: 10-15 triệu)">
                                </div><!-- /.form-group -->


                                <div class="form-group col-4">
                                    <div class="row">
                                        <label for="edit_salart_start">Mức lương tối thiểu</label>
                                        <input type="text" class="form-control col-10" id="edit_salart_start" name="salart_start"  placeholder="Mức lương tối thiểu bằng số (vd: 10.000.000)" onChange="format_curency(this);">
                                        <span class="col-2" style="padding-top: 10px;">VNĐ</span>
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group col-4">
                                    <div class="row">
                                        <label for="edit_salart_end">Mức lương tối đa</label>
                                        <input type="text" class="form-control col-10" id="edit_salart_end" name="salart_end"  placeholder="Mức lương tối đa bằng số (vd: 10.000.000)" onChange="format_curency(this);">
                                        <span class="col-2" style="padding-top: 10px;">VNĐ</span>
                                    </div>
                                </div><!-- /.form-group -->
                            </div>

                            <div class="row">
                                <div class="form-group col-5">
                                    <label for="edit_company_id">Chọn công ty</label>
                                    <select name="company_id" id="edit_company_id" class="form-control">
                                        <option value=""></option>
                                        @forelse($companies as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group col-4">
                                    <label for="edit_location">Địa chỉ nơi làm việc</label>
                                    <input type="text" class="form-control" id="edit_location" name="location"  placeholder="Nhập vào địa chỉ cụ thể">
                                </div><!-- /.form-group -->

                                <div class="form-group col-3">
                                    <label for="edit_position">Chức vụ</label>
                                    <input type="text" class="form-control" id="edit_position" name="position"  placeholder="Nhập vào chức vụ">
                                </div><!-- /.form-group -->

                            </div>
                            <h5>Yêu cầu:</h5>
                            <div class="row">

                                <div class="form-group col-3">
                                    <label for="edit_request_degree">Bằng cấp</label>
                                    <select name="request_degree" id="edit_request_degree" class="form-control">
                                        <option value=""></option>
                                        <option value="1">Có</option>
                                        <option value="0">Không</option>
                                    </select>
                                </div>

                                <div class="form-group col-3">
                                    <label for="edit_request_old">Độ tuổi</label>
                                    <input type="text" name="request_old" id="edit_request_old" class="form-control">
                                </div>

                                <div class="form-group col-3">
                                    <label for="edit_request_experience">Kinh nghiệm</label>
                                    <select name="request_experience" id="edit_request_experience" class="form-control">
                                        <option value=""></option>
                                        <option value="1">Có</option>
                                        <option value="0">Không</option>
                                    </select>
                                </div>

                                <div class="form-group col-3">
                                    <label for="edit_request_sex">Giới tính</label>
                                    <select name="request_sex" id="edit_request_sex" class="form-control">
                                        <option value=""></option>
                                        <option value="0">Không yêu cầu</option>
                                        <option value="1">Name</option>
                                        <option value="2">Nữ</option>
                                    </select>
                                </div>

                            </div>




                        </fieldset><!-- /.fieldset -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btnEditFormPost">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection
