$(function(){
  var emp_id = $('input[name="emp_id"]').val();
  $('.ladda-button._delete-profile').ladda('bind',{
    timeout: 6000
  });
  //$('form#_employee-form input[type="text"]').val('');
  //$('textarea').val('');
  //$('select').val(0).trigger('change');
  //alert(base_url);

  $.ajax({
    //type: "POST",
    dataType: 'json',
    url: base_url+"pcgadmin/employee/get_detail/"+emp_id,
    //data: data,
    success: function(data){
      console.log(data);
      var emp = "";
      if(data.stat === "success"){
        emp = data.data[0];
        $('input[name="name"]').val(emp.profile_name);
        $('input[name="lastname"]').val(emp.profile_lastname);
        $('input[name="ref-id"]').val(emp.profile_ref_id);
        $('input[name="current_addr"]').val(emp.profile_c_addr);
        $('input[name="current_post"]').val(emp.profile_c_post);
        $('select[name="current_province"]').val(emp.profile_c_province).trigger('change');
        $('input[name="phone"]').tagsinput('add',emp.profile_phone);
        $('input[name="line"]').val(emp.profile_line);
        $('input[name="email"]').val(emp.profile_email);
        $('input[name="skill"]').val(emp.profile_skill);
        $('input[name="skill_brunch"]').val(emp.profile_skill_branch);
        $('input[name="skill_grade"]').val(emp.profile_skill_grade);
        $('input[name="tarent"]').tagsinput('add',emp.profile_tarent);
        $('select[name="work_group"]').val(emp.profile_workgroup_id).trigger('change');
        $('select[name="warehouse"]').val(emp.profile_warehouse_id).trigger('change');
        $('select[name="level"]').val(emp.profile_level_id).trigger('change');
        $('input[name="birth_addr"]').val(emp.profile_b_addr);
        $('select[name="birth_province"]').val(emp.profile_b_province).trigger('change');
        $('input[name="birth_post"]').val(emp.profile_b_post);
        $('textarea[name="note"]').val(emp.profile_note);
      }
      if(emp === ""){
        location.replace(base_url+"pcgadmin/employee.html");
      }
    }
  });
  $('._delete-profile').on('click',function(){
    var emp_id = $(this).attr('data-id');
    $.ajax({
      //type: "POST",
      //dataType: 'json',
      url: base_url+"pcgadmin/employee/delete_data/"+emp_id,
      //data: data,
      success: function(data){
        console.log(data);
        location.replace(base_url+"pcgadmin/employee.html");
      }
    });
  });
});
