<?php
include('../config/function.php');
if($_SERVER['REQUEST_METHOD']=='GET')
{
  $cid = $_GET['cid']; 

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
              <li class="breadcrumb-item active">Tax List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="container">
    <!--alert start-->
    <?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <!--alert end-->
    <!--<span id="alert_action"></span>-->
      <div class="row">
        <div class="col-md-12">
             <div class="row">
                  <div class="col-md-8">
                      <div class="card">
                         <div class="card-header">
                          <h3 class="card-title">Invoice Part</h3>
                          <button type="button" name="add" id="add_order" class="btn btn-success btn-xs float-right">Add</button> 
                         </div>
                         <div class="card-body">
                              <!--product area start-->
                                    <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" id="productArea">
                <div class="table-responsive">
                  <table class="table m-0" id="product_table">
                    <thead>
                    <tr>
                      <th>Quantity</th>
                      <th>Item Name</th>
                      <th>Price</th>
                      <th>Total</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
<?php                   
$query = "SELECT * FROM temp_trans
  INNER JOIN product ON product.product_id = temp_trans.product_id WHERE temp_trans.branch_id = 1

";

  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $grand=0;
  foreach($result as $row)
    
  {
         
        $id=$row['temp_trans_id'];
        $total= $row['qty']*$row['price'];
        $grand=$grand+$total;

    
?>
   
                    <tr>
                      <td><?= $row['qty']?></td>
                      <td><span class="badge badge-success"><?php echo $row['product_name'];?></span></td>
                      <td><span class="badge badge-warning"><?php echo number_format($row['price'],2);?></span></td>
                      <td><span class="badge badge-info"><?php echo number_format($total,2);?></span></td>
                      <td>
                      <a href="#updateordinance<?php echo $row['temp_trans_id'];?>" data-target="#updateordinance<?php echo $row['temp_trans_id'];?>" data-qty="<?php echo $row['qty']; ?>" data-toggle="modal" class="btn btn-primary btn-xs"><i  class="fas fa-edit"></i></a>

                      <a href="#delete<?php echo $row['temp_trans_id'];?>" data-target="#delete<?php echo $row['temp_trans_id'];?>" data-toggle="modal"  class="btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    <!----Modal to update qty start---> 
                    <div id="updateordinance<?php echo $row['temp_trans_id'];?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content" style="height:auto;">
                              <!-- Modal Header -->
                              <div class="modal-header bg-primary">
                                  <h4 class="modal-title">Update Sales Details</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>

                              <!-- Modal Body -->
                              <div class="modal-body">
                                  <form class="form-horizontal" method="post" action="sales/transaction_update.php" enctype="multipart/form-data">
                                      <!-- Hidden Input for CID -->
                                      <input type="hidden" class="form-control" name="cid" value="<?php echo $cid; ?>" required>
                                      
                                      <!-- Hidden Input for Temp Trans ID -->
                                      <input type="hidden" class="form-control" id="price" name="id" value="<?php echo $row['temp_trans_id']; ?>" required>

                                      <!-- Qty Input -->
                                      <div class="form-group row">
                                          <label class="control-label col-lg-3" for="price">Qty</label>
                                          <div class="col-lg-9">
                                              <input type="text" class="form-control" id="price" name="qty" value="<?php echo $row['qty']; ?>" required>
                                          </div>
                                      </div>

                                      <!-- Modal Footer -->
                                      <div class="modal-footer">
                                          <button type="submit" class="btn btn-primary">Save changes</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
                    <!----Modal to update qty end--->

                    <!----Modal to delete start---> 
                    <div id="delete<?php echo $row['temp_trans_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $row['temp_trans_id']; ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <!-- Modal Header -->
                          <div class="modal-header bg-primary">
                            <h4 class="modal-title" id="deleteModalLabel<?php echo $row['temp_trans_id']; ?>">Delete Item</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <!-- Modal Body -->
                          <div class="modal-body">
                            <form class="form-horizontal" method="post" action="sales/transaction_del.php" enctype="multipart/form-data">
                              <!-- Hidden Fields -->
                              <input type="hidden" class="form-control" name="cid" value="<?php echo $cid; ?>" required>
                              <input type="hidden" class="form-control" name="id" value="<?php echo $row['temp_trans_id']; ?>" required>

                              <!-- Confirmation Message -->
                              <p>Are you sure you want to remove <strong><?php echo $row['product_name']; ?></strong>?</p>
                          </div>

                          <!-- Modal Footer -->
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Delete</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                            </form>
                        </div>
                      </div>
                    </div>
                    <!----Modal to delete end--->
                   
                    </tbody>
<?php } ?>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
                              <!--product area end-->
                         </div>
                      </div>
                  </div><!--end of col-md-8-->
                  <div class="col-md-4">
                     <!----total summary area start----> 
                       <div class="card" id="invoice_summury_area">
                         <div class="card-header">
                          <h3 class="card-title">Invoice Summury</h3>
                         </div>
                         <div class="card-body" id="invoice_form_content">
                           <!---summary form start---> 
                           <form method="post" name="autoSumForm" action="sales/sales_add.php">
                            <div class="row">
                              <div class="col-md-12">
                                <!-- Total -->
                                <div class="form-group">
                                  <label for="total">Total</label>
                                  <input
                                    type="text"
                                    class="form-control text-right"
                                    id="total"
                                    name="total"
                                    placeholder="Total"
                                    value="<?php echo $grand; ?>"
                                    onFocus="startCalc();"
                                    onBlur="stopCalc();"
                                    tabindex="5"
                                    readonly
                                    required
                                  />
                                </div>
                                <!-- Discount -->
                                <div class="form-group">
                                  <label for="discount">Discount</label>
                                  <input
                                    type="text"
                                    class="form-control text-right"
                                    id="discount"
                                    name="discount"
                                    value="0"
                                    tabindex="6"
                                    placeholder="Discount (Php)"
                                    onFocus="startCalc();"
                                    onBlur="stopCalc();"
                                    required
                                  />
                                  <input
                                    type="hidden"
                                    class="form-control"
                                    id="cid"
                                    name="cid"
                                    value="<?php echo $cid; ?>"
                                  />
                                </div>
                                <!-- Amount Due -->
                                <div class="form-group">
                                  <label for="amount_due">Amount Due</label>
                                  <input
                                    type="text"
                                    class="form-control text-right"
                                    id="amount_due"
                                    name="amount_due"
                                    placeholder="Amount Due"
                                    value="<?php echo $grand; ?>"
                                    readonly
                                    required
                                  />
                                </div>
                                <!-- Buttons -->
                                <button
                                  class="btn btn-lg btn-block btn-primary"
                                  id="daterange_btn"
                                  name="cash"
                                  type="submit"
                                  tabindex="7"
                                >
                                  Complete Sales
                                </button>
                                <button
                                  class="btn btn-lg btn-block btn-secondary"
                                  id="daterange-btn"
                                  type="reset"
                                  tabindex="8"
                                >
                                  <a href="cancel_sales.php" style="text-decoration: none; color: inherit;">Cancel Sale</a>
                                </button>
                              </div>
                            </div>
                          </form>
                           <!---summary form end--->
                         </div>
                       </div>
                     <!----total summary area end---->
                  </div><!--end of col-md-4-->

             </div><!--end of row-->
 
        </div><!-- end of col-md-12-->
        
      </div>
      
    </div>




  </div>


<div id="orderModal" class="modal fade">
  
<div class="modal-dialog modal-lg">
  <form method="post" id="order_form">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        
      <h4 class="modal-title"><i class="fa fa-plus"></i> Create Order</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      <input type="hidden" id="customer_id" name="customer_id">
      <div class="form-group">
        <label>Enter Product Details</label>
        <hr />
        <span id="span_product_details"></span>
        <hr />
      </div>
     
      </div>
      <div class="modal-footer">
        <input type="hidden" name="inventory_order_id" id="inventory_order_id" />
        <input type="hidden" name="btn_action" id="btn_action" />
        <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
      </div>
    </div>
  </form>
</div>

</div>


<?php   } ?>


<?php

include('includes/footer.php');
?>

<script type="text/javascript">
    $(document).ready(function(){


    	var orderdataTable = $('#order_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"order_fetch.php",
				type:"POST"
			},
			<?php
			if($_SESSION["type"] == 'master')
			{
			?>
			"columnDefs":[
				{
					"targets":[4, 5, 6, 7, 8, 9],
					"orderable":false,
				},
			],
			<?php
			}
			else
			{
			?>
			"columnDefs":[
				{
					"targets":[4, 5, 6, 7, 8],
					"orderable":false,
				},
			],
			<?php
			}
			?>
			"pageLength": 10
		});

		$('#add_order').click(function(){
      
			$('#orderModal').modal('show');
			$('#order_form')[0].reset();
      // Get the full URL
      var url = window.location.href;

      // Create a URL object to parse the query parameters
      var urlParams = new URLSearchParams(window.location.search);

      // Fetch the value of 'cid'
      var cid = urlParams.get('cid');
      //if (cid) {
        document.getElementById('customer_id').value = cid; // Set value in input
   
			$('.modal-title').html("<i class='fa fa-plus'></i> Create Order");
			$('#action').val('Add');
			$('#btn_action').val('Add');
			$('#span_product_details').html('');
			add_product_row();
		});

    function add_product_row(count = '') {
    $.ajax({
        url: "fetch_products.php",
        method: "POST",
        success: function(data) {
            var html = '';
            html += '<span id="row' + count + '"><div class="row">';
            html += '<div class="col-md-8">';
            html += '<select name="product_id[]" id="product_id' + count + '" class="form-control selectpicker" data-live-search="true" required>';
            html += data;
            html += '</select>';
            html += '<input type="hidden" name="hidden_product_id[]" id="hidden_product_id' + count + '" />';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<input type="text" name="quantity[]" class="form-control" required />';
            html += '</div>';
            html += '<div class="col-md-1">';
            if (count == '') {
                html += '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
            } else {
                html += '<button type="button" name="remove" id="' + count + '" class="btn btn-danger btn-xs remove">-</button>';
            }
            html += '</div></div></div><br /></span>';
            $('#span_product_details').append(html);

            //$('.selectpicker').selectpicker();
            $('.selectpicker').select2({
      theme: 'bootstrap4'
    });
        }
    });
}
		var count = 0;

		$(document).on('click', '#add_more', function(){
			count = count + 1;
			add_product_row(count);
		});
		$(document).on('click', '.remove', function(){
			var row_no = $(this).attr("id");
			$('#row'+row_no).remove();
		});

		$(document).on('submit', '#order_form', function(event){
			event.preventDefault();
			$('#action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"sales/addProductModal.php",
				method:"POST",
				data:form_data,
				success:function(data){
					$('#order_form')[0].reset();
					$('#orderModal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
					$('#action').attr('disabled', false);
          $('#product_table').html(data);
         // $('#productArea').load(' #product_table');
         // $('#invoice_summary_area').load(' #invoice_form_content');
         window.location.reload();
         
				}
			});
		});

	

    });
</script>



