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
    url: '/admin/exam/get-data',
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
    {data: 'name', name: 'exam.name' , orderable: false,},
    {data: 'year', name: 'exam.year',orderable: false,},
    {data: 'semester', name: 'exam.semester', orderable: false,},
    {data: 'description', name: 'exam.description', orderable: false,},
    {data: 'action', name: 'action', orderable: false, searchable: false},
  ]
});


$('#formAddTeacher').validate({
  rules:{
    name:{
      required:true,
    },
    year:{
      required:true,
    },
    semester:{
      required: true
    },
  },
  messages:{
    name:{
      required:'Vui lòng nhập ten kỳ thi',
    },
    year:{
      required:'Vui lòng nhập năm học',
    },
    semester:{
      required:'Vui lòng nhập học kì',
    },
  }
})

$('#formEditTeacher').validate({
  rules:{
    name:{
      required:true,
    },
    year:{
      required:true,
    },
    semester:{
      required: true
    },
  },
  messages:{
    name:{
      required:'Vui lòng nhập ten kỳ thi',
    },
    year:{
      required:'Vui lòng nhập năm học',
    },
    semester:{
      required:'Vui lòng nhập học kì',
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
    url: '/admin/exam/store',
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
    url :'/admin/exam/'+id+'/edit',
    success:function(res){
      if(!res.error){
        $('#edit_name').val(res.exam.name);
        $('#edit_year').val(res.exam.year);
        $('#edit_semester').val(res.exam.semester);
        $('#edit_description').val(res.exam.descripton);
        $('#formEditTeacher').attr('data-id',res.exam.id);
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
    url: '/admin/exam/update/'+id,
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
        url:'/admin/exam/delete/'+id,
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
