$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#class_id').select2({
    placeholder:'Chọn Lớp',
    width:'100%'
});

$('#edit_class_id').select2({
    placeholder:'Chọn Lớp',
    width:'100%'
})

var studentTable = $('#studentTable').DataTable({
    processing: true,
    serverSide: true,
    searching: true,
    destroy: true,
    responsive: true,
    ajax: {
        url: '/students/get-data/',
    },
    language: {
        sProcessing: "Đang xử lý...",
        sLengthMenu: "Xem _MENU_ mục",
        sZeroRecords: "Không tìm thấy dòng nào phù hợp",
        sInfo: "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
        sInfoEmpty: "Đang xem 0 đến 0 trong tổng số 0 mục",
        sInfoFiltered: "(được lọc từ _MAX_ mục)",
        sSearch: 'Tìm kiếm',
        lengthMenu: '_MENU_ bản ghi/trang',
        oPaginate: {
            "sFirst": "Đầu",
            "sPrevious": "Trước",
            "sNext": "Tiếp",
            "sLast": "Cuối"
        }
    },
    columns: [
        {data: 'DT_RowIndex', searchable: false, orderable: false,},
        {data: 'code', name: 'code' ,searchable: true, orderable: false,},
        {data: 'name', name: 'name' ,searchable: true, orderable: true,},
        {data: 'father_name', name: 'father_name',searchable: true, orderable: false,},
        {data: 'phone', name: 'phone',searchable: true, orderable: false,},
        {data: 'mother_name', name: 'mother_name',searchable: true, orderable: false,},
        {data: 'parent_phone', name: 'parent_phone',searchable: true, orderable: false,},
        {data: 'home_town', name: 'student.home_town',searchable: true, orderable: true,},
        {data: 'class', name: 'class',searchable: true, orderable: false,},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});


$('#formEditStudent').validate({
    rules:{
        name:{
            required:true,
        },
        code:{
            required:true,
        },
        
        class_id:{
            required:true,
        }
    },
    messages:{
        name:{
            required:'Vui lòng nhập họ và tên',
        },
        code:{
            required:'Vui lòng nhập mã học sinh',
        },
        class_id:{
            required:'Vui lòng chọn lớp',
        }
    }
})

$('#formAddStudent').validate({
    rules:{
        name:{
            required:true,
        },
        code:{
            required:true,
        },
        class_id:{
            required:true,
        }
    },
    messages:{
        name:{
            required:'Vui lòng nhập họ và tên',
        },
        code:{
            required:'Vui lòng nhập mã học sinh',
        },
        class_id:{
            required:'Vui lòng chọn lớp',
        }
    }
})

$('#btnAddStudent').click(function () {
    $('#formAddStudent')[0].reset();
    $('#formAddStudent').validate().resetForm();
    $('#addStudentModal').modal('show');
});

$('#btnSubmitFormStudent').click(function (e) {
    e.preventDefault();
    if(!$('#formAddStudent').valid()) return false;

    let data = $('#formAddStudent').serialize();

    $.ajax({
        type: 'post',
        url: '/students/store',
        data:data,
        success: function (res) {
            if(!res.error){
                studentTable.ajax.reload();
                $('#addStudentModal').modal('hide');
                toastr.success(res.message)
            }else {
                toastr.error(res.message)
            }
        }
    })
})

$('#studentTable').on('change','.switcher-input',function(){
    let id = $(this).attr('data-id');
    $.ajax({
        type:'put',
        url:'/students/change-status/'+id,
        success:function(res){
            if(!res.error){
                toastr.success(res.message);
            }else{
                toastr.error(res.message);
            }
        }
    });
})

$('#studentTable').on('click','.btn-edit',function(e){
    e.preventDefault();
    $('#formEditStudent').validate().resetForm();
    let id = $(this).attr('data-id');

    $.ajax({
        type:'get',
        url :'/students/'+id+'/edit',
        success:function(res){
            if(!res.error){
                $('#edit_name').val(res.student.name);
                $('#edit_code').val(res.student.code);
                $('#edit_phone').val(res.student.phone);
                $('#edit_mother_name').val(res.student.mother_name);
                $('#edit_father_name').val(res.student.father_name);
                $('#edit_parent_phone').val(res.student.parent_phone);
                $('#edit_home_town').val(res.student.home_town);
                $('#edit_class_id').select2().val(res.student.class_id).trigger('change');
                $('#formEditStudent').attr('data-id',res.student.id);
                $('#editStudentModal').modal('show');
            }
        }
    })

});

$('#btnEditFormStudent').click(function (e) {
    e.preventDefault();
    if(!$('#formEditStudent').valid()) return false;
    let id = $('#formEditStudent').attr('data-id');
    let data = $('#formEditStudent').serialize();

    $.ajax({
        type: 'put',
        url: '/students/update/'+id,
        data:data,
        success: function (res) {
            if(!res.error){
                studentTable.ajax.reload();
                $('#editStudentModal').modal('hide');
                toastr.success(res.message)
            }else {
                toastr.error(res.message)
            }
        }
    })
})

$('#studentTable').on('click','.btn-delete',function(e){
    e.preventDefault();
    let id = $(this).attr('data-id');
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa ?',
        text: "Dữ liệu không thể phục hồi!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý!',
        cancelButtonText: 'Đóng'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type:'delete',
                url:'/students/delete/'+id,
                success:function(res){
                    if(!res.error){
                        studentTable.ajax.reload();
                        toastr.success(res.message)
                    }else{
                        toastr.error(res.message)
                    }
                }
            })
        }else{
            toastr.info('Bạn đã đóng hành động!');
        }
    })
});
