<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
    header('location:../login.php');
}

if($_SESSION["type"] != 'master')
{
    header("location:../index.php");
}

include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');


?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
     
         <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<span id="alert_action"></span>
    <div class="container">
      <div class="row">
        <div class="col-md-12">


                   <div class="card">
              <div class="card-header">
                <h3 class="card-title">Employee List</h3>
               
                <button type="button" name="add" id="add_employee"   class="btn btn-primary btn-xs float-right">Add</button>
               
              </div>
              <!-- /.card-header -->
            <div class="card-body">
  <table id="employee_data" class="table table-bordered table-striped">
                    <thead>
              <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last name</th>
                <th>Department</th>
                <th>Salary</th>
                <th>Join Date</th>
                <th>DOB</th>
                <th>End Date</th>
                <th>Position</th>
                <th>Sex</th>
                <th>Employee Status</th>
                <th>Edit</th>
              
                <th>Delete</th>
              </tr>
            </thead>
                  </table>
      
      
            </div>
          </div>
          
          
        </div>
        
      </div>

   
    </div>




  </div>



<!--Modal ya kuingiza new users-->

  <div id="emplModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="employee_form">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                      <h4 class="modal-title"><i class="fa fa-plus"></i> Add Brand</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                        <span id="message"></span>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" required />
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" required />
                                </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Department</label>
                                    <select type="text" name="department" id="department" class="form-control" required>
                                        <option value="">Please Select Department</option>
                                       <?php echo fill_department_list($connect) ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Salary</label>
                                    <input type="number" name="salary" id="salary" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Tribe</label>
                                    <select type="text" name="tribe" id="tribe" class="form-control" required>
                                        <option value="">Please Select Tribe</option>
                                        <?php echo fill_tribe_list($connect) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enter Join Date</label>
                                    <input type="text" name="join_date" id="join_date" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enter DOB</label>
                                   <input type="text" name="dob" id="dob" class="form-control" required />
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enter End Contract Date</label>
                                 <input type="text" name="end_date" id="end_date" class="form-control" required />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enter Position</label>
                                     <select type="text" name="position" id="position" class="form-control" required>
                                        <option value="">Please Select Position</option>
                                       <?php echo fill_position_list($connect) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enter Region</label>
                                    <select type="text" name="region" id="region" class="form-control" required>
                                        <option value="">Please Select Region</option>
                                        <?php echo fill_region_list($connect) ?>
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enter Region Country</label>
                                     <select type="text" name="country" id="country" class="form-control" required>
                                        <option value="">Please Select Country</option>
                                        <?php echo fill_country_list($connect) ?>
                                    </select>
                                </div>
                            </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter Sex</label>
                                    <select type="text" name="sex" id="sex" class="form-control" required>
                                        <option value="">Please Select Sex</option>
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                       
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter Notes</label>
                                    <textarea type="text" name="notes" id="notes" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="employee_id" id="employee_id" />
                        <input type="hidden" name="btn_action" id="btn_action" />
                        <input type="submit" name="action_employee" id="action_employee" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
     </div>


<script>
$(document).ready(function(){

$('#add_employee').click(function(){
        $('#emplModal').modal('show');
        $('#employee_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Client");
        $('#action_employee').val('Add');
        $('#btn_action').val('Add');
    });

    $(document).on('submit','#employee_form', function(event){
        event.preventDefault();
        $('#action_employee').attr('disabled','disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"employee/employee_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#employee_form')[0].reset();
                $('#emplModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action_employee').attr('disabled', false);
                employeedataTable.ajax.reload();
              
            }
        })
    });
    


     $(document).on('click', '.update', function(){
        var employee_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"employee/employee_action.php",
            method:"POST",
            data:{employee_id:employee_id, btn_action:btn_action},
            dataType:"json",
            success:function(data)
      {
         //console.log(employee_id);

                $('#emplModal').modal('show');
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('#department').val(data.department_id);
                $('#salary').val(data.salary);
                $('#email').val(data.email);
                $('#tribe').val(data.tribe_id);
                $('#join_date').val(data.join_date);
                $('#dob').val(data.dob);
                $('#end_date').val(data.end_date);
                $('#position').val(data.position_id);
                $('#region').val(data.region_id);
                $('#country').val(data.country_id);
                $('#sex').val(data.sex);
                $('#notes').val(data.notes);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Employee");
                $('#employee_id').val(employee_id);
                $('#action_employee').val('Edit');
                $('#btn_action').val('Edit');
         
      }
    })
  });






  $(document).on('click','.delete', function(){
    var employee_id = $(this).attr("id");
    var status  = $(this).data('status');
    var btn_action = 'delete';
    if(confirm("Are you sure you want to change status?"))
    {
      $.ajax({
        url:"employee/employee_action.php",
        method:"POST",
        data:{employee_id:employee_id, status:status, btn_action:btn_action},
        success:function(data)
        {
          $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
          employeedataTable.ajax.reload();
        }
      })
    }
    else
    {
      return false;
    }
  });


  var employeedataTable = $('#employee_data').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"employee/employee_fetch.php",
      type:"POST"
    },
    "columnDefs":[
      {
        "targets":[11, 12],
        "orderable":false,
      },
    ],
    "pageLength": 10
  });

});
</script>

<?php

include('includes/footer.php');
?>





