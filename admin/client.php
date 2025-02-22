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
              <li class="breadcrumb-item active">Client List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<div class="container">
<?php if(isset($_SESSION['response'])){ ?>
<div class="alert alert-<?= $_SESSION['res_type'];  ?> alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?= $_SESSION['response']; ?>
</div>
<?php } unset($_SESSION['response']); ?>
</div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">


                   <div class="card">
              <div class="card-header">
                <h3 class="card-title">Client List</h3>
               
                <button type="button" name="add" id="add_client" data-toggle="modal" data-target="#clientModal" class="btn btn-primary btn-xs float-right">Add</button>
              </div>
              <!-- /.card-header -->
            <div class="card-body">
   <table id="client_data" class="table table-bordered table-striped">
                    <thead>
              <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Address1</th>
                <th>Date</th>
                <th>1STINV.</th>
                <th>Last Inv</th>
                <th>Pay Terms</th>
                <th>Status</th>
                <th>Edit</th>
                <th>View</th>
                               
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



<!--Modal ya Kuedit client-->

 <div id="editclient"  class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="client_form" action="edit_client.php"  enctype="multipart/form-data">
                <div class="modal-content">

               
                    <div class="modal-header bg-info">
                      <h4 class="modal-title"> Add Client</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Client Name</label>
                                    <input type="text" name="client_name1" id="client_name1" value="" class="form-control" required />
                                    <!--<input type="hidden" name="client_id" value="<?= $client_id; ?>">-->
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter City</label>
                                    <input type="text" name="city1" id="city1" value="" class="form-control" required />
                                </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Address1</label>
                                    <input type="text" name="address1" id="address1" value="" class="form-control" required />
                                </div>
                            </div>
                            
                            
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Address2</label>
                                    <input type="text" name="address2" id="address2" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter country</label>
                                    <input type="text" name="country1" id="country1" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Tin Number</label>
                                    <input type="text" name="tin1" id="tin1" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enter Due Days</label>
                                    <input type="number" name="due_days" id="due_days" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enter Due Type</label>
                                    <select type="text" name="due_type" id="due_type" value="" class="form-control" required>
                                        <option value="">Please Select</option>
                                        <option value="prepay">Prepay</option>
                                        <option value="invoice_date">Invoice Date</option>
                                        <option value="eom">EOM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Maxmum Credit</label>
                                    <input type="number" name="max_credit" id="max_credit" value="" class="form-control" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter VRN</label>
                                    <input type="text" name="vrn1" id="vrn1" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Post Code</label>
                                    <input type="text" name="post_code" id="post_code" value="" class="form-control" required />
                                </div>
                          </div>   
                         
                <div class="col-md-12">      
                  <div class="form-group">    
                    <div class="custom-file">
                      <!--<input type="hidden" name="oldimage" value="<?= $photo; ?>">-->
                      <input type="file" class="custom-file-input" name="image1" id="image1">
                      <input type="hidden"  name="oldimage" id="oldimage">
                      <img src="" width="120" class="img-thumbnail" name="image2" id="image2">
                      <span id="preview"></span>
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>   
                  </div>
                 </div>
                
            


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter Notes</label>
                                    <textarea type="text" name="client_notes" id="client_notes" class="form-control"></textarea>
                                </div>
                            </div>

                           
                            

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="client_idd" id="client_idd" />
                        <input type="hidden" name="btn_action" id="btn_action" />
                        <input type="submit" name="update_client" id="update_client" class="btn btn-info" value="Update" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
     </div>


<!--Modal ya kuingiza new client-->

 <div id="clientModal"  class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="client_form" action="insert_client_using_function.php" enctype="multipart/form-data">
                <div class="modal-content">

               
                    <div class="modal-header bg-info">
                      <h4 class="modal-title"> Add Client</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Client Name</label>
                                    <input type="text" name="client_name" id="client_name" value="" class="form-control" required />
                                    <!--<input type="hidden" name="client_id" value="<?= $client_id; ?>">-->
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter City</label>
                                    <input type="text" name="city" id="city" value="" class="form-control" required />
                                </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Address1</label>
                                    <input type="text" name="addressone" id="addressone" value="" class="form-control" required />
                                </div>
                            </div>
                            
                            
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Address2</label>
                                    <input type="text" name="addresstwo" id="addresstwo" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter country</label>
                                    <input type="text" name="country" id="country" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Tin Number</label>
                                    <input type="text" name="tin" id="tin" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enter Due Days</label>
                                    <input type="number" name="duedays" id="duedays" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enter Due Type</label>
                                    <select type="text" name="duetype" id="duetype" value="" class="form-control" required>
                                        <option value="">Please Select</option>
                                        <option value="prepay">Prepay</option>
                                        <option value="invoice_date">Invoice Date</option>
                                        <option value="eom">EOM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Maxmum Credit</label>
                                    <input type="number" name="maxcredit" id="maxcredit" value="" class="form-control" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter VRN</label>
                                    <input type="text" name="vrn" id="vrn" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Post Code</label>
                                    <input type="text" name="postcode" id="postcode" value="" class="form-control" required />
                                </div>
                          </div>   
                         
                <div class="col-md-12">      
                  <div class="form-group">    
                    <div class="custom-file">
                      
                      <input type="file" class="custom-file-input" name="image" id="customFile" onchange="getImagePreview(event)">
                    
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>  
                   
                  </div>
                 </div>
                
 <div id="preview1"></div> 
                <!--<div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>-->
             


        



                            


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter Notes</label>
                                    <textarea type="text" name="notes" id="notes"  class="form-control"></textarea>
                                </div>
                            </div>

                           
                            

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="client_idd" id="client_idd" />
                        <input type="hidden" name="btn_action" id="btn_action" />
                        <input type="submit" name="client_action" id="client_action" class="btn btn-info" value="Upload" />
                        <!--<button type="button"  id="addData" class="btn btn-info">Add</button>-->
                        <button type="button" name="add_picha"  class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
     </div>



       <script>
$(document).ready(function(){

 bsCustomFileInput.init();



  // $('#add_client').click(function(){
  //   $('#client_Modal').modal('show');
  //   $('#client_form')[0].reset();
  //   $('.modal-title').html("<i class='fa fa-plus'></i> Add Client");
  //   $('#client_action').val('Add');
  //   $('#btn_action').val('Add');
  // });

  // $(document).on('submit','#client_form', function(event){
  //   event.preventDefault();
  //   $('#client_action').attr('disabled','disabled');
  //   var form_data = $(this).serialize();
  //   $.ajax({
  //     url:"clients/client_action.php",
  //     method:"POST",
  //     data:form_data,
  //     success:function(data)
  //     {
  //       $('#client_form')[0].reset();
  //       $('#client_Modal').modal('hide');
  //       $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
  //       $('#client_action').attr('disabled', false);
  //       clientdataTable.ajax.reload();
  //     }
  //   })
  // });
    

     $(document).on('click', '.update', function(){
        var client_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        //console.log(client_id)
            $.ajax({
            url:"clients/client_action.php",
            method:"POST",
            data:{client_id:client_id, btn_action:btn_action},
            dataType:"json",
            success:function(data)
            {
               console.log(client_id);

               $('#client_Modal').modal('show');
               
            }
        })
  });



     $(document).on('click', '.no', function(){
        var client_id = $(this).attr("id");
        var btn_action = 'fetch_single';
            $('#editclient').modal('show')
            $.ajax({
            url:"clients/client_action.php",
            method:"POST",
            data:{client_id:client_id, btn_action:btn_action},
            dataType:"json",
            success:function(data)
            {
           
          //console.log(data.photo);
          console.log(data.city);
          console.log(data.notes);
           console.log(data.client_id);

                $('#editclient').modal('show');
                $('#client_name1').val(data.client_name);
                $('#city1').val(data.city);
                $('#address1').val(data.address1);
                $('#address2').val(data.address2);
                $('#country1').val(data.country);
                $('#tin1').val(data.tin_no);
                $('#due_days').val(data.due_days);
                $('#due_type').val(data.due_type);
                $('#max_credit').val(data.max_credit);
                $('#vrn1').val(data.vrn);
                $('#post_code').val(data.post_code);
                $('#oldimage').val(data.photo);
                $('#client_idd').val(data.client_id);
                $('#client_notes').val(data.notes);
                $('#client_idd').val(data.client_id);
               
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Supplier");
                $('#client_id').val(client_id);
                $('#action_client').val('Edit');
                $('#btn_action').val('Edit');
                 clientdataTable.ajax.reload();
         
            }
        })
    
  });

// PREVIEW IMAGE

function getImagePreview(event)
{
    console.log(event.target.files[0]);
    //var image=URL.createObjectURL(event.target.files[0]);
    // var imagediv=document.getElementById('preview1');
    // var newimg=document.createElement('img');
    // imagediv.innerHTML='';
    // newimg.src=image;
    // newimg.width="300";
    
}


  // $(document).on('click','.delete', function(){
  //   var brand_id = $(this).attr("id");
  //   var status  = $(this).data('status');
  //   var btn_action = 'delete';
  //   if(confirm("Are you sure you want to change status?"))
  //   {
  //     $.ajax({
  //       url:"brand_action.php",
  //       method:"POST",
  //       data:{brand_id:brand_id, status:status, btn_action:btn_action},
  //       success:function(data)
  //       {
  //         $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
  //         branddataTable.ajax.reload();
  //       }
  //     })
  //   }
  //   else
  //   {
  //     return false;
  //   }
  // });


  var clientdataTable = $('#client_data').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"clients/client_fetch.php",
      type:"POST"
    },
    "columnDefs":[
      {
        "targets":[8, 9, 10],
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





