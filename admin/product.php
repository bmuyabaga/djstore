<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
    header('location:../login.php');
}




include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');

// $products_query = "SELECT p.product_id, p.product_name, c.category_name, p.product_base_price, p.product_quantity AS total_Product_stock, pb.batch_number, pb.stock AS batch_quantity, pb.production_date, pb.expiry_date 
// FROM product p LEFT JOIN product_batches pb ON p.product_id = pb.product_id 
// LEFT JOIN category c ON p.category_id = c.category_id ORDER BY p.product_name ASC, pb.batch_number ASC";
// $products_statement = $connect->prepare($products_query);
// $products_statement->execute();
// $products_result = $products_statement->fetchAll(PDO::FETCH_ASSOC);


?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
     
         <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashibodi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Nyumbani</a></li>
              <li class="breadcrumb-item active">Orodha ya Bidhaa</li>
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
                <h3 class="card-title">Orodha ya Bidhaa</h3>
               
                <button type="button" name="add" id="add_product"  class="btn btn-primary btn-xs float-right">Ongeza</button>
              </div>
              <!-- /.card-header -->
            <div class="card-body">
                   <!--product table start--> 
                   <table id="productTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
                   <!--product table end-->
            </div>
          </div>
          
          
        </div>
        
      </div>
      
    </div>




  </div>



<!--Modal ya kuingiza new product-->
<div id="productModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="product_form">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Ongeza Bidhaa</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Chagua Kategori</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Chagua Kategori</option>
                                    <?php echo fill_category_list($connect);?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Chagua Brandi</label>
                                <select name="brand_id" id="brand_id" class="form-control" required>
                                    <option value="">Chagua Brandi</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ingiza Jina la Bidhaa</label>
                                <input type="text" name="product_name" id="product_name" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Ingiza Maelezo ya Bidhaa</label>
                                <textarea name="product_description" id="product_description" class="form-control" rows="5" required></textarea>
                            </div>
                          

                            <div class="form-group">
                                <label>Ingiza Kipimo cha Bidhaa</label>
                              
                                   
                                        <select name="product_unit" id="product_unit" class="form-control" required>
                                            <option value="">Select Unit</option>
                                            <option value="Bags">Bags</option>
                                            <option value="Bottles">Bottles</option>
                                            <option value="Box">Box</option>
                                            <option value="Dozens">Dozens</option>
                                            <option value="Feet">Feet</option>
                                            <option value="Gallon">Gallon</option>
                                            <option value="Grams">Grams</option>
                                            <option value="Inch">Inch</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Liters">Liters</option>
                                            <option value="Meter">Meter</option>
                                            <option value="Nos">Nos</option>
                                            <option value="Packet">Packet</option>
                                            <option value="Rolls">Rolls</option>
                                            <option value="virtue">Virtue</option>
                                        </select>
                             
                            </div> 

                              <div class="form-group">
                                <label>Ingiza Code ya Bidhaa</label>
                                <input type="text" name="product_code" id="product_code" class="form-control" required  />
                            </div>
                            <div class="form-group">
                                <label>Ingiza Bei ya Bidhaa</label>
                                <input type="text" name="product_base_price" id="product_base_price" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
                            <div class="form-group">
                                <label>Ingiza Kodi ya Bidhaa (%)</label>
                                <input type="text" name="product_tax" id="product_tax" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="product_id" id="product_id" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Funga</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="productdetailsModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="product_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Taarifa Za Bidhaa</h4>
                        </div>
                        <div class="modal-body">
                            <Div id="product_details"></Div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Funga</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<!--OPEN BOX-->

            <div id="openModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="nmb_form">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                         <h4 class="modal-title"><i class="fa fa-plus"></i> Add Transaction</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                       
                    </div>
                    <div class="modal-body">
                            <span id="message"></span>
                         
                                <div class="form-group">
                                    <label>Reason</label>
                                    <select type="text" name="transact" id="transact" class="form-control" required>
                                        <option value="">Please Select Reason</option>
                                        <option value="open">Open Single</option>
                                        <option value="return">Return Product</option>
                                       
                                    </select>
                           
                                 </div>
                                 <div class="form-group">
                                    <label>Add Qty</label>
                                    <input type="number" name="amount" id="amount" class="form-control" required />
                                </div>

                             

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="open_id" id="open_id"/>
                        <input type="hidden" name="btn_action" id="btn_action"/>
                        <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>





        <script>
$(document).ready(function(){
    var productTable = $('#productTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "product/product_fetch.php",
                "type": "POST"
            },
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "pageLength": 10
        });


    $('#add_product').click(function(){
        $('#productModal').modal('show');
        $('#product_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Product");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

    $('#category_id').change(function(){
        var category_id = $('#category_id').val();
        //alert(category_id);
        var btn_action = 'load_brand';
        $.ajax({
            url:"product/product_action.php",
            method:"POST",
            data:{category_id:category_id, btn_action:btn_action},
            success:function(data)
            {
                $('#brand_id').html(data);
            }
        });
    });

    $(document).on('submit', '#product_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"product/product_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#product_form')[0].reset();
                $('#productModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                productTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.view', function(){
        var product_id = $(this).attr("id");
        var btn_action = 'product_details';
        $.ajax({
            url:"product/product_action.php",
            method:"POST",
            data:{product_id:product_id, btn_action:btn_action},
            success:function(data){
                $('#productdetailsModal').modal('show');
                $('#product_details').html(data);
            }
        })
    });

    $(document).on('click', '.update', function(){
        var product_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"product/product_action.php",
            method:"POST",
            data:{product_id:product_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#productModal').modal('show');
                $('#category_id').val(data.category_id);
                $('#brand_id').html(data.brand_select_box);
                $('#brand_id').val(data.brand_id);
                $('#product_name').val(data.product_name);
                $('#product_description').val(data.product_description);
                $('#product_quantity').val(data.product_quantity);
                $('#product_unit').val(data.product_unit);
                $('#product_code').val(data.product_code);
                $('#product_base_price').val(data.product_base_price);
                $('#product_tax').val(data.product_tax);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Product");
                $('#product_id').val(product_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");

            }
        })
    });

 

    $(document).on('click', '.delete', function(){
        var product_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"product/product_action.php",
                method:"POST",
                data:{product_id:product_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    productTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
    });

});
</script>
<?php

include('includes/footer.php');
?>





