<?php
include('../config/function.php');

 if($_SERVER['REQUEST_METHOD']=='GET')
 {
//  $last_id = $_GET['view']; 




$cid = $_GET['vid']; 
$product_code = '';



include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');



?>
<div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              <a class="btn btn-lg btn-warning" href="home.php">Back</a>
              
            </h1>
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Product</li>
            </ol>
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
        <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Purchase Transaction</h3>
                </div>
                <div class="box-body">
                  <!-- Date range -->
                  <form method="post" action="purchase/purchase_transaction_add.php">
          <div class="row" style="min-height:400px">
          
           <div class="col-md-6">
              <div class="form-group">
              <label for="date">Product Name</label>
               
                <select class="form-control select2" style="width: 100%;" name="productId" tabindex="1" autofocus required>
                          <?php
                                                  $query = "
                          SELECT * FROM product 
                          
                          ORDER BY product_name ASC
                          ";
                          $statement = $connect->prepare($query);
                          $statement->execute();
                          $result = $statement->fetchAll();
                          $output = '';
                          foreach($result as $row)
                          {
                          


                          ?>


                     <option value="<?php echo $row['product_id'];?>"><?php echo $row['product_name']." SKU(".$row['product_code'].")";?></option>
                  <?php }?>
                </select>
                <input type="hidden" class="form-control" name="cid" value="<?php echo $cid;?>" required>   
              </div><!-- /.form group -->
          </div>
          <div class=" col-md-2">
            <div class="form-group">
              <label for="date">Quantity</label>
              <div class="input-group">

                <input type="number" class="form-control pull-right" id="Quantity" name="qty" placeholder="Quantity" tabindex="2" value="1"  required>
              </div><!-- /.input group -->
            </div><!-- /.form group -->
           </div>
          
           <div class=" col-md-2">
            <div class="form-group">
              <label for="date">Price</label>
              <div class="input-group">

                <input type="number" class="form-control pull-right" id="Price" name="price" placeholder="Price"  value="0.00"  required>
              </div><!-- /.input group -->
            </div><!-- /.form group -->
           </div>
      


          <div class="col-md-2">
            <div class="form-group">
              <label for="date"></label>
              <div class="input-group">
                <button class="btn btn-lg btn-primary" type="submit" tabindex="3" name="addtocart">+</button>
              </div>
            </div>  
          </form> 
          </div>
          <div class="col-md-12">
<?php 
// $queryb=mysqli_query($con,"select balance from customer where cust_id='$cid'")or die(mysqli_error());
//      $rowb=mysqli_fetch_array($queryb);
//         $balance=$rowb['balance'];

//         if ($balance>0) $disabled="disabled=true";else{$disabled="";}
?>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Qty</th>
                   
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
    
    // $query=mysqli_query($con,"select * from temp_trans natural join product where branch_id='$branch'")or die(mysqli_error());
    //   $grand=0;
    // while($row=mysqli_fetch_array($query)){
    //     $id=$row['temp_trans_id'];
    //     $total= $row['qty']*$row['price'];
    //     $grand=$grand+$total;

$query = "SELECT * FROM temp_purchase
  INNER JOIN product ON product.product_id = temp_purchase.product_id WHERE temp_purchase.branch_id = 1

";

$statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $grand=0;
  foreach($result as $row)
    
  {
         
        $id=$row['temp_purchase_id'];
        $total= $row['qty']*$row['price'];
        $grand=$grand+$total;

    
?>
                      <tr >
            <td><?php echo $row['qty'];?></td>
                        <td class="record"><?php echo $row['product_name'];?></td>
            <td><?php echo number_format($row['price'],2);?></td>
            <td><?php echo number_format($total,2);?></td>
                        <td>
              
              <a href="#updateordinance<?php echo $row['temp_trans_id'];?>" data-target="#updateordinance<?php echo $row['temp_purchase_id'];?>" data-toggle="modal" style="color:blue;" class="small-box-footer"><i  class="fas fa-edit"></i></a>

              <a href="#delete<?php echo $row['temp_trans_id'];?>" data-target="#delete<?php echo $row['temp_purchase_id'];?>" data-toggle="modal" style="color:red;" class="small-box-footer"><i class="far fa-trash-alt"></i></a>
              
            </td>
                      </tr>
            <div id="updateordinance<?php echo $row['temp_purchase_id'];?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content" style="height:auto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Update Sales Details</h4>
              </div>
              <div class="modal-body">
        <form class="form-horizontal" method="post" action="purchase/transaction_update.php" enctype='multipart/form-data'>
          <input type="hidden" class="form-control" name="cid" value="<?php echo $cid;?>" required>   
          <input type="hidden" class="form-control" id="price" name="id" value="<?php echo $row['temp_purchase_id'];?>" required>  
        <div class="form-group">
          <label class="control-label col-lg-3" for="price">Qty</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="price" name="qty" value="<?php echo $row['qty'];?>" required>  
          </div>
        </div>
        
              </div><br>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
        </form>
            </div>
      
        </div><!--end of modal-dialog-->
 </div>
 <!--end  modal-->  
<div id="delete<?php echo $row['temp_purchase_id'];?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content" style="height:auto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Delete Item</h4>
              </div>
              <div class="modal-body">
        <form class="form-horizontal" method="post" action="purchase/transaction_del.php" enctype='multipart/form-data'>
          <input type="hidden" class="form-control" name="cid" value="<?php echo $cid;?>" required>   
          <input type="hidden" class="form-control" id="price" name="id" value="<?php echo $row['temp_purchase_id'];?>" required>  
        <p>Are you sure you want to remove <?php echo $row['input_name'];?>?</p>
        
              </div><br>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
        </form>
            </div>
      
        </div><!--end of modal-dialog-->
 </div>
 <!--end of modal-->  
          <?php }?>   
                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->

        </div>  
               
                  
                  
        </form> 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col (right) -->
            
            <div class="col-md-3">
              <div class="box box-primary">
               
                <div class="box-body">
                  <!-- Date range -->
          <form method="post" name="autoSumForm" action="purchase/purchase_add.php">
          <div class="row">
           <div class="col-md-12">
              
              <div class="form-group">
              <label for="date">Total</label>
              
                <input type="text" style="text-align:right" class="form-control" id="total1" name="total" placeholder="Total" 
                value="<?php echo $grand;?>" onFocus="startCalc();" onBlur="stopCalc();"  tabindex="5" readonly>
              
              </div><!-- /.form group -->
              <div class="form-group">
              <label for="date">Discount</label>
              
                <input type="text" class="form-control text-right" id="discount" name="discount" value="0" tabindex="6" placeholder="Discount (Php)" onFocus="startCalc();" onBlur="stopCalc();">
              <input type="hidden" class="form-control text-right" id="cid" name="cid" value="<?php echo $cid;?>">
              </div><!-- /.form group -->
              <div class="form-group">
              <label for="date">Amount Due</label>
              
                <input type="text" style="text-align:right" class="form-control" id="amount_due1" name="amount_due" placeholder="Amount Due" value="<?php echo 
                $grand;?>" readonly>
              
              </div><!-- /.form group -->
              
             
         

           
          

        </div>  
               
                  
                 
                      <button class="btn btn-lg btn-block btn-primary" id="daterange_btn1" name="cash" type="submit"  tabindex="7">
                        Complete Sales
                      </button>
            <button class="btn btn-lg btn-block" id="daterange-btn" type="reset"  tabindex="8">
                        <a href="cancel_purchase.php">Cancel Sale</a>
                      </button>
              
        </form> 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col (right) -->
      
        
          </div><!-- /.row -->
    
            
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
     
    </div><!-- ./wrapper -->

<?php   } ?>





        <script>

$(document).ready(function(){

  sumFun();

 //Initialize Select2 Elements
    //$('.select2').select2()

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    });


    
  $('#fa_icon_table').DataTable();

  $('#payment_table').DataTable();


  $('#cash_table').DataTable();

  $('#purchase_table').DataTable();


  //     $(".btn_delete").click(function(){
  //     var element = $(this);
  //     var id = element.attr("id");
  //     var dataString = 'id=' + id;
  //     if(confirm("Sure you want to delete this item?"))
  //     {
  // $.ajax({
  // type: "GET",
  // url: "temp_trans_del.php",
  // data: dataString,
  // success: function(){
    
  //       }
   
function sumFun(){

  $(document).on('click','#daterange_btn1', function(){
     
      var total = $('#total1').val();
      var amount_due = $('#amount_due1').val();
      var qty = $('#Quantity');
    
      
   

    if(total ==0 || amount_due ==0 || qty == ''  )
    {

      
      alert('Fill all the blanks');
    }



  })

}




});

</script>

<?php

include('includes/footer.php');
?>





