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
    url: '/admin/team/get-data',
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
    {data: 'name', name: 'team.name' , orderable: false,},
    {data: 'students', name: 'students',orderable: false,},
    {data: 'teacher', name: 'teacher', orderable: false,},
    {data: 'action', name: 'action', orderable: false, searchable: false},
  ]
});


$('#formAddTeacher').validate({
  rules:{
    name:{
      required:true,
    },
    teacher_id:{

    },
    division_id:{
      required: true
    },
  },
  messages:{
    name:{
      required:'Vui lòng nhập họ và tên',
    },
    teacher_id:{

    },
    division_id:{
      required:'Vui lòng chọn khối',
    },
  }
})

$('#formEditTeacher').validate({
  rules:{
    name:{
      required:true,
    },
    teacher_id:{

    },
    division_id:{
      required: true
    },
  },
  messages:{
    name:{
      required:'Vui lòng nhập họ và tên',
    },
    teacher_id:{

    },
    division_id:{
      required:'Vui lòng chọn khối',
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
    url: '/admin/team/store',
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
    url :'/admin/team/'+id+'/edit',
    success:function(res){
      if(!res.error){
        $('#edit_name').val(res.team.name);
        $('#edit_teacher_id').val(res.team.teacher_id);
        $('#edit_division_id').val(res.team.division_id);
        $('#formEditTeacher').attr('data-id',res.team.id);
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
    url: '/admin/team/update/'+id,
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
        url:'/admin/team/delete/'+id,
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
