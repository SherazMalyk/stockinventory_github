var manageuserTable;
var skillTable;
var degreeTable;
$(document).ready(function() {
  addRow();

  manageuserTable = $("#userTable").DataTable({
    dom:"<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons:[
      {
        text:'<i class="fa fa-print"></i>',
        extend:'print',
        className:'btn-success',
        // exportOptions: { stripHtml: true },
        exportOptions: { stripHtml: false}
      },
      {
        text:'<i class="fa fa-download"></i>',
        extend:'excel',
        className:'btn-info'
      },
      {
        text:'<i class="fa fa-upload"></i>',
        extend:'colvis',
        className:'btn-warning'
      }
    ],

    "stateSave": true,
    "autoWidth"   : true,
    "responsive": true,
    "ajax": {
      url:"ajax/userController.php",
      data:{action:"loadUsers"},
      type:"post",
    },
    'order': []
  });//userDatatable

  skillTable = $("#skillTable").DataTable({
    dom:"<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons:[
      {
        text:'<i class="fa fa-print"></i>',
        extend:'print',
        className:'btn-success',
        // exportOptions: { stripHtml: true },
        exportOptions: { stripHtml: false}
      },
      {
        text:'<i class="fa fa-download"></i>',
        extend:'excel',
        className:'btn-info'
      },
      {
        text:'<i class="fa fa-upload"></i>',
        extend:'colvis',
        className:'btn-warning'
      }
    ],

    "stateSave": true,
    "autoWidth"   : true,
    "responsive": true,
    "ajax": {
      url:"ajax/userController.php",
      data:{action:"loadSKills"},
      type:"post",
    },
    'order': []
  });//skillDatatable

  degreeTable = $("#degreeTable").DataTable({
    dom:"<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons:[
      {
        text:'<i class="fa fa-print"></i>',
        extend:'print',
        className:'btn-success',
        // exportOptions: { stripHtml: true },
        exportOptions: { stripHtml: false}
      },
      {
        text:'<i class="fa fa-download"></i>',
        extend:'excel',
        className:'btn-info'
      },
      {
        text:'<i class="fa fa-upload"></i>',
        extend:'colvis',
        className:'btn-warning'
      }
    ],

    "stateSave": true,
    "autoWidth"   : true,
    "responsive": true,
    "ajax": {
      url:"ajax/userController.php",
      data:{action:"loadDegrees"},
      type:"post",
    },
    'order': []
  });//DegreeDatatable

  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000
  });

  $(".form").on('submit',function(e){
    e.preventDefault();
    //var show = $('#select2').select2('data');
    //console.log(show)
    var form = $(this)
    $.ajax({
      url:form.attr('action'),
      // data:form.serialize(),
      data: new FormData(this),
      processData: false,
      contentType: false,
      dataType:'json',
      type:'post',
      success:function(data){
        $(".form")[0].reset();
        $('.select2768').val('').trigger("change");
        $('.select3').val('').trigger("change");
        if (data.sts=='danger') {
          Toast.fire({
            icon: 'error',
            title: data.msg
          })
        }else {
          Toast.fire({
            icon: data.sts,
            title: data.msg
          })
        }
        //var count = 1
        //$('.add_row').attr('count', count)
        var count = $(".add_row").attr('count');
        count --;
        while (count != 1) {
          //alert(count)
          deleteRow(count);
          count --;
        }
        //alert(count)
        manageuserTable.ajax.reload(null, false);
        skillTable.ajax.reload(null, false);
        degreeTable.ajax.reload(null, false);
      }
    })//Ajax Call
    return false;
  })//form binding

/*var data = [
    {
      id: 0,
      text: 'enhancement'
    },
    {
      id: 1,
      text: 'bug'
    },
    {
      id: 2,
      text: 'duplicate'
    },
    {
      id: 3,
      text: 'invalid'
    },
    {
      id: 4,
      text: 'wontfix'
    }
  ];*/
  var data
  $('.select2768').select2({
    theme:'bootstrap4',
    ajax:{
      url:'ajax/userController.php',
      data:{action:'loadSKillsInS2'},
      dataType:'json',
      type:'post',
      processResults: function (data) {
        //console.log(data)
        return {results: data};
        // return {
        //   // results: $.map(data, function (item) {
        //   //   return {
        //   //     text: item[1],
        //   //     id: item[0],
        //   //   }
        //   // })
        // }
      }
    }//Ajax Call
  })//SELECT 2


});//DOCUMENT READY



/*DELETE User Function*/
function deleteUser(id){
  var i = confirm("Do You Really Want to Delete ID# "+id);
  if (i) {
    $.ajax({
      url:"ajax/userController.php?action=deleteUser&deleteUserId="+id,
      dataType:"text",
      type:"get",
      success:function(res){
        $("#responseArea").html(res);
        $("#responseArea").show(100).fadeOut(2000);
        manageuserTable.ajax.reload(null, false);
      }
    })//Ajax Call
  }//if
}//deleteUser

/*DELETE skill Function*/
function deleteSkill(id){
  var i = confirm("Do You Really Want to Delete ID# "+id);
  if (i) {
    $.ajax({
      url:"ajax/userController.php?action=deleteSkill&deleteSkillId="+id,
      dataType:"html",
      type:"get",
      success:function(res){
        $("#responseArea").html(res);
        $("#responseArea").show(100).fadeOut(2000);
        manageuserTable.ajax.reload(null, false);
      }
    })//Ajax Call
  }//if
}//deleteSkill

/*DELETE Degree Function*/
function deleteDegree(id){
  var i = confirm("Do You Really Want to Delete ID# "+id);
  if (i) {
    $.ajax({
      url:"ajax/userController.php?action=deleteDegree&deleteDegreeId="+id,
      dataType:"html",
      type:"get",
      success:function(res){
        $("#responseArea").html(res);
        $("#responseArea").show(100).fadeOut(2000);
        manageuserTable.ajax.reload(null, false);
        skillTable.ajax.reload(null, false);
        degreeTable.ajax.reload(null, false);
      }
    })//Ajax Call
  }//if
}//deleteDegree

/*EDTT User Function*/
function editUser(id){
  $(".select2768").empty();
  $.ajax({
    url:"ajax/userController.php?action=editUser&editUserId="+id,
    dataType:"json",
    type:"post",
    success:function(response){
      // var resresponse = $.parseJSON(res);
      // alert(resresponse.output)
      $("#user_id").val(response[0].user_id)      
      $("#user_name").val(response[0].user_name)
      $("#user_email").val(response[0].user_email)
      $("#user_phone").val(response[0].user_phone)
      $("#user_sts").val(response[0].user_sts)
      
      // var select2768 = $(".select2768").select2();
      // var option = new Option( response.user_name, response.user_id );
      // select2768.append(option).trigger('change')
      // console.log(response.skill_id)
      // $(".select2768").select2().val(response.skill_id).trigger('change.select2');
      // var newOption = new Option("Hello", "1", false, false);

      // Skill
      $.each(response[1], function(index, val) {
        var option = new Option(response[1][index].text, response[1][index].id, true, true);
        $(".select2768").append(option).trigger('change');
      });

      //degrees
      $.each(response[2], function(index, val) {
        addRow()
        var option = new Option(val.text, val.id, true, true);
        $("#select3_"+(index+1)).append(option).trigger('change');
        console.log(response[3])
        $("#user_hobb_"+(index+1)).val(response[3][index].text)
        $('#user_hobb_id'+(index+1)).val(response[3][index].id)
      });

      
      //$("#user_pic").attr("src","img/"+response.user_pic)
      /*if ($("#select2").find("option[value=" + skills + "]").length) {
        $("#select2").val(skills).trigger("change");
      } else { 

        // Create the DOM option that is pre-selected by default
        var newState = new Option(skills, skills, true, true);
        // Append it to the select
        $("#select2").append(newState).trigger('change');
      } */
    }
  })//Ajax Call
}//editUser

/*EDTT Skill Function*/
function editSkill(id){
  $.ajax({
    url:"ajax/userController.php?action=editSKill&editSkillId="+id,
    dataType:"json",
    type:"get",
    success:function(res){
      $("#skill_id").val(res.skill_id)      
      $("#skill_name").val(res.skill_name)
      $("#skill_details").val(res.skill_details)
      
      /*if ($("#select2").find("option[value=" + skills + "]").length) {
        $("#select2").val(skills).trigger("change");
      } else { 

        // Create the DOM option that is pre-selected by default
        var newState = new Option(skills, skills, true, true);
        // Append it to the select
        $("#select2").append(newState).trigger('change');
      }*/ 
    }
  })//Ajax Call
}//editSKill

/*EDTT Degree Function*/
function editDegree(id){
  $.ajax({
    url:"ajax/userController.php?action=editDegree&editDegreeId="+id,
    dataType:"json",
    type:"get",
    success:function(res){
      $("#degree_id").val(res.degree_id)      
      $("#degree_name").val(res.degree_name)
      $("#degree_duration").val(res.degree_duration)
      
      /*if ($("#select2").find("option[value=" + skills + "]").length) {
        $("#select2").val(skills).trigger("change");
      } else { 

        // Create the DOM option that is pre-selected by default
        var newState = new Option(skills, skills, true, true);
        // Append it to the select
        $("#select2").append(newState).trigger('change');
      }*/ 
    }
  })//Ajax Call
}//editDegree

/*function add_hob_row() {
  var count = $(".add_hob_row").attr('count')
  var row = '<div class="row form-group dynamic_hobb_row_'+count+'">\
                <div class="col-sm-5">\
                  <input type="text" class="form-control" id="first_hobb_'+count+'" name="user_hobb_first[]">\
                </div>\
                <div class="col-sm-5">\
                  <input type="text" class="form-control" id="second_hobb_'+count+'" name="user_hobb_second[]">\
                </div>\
                <div class="col-sm-1">\
                <button type="button" onclick="deleteHobbRow('+count+')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>\
                </div>\
              </div>'
  $(".add_hob_row").append(row)

  count++;
  $('.add_hob_row').attr('count', count);
  
}*///ADD HOBBY ROW

function addRow() {
  var count = $(".add_row").attr('count')
  var row = '<div class="row addRowFunction dynamic_row_'+count+' form-group">\
              <div class="col-sm-6">\
                <select class="form-control select3" id="select3_'+count+'" name="select3[]" style="width: 100%;">\
                </select>\
              </div> <!-- inner col -->\
              <div class="col-sm-5">\
                  <input type="text" class="form-control" id="user_hobb_'+count+'" name="user_hobb[]">\
                  <input type="hidden" class="form-control" id="user_hobb_id'+count+'" name="hobb_user_id[]">\
                </div>\
              <div class="col-sm-1">\
                <button type="button" onclick="deleteRow('+count+')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>\
                </div>\
            </div>';
            $('.add_row').append(row)
            $('#select3_'+count).select2({
              theme:'bootstrap4',
              ajax:{
                url:'ajax/userController.php',
                data:{action:'loadDegreesInS3', check_param: ""},
                dataType:'json',
                type:'post',
                processResults: function (data3) {
                  console.log(data3)
                  return {results: data3};
                  // return {
                  //   // results: $.map(data, function (item) {
                  //   //   return {
                  //   //     text: item[1],
                  //   //     id: item[0],
                  //   //   }
                  //   // })
                  // }
                }
              }//Ajax Call
            })//SELECT 2

  count++;
  $('.add_row').attr('count', count);
  // $('.add_row').attr('count', count).append(row)
}

function deleteRow(count) {
  $(".dynamic_row_"+count).remove();
}

function deleteHobbRow(count) {
  //alert()
  $(".dynamic_hobb_row_"+count).remove();
}


/*<div class="row dynamic_row_'+count+' form-group">\
              <div class="col-sm-9">\
                <input type="text" name="user_degree[]" class="form-control form-control-sm">\
              </div> <!-- inner col -->\
              <div class="col-sm-3">\
                <button type="button" onclick="deleteRow('+count+')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>\
              </div> <!-- inner col -->\
            </div>*/

  // function() {
  //   var Toast = Swal.mixin({
  //     toast: true,
  //     position: 'top-end',
  //     showConfirmButton: false,
  //     timer: 3000
  // });