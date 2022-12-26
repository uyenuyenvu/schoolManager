$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('.point').focusout(function (e){
  e.preventDefault()
  let id = $(this).attr('data-id');
  let studentId = $(this).attr('student-id');
  let value = $(this).val();
  if (value.length>0){
    $.ajax({
      type: 'put',
      url: '/admin/point/update/'+id,
      data:{
        number: value
      },
      success: function(res){
        $('#std'+studentId).text(res.count)
    }
    })
  }
})

$('.teacher_option').on('change', function (e){
  e.preventDefault()
  let classId = $(this).attr('class-id');
  let subjectId = $(this).attr('subject-id');
  let teacherId = $(this).val();
  if (teacherId.length>0){
    $.ajax({
      type: 'put',
      url: '/admin/assignment/update',
      data:{
        classId, subjectId, teacherId
      },
      success: function(res){
          console.log(res)
    }
    })
  }
})
