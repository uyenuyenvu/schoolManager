$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var teacherTable = $('#teacherTable').DataTable({
    processing: true,
    serverSide: true,
    searching: true,
    destroy: true,
    responsive: true,
    ajax: {
        url: '/admin/teachers/get-data',
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
        {data: 'name', name: 'teacher.name' , orderable: false,},
        {data: 'title', name: 'teacher.title' , orderable: false,},
        {data: 'birthday', name: 'teacher.birthday' , orderable: false,},
        {data: 'email', name: 'teacher.email',orderable: false,},
        {data: 'phone', name: 'teacher.phone', orderable: false,},
        {data: 'is_active', name: 'is_active', orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});


$('#formAddTeacher').validate({
    rules:{
        name:{
            required:true,
        },
        email:{
            required:true,
        },
        phone:{

        },
    },
    messages:{
        name:{
            required:'Vui lòng nhập họ và tên',
        },
        email:{
            required:'Vui lòng nhập email',
        },
        phone:{

        },
    }
})

$('#formEditTeacher').validate({
    rules:{
        name:{
            required:true,
        },
        email:{
            required:true,
        },
        phone:{

        },
    },
    messages:{
        name:{
            required:'Vui lòng nhập họ và tên',
        },
        email:{
            required:'Vui lòng nhập email',
        },
        phone:{

        },
    }
})

$('#btnAddTeacher').click(function () {
    $('#formAddTeacher')[0].reset();
    $('#formAddTeacher').validate().resetForm();
    $('#addTeacherModal').modal('show');
});

$('#btnSubmitFormTeacher').click(function (e) {
    e.preventDefault();
    if(!$('#formAddTeacher').valid()) return false;

    let data = $('#formAddTeacher').serialize();

    $.ajax({
        type: 'post',
        url: '/admin/teachers/store',
        data:data,
        success: function (res) {
            if(!res.error){
                teacherTable.ajax.reload();
                $('#addTeacherModal').modal('hide');
                toastr.success(res.message)
            }else {
                toastr.error(res.message)
            }
        }
    })
})

$('#teacherTable').on('change','.switcher-input',function(){
    let id = $(this).attr('data-id');
    $.ajax({
        type:'put',
        url:'/admin/teachers/change-status/'+id,
        success:function(res){
            if(!res.error){
                toastr.success(res.message);
            }else{
                toastr.error(res.message);
            }
        }
    });
})

$('#teacherTable').on('click','.btn-edit',function(e){
    e.preventDefault();
    $('#formEditTeacher').validate().resetForm();
    let id = $(this).attr('data-id');

    $.ajax({
        type:'get',
        url :'/admin/teachers/'+id+'/edit',
        success:function(res){
            if(!res.error){
                $('#edit_name').val(res.teacher.name);
                $('#edit_email').val(res.teacher.email);
                $('#edit_phone').val(res.teacher.phone);
                $('#formEditTeacher').attr('data-id',res.teacher.id);
                $('#editTeacherModal').modal('show');
            }
        }
    })

});

$('#btnEditFormTeacher').click(function (e) {
    e.preventDefault();
    if(!$('#formEditTeacher').valid()) return false;
    let id = $('#formEditTeacher').attr('data-id');
    let data = $('#formEditTeacher').serialize();

    $.ajax({
        type: 'put',
        url: '/admin/teachers/update/'+id,
        data:data,
        success: function (res) {
            if(!res.error){
                teacherTable.ajax.reload();
                $('#editTeacherModal').modal('hide');
                toastr.success(res.message)
            }else {
                toastr.error(res.message)
            }
        }
    })
})

$('#teacherTable').on('click','.btn-delete',function(e){
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
                url:'/admin/teachers/delete/'+id,
                success:function(res){
                    if(!res.error){
                        teacherTable.ajax.reload();
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
