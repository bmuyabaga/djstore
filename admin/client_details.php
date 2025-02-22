<?php

if($_SERVER['REQUEST_METHOD']=='GET')
{
 
  include('../config/function.php');

if(!isset($_SESSION["type"]))
{
  header('location:../login.php');
}






include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');



//$last_id1 = $_GET['view']; 
// SQL query with a placeholder
 

// Get the customer_id from the URL parameter
$customer_id = $_GET['view'];

if ($customer_id) {
    $customer_sql = "SELECT * FROM client 
   
    WHERE client.client_id = '".$customer_id."' AND client.client_status = 'active' ";
    $stmt = $connect->prepare($customer_sql);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        $customer_name = $customer['client_name'];
        $city = $customer['city'];
        $address1 = $customer['address1'];
        $country = $customer['country'];
       
    }

    $customer_sql = "SELECT * FROM credit_settings 
    
    WHERE client_id = '".$customer_id."' AND credit_status = 'Enable' ";
    $stmt = $connect->prepare($customer_sql);
    $stmt->execute();
    $count = $stmt->rowCount();
    $payterms = '';
    if ($count > 0) {
        $credit = $stmt->fetch(PDO::FETCH_ASSOC);
        $max_credit = $credit['max_credit'];
        $payterms = $credit['payterms'];
        $days = $credit['days'];
    }
    else
    {
      
      $max_credit = 0;
      $payterms = '<span style="color:red;">Not Set</span>';
      $days = '';
    }

    //fetch due amount
    $customer_sql = "SELECT sum(balance) as total_amount_due FROM sales
    
    WHERE client_id = '".$customer_id."' AND status = 'active' ";
    $stmt = $connect->prepare($customer_sql);
    $stmt->execute();
    $count = $stmt->rowCount();
    $payterms = '';
    if ($count > 0) {
        $due = $stmt->fetch(PDO::FETCH_ASSOC);
        $due_amount = $due['total_amount_due'];
        
    }
    else
    {
      
      $due_amount = 0;
      
    }

}

   //Fetching first invoice and last invoice dates
$first_invoice_sql = "SELECT sales_id, grandtotal, date FROM sales WHERE client_id = '".$customer_id."' ORDER BY date ASC LIMIT 1";
$first_invoice_stmt = $connect->prepare($first_invoice_sql);
$first_invoice_stmt->execute();
$count = $first_invoice_stmt->rowCount();
$first_invoice_date = '';
if ($count > 0) {
    $first_invoice = $first_invoice_stmt->fetch(PDO::FETCH_ASSOC);
    $first_invoice_date = isset($first_invoice['date']) ? $first_invoice['date'] : 'N/A';
    $first_invoice_total = isset($first_invoice['grandtotal']) ? $first_invoice['grandtotal'] : 'N/A';
    $first_invoice_id = isset($first_invoice['sales_id']) ? $first_invoice['sales_id'] : 'N/A';
}


// Query for last invoice
$last_invoice_sql = "SELECT sales_id, grandtotal, date FROM sales WHERE client_id = '".$customer_id."' ORDER BY date DESC LIMIT 1";
$last_invoice_stmt = $connect->prepare($last_invoice_sql);
$last_invoice_stmt->execute();
$count = $last_invoice_stmt->rowCount();
$last_invoice_date = '';
if ($count > 0) {
    $last_invoice = $last_invoice_stmt->fetch(PDO::FETCH_ASSOC);
    $last_invoice_date = isset($last_invoice['date']) ? $last_invoice['date'] : 'N/A';
    $last_invoice_total = isset($last_invoice['grandtotal']) ? $last_invoice['grandtotal'] : 'N/A';
    $last_invoice_id = isset($last_invoice['sales_id']) ? $last_invoice['sales_id'] : 'N/A';
}



   
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Custmer Account</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!--top customer name details start-->
            <div align="center" style="font-family: 'Arial', sans-serif; color: #353D50;">
                <h1 style="border-bottom: 2px solid #353D50; text-transform: capitalize; padding: 10px 0; margin: 0;">
                    <a href="#" style="text-decoration: none; color: #353D50;">
                       <span id="customer_name"><?= $customer_name ?></span>
                    </a>
                      <p style="margin: 10px 0; font-size: 16px; font-weight: bold;">
                    First Invoice Date: <span style="color: #5A6576;"><?= $first_invoice_date  ?></span> 
                    <span style="margin: 0 10px; font-weight: normal; color: #353D50;">||</span> 
                    Last Invoice Date: <span style="color: #5A6576;"><?= $last_invoice_date ?></span>
                </p>
                </h1>

            </div>

        <!--top customer name details end-->
        <!--custom navbar start--> 
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Tabs Custom Content Examples
            </h3>
          </div>
          <div class="card-body">
            <h4>Custom Content Below</h4>
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Overview</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Contacts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#custom-content-below-messages" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">Reports</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#custom-content-below-settings" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Custom Price</a>
              </li>
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
              <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
              <br>
              <!--OVERVIEW AREA START--> 
                <div class="container">
                  <!--row start-->
                   <div class="row">
                     <div class="col-md-4">
                        <div class="card">
                           <div class="card-header">
                              <h3 class="card-title">Overview</h3>
                           </div>
                           <div class="card-body" id="creditarea">
                             <div class="creditContent" id="creditContent">
                              <p>Billing Currency: <span style="color: #5A6576;">TZS</span></p>
                              <p>Pay Terms: <span style="color: #5A6576;"><?= $days ?> <?= $payterms ?></span></p>
                              <p>Credit Limit: <span style="color: #5A6576;"><b><?= number_format($max_credit) ?> TZS</b></span></p>
                              <p>Amount Due: <span style="color: #5A6576;"><?= number_format($due_amount) ?></span></p>
                              <p>Credit Available: <span style="color: #5A6576;"><?= number_format($max_credit-$due_amount) ?></span></p>
                           </div>
                          </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="card">
                          <div class="card-header">
                             <h3 class="card-title">Payterms</h3>
                          </div>
                          <div class="card-body">
                          <p>Payterm: <span style="color: #5A6576;">30 Days</span></p>
                             <p>Payment Method: <span style="color: #5A6576;">Bank Transfer</span></p>
                             <p>Payment Status: <span style="color: #5A6576;">Paid</span></p>
                             <p>Payment Date: <span style="color: #5A6576;">12/12/2020</span></p>
                          </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                       <div class="card">
                         <div class="card-header">
                            <h3 class="card-title">Address</h3>
                         </div>
                         <div class="card-body">
                           <table class="table table-bordered table-striped">
                               <tr>
                                <th>Type</th>
                                <td>Hotel</td>
                               </tr>
                               <tr>
                                <th>Country</th>
                                <td><?= $country ?></td>
                               </tr>
                               <tr>
                                <th>Area</th>
                                <td><?= $address1 ?> <a href="customer_location.php"><i class="fas fa-map-marker-alt"></i></a></td>
                               </tr>
                           </table>
                         </div>
                       </div>
                     </div>
                   </div>
                   <!--row end-->
                </div>
              <!--OVERVIEW AREA END-->
              <hr style="background:red;">
              <h3>
              <a href="new_invoice.php?cid=<?= $customer_id ?>" class="btn btn-danger btn-sm mr-2">Create Invoice</a>
              <button type="button" name="add" id="add_credit" data-toggle="modal" data-target="#creditModal" class="btn btn-warning btn-sm mr-2">Set Pay Terms</button>
              <button type="button" name="add" id="add_custom" data-toggle="modal" data-target="#customModal" class="btn btn-info btn-sm mr-2">Custom Price</button>
              </h3>
              <hr style="background:red;">
            </div>
              <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                 <br>
              <!--CONTACT AREA START--> 
                 
                    <div class="container">
                    <span id="alert_action"></span>
                      <div class="row">
                        <div class="col-md-12">


                            <div class="card">
                              <div class="card-header">
                                <h3 class="card-title">Contact List</h3>
                              
                                <button type="button" name="add" id="add_contacts" data-toggle="modal" data-target="#contactsModal" class="btn btn-success btn-xs btn-xs float-right">Add</button>  
                              </div>
                              <!-- /.card-header -->
                            <div class="card-body">
                              <table id="contact_table" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                  <th>TITLE</th>
                                  <th>NAME</th>
                                  <th>EMAIL</th>
                                  <th>PHONE</th>
                                  <th>DESIGNATION</th>
                                  <th>Status</th>
                                  <th>EDIT</th>
                                  <th>DELETE</th>
                                </tr>
                              </thead>
                              </table>
                            </div>
                          </div>
                          
                          
                        </div>
                        
                      </div>
                      
                    </div>
                  <!--CONTACT AREA END-->
            </div>
              <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                 Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
              </div>
              <div class="tab-pane fade" id="custom-content-below-settings" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                 Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
              </div>
            </div>
          
            <!--OUTTER BOX START--> 
              <div class="row">
                <div class="col-md-4">
                    <div class="card">
                       <div class="card-header">
                          <h3 class="card-title">Brand Purcahsed</h3>
                       </div>
                       <div class="card-header">
                         <h3>
                          <span><a href="" class="btn btn-secondary">Statemant</a></span>
                          <span><a href="" class="btn btn-secondary">Price List</a></span>
                          <span><a href="" class="btn btn-secondary">Ranking</a></span>
                         </h3>
                         <br>
                         <h6>Purchased Brand (last 12 month)</h6>
                         <h3>
                          <span><a href="" class="btn btn-default">Coffee</a></span>
                          <span><a href="" class="btn btn-default">Tea</a></span>
                         </h3>
                       </div>
                    </div>
                </div>
                <div class="col-md-8">
                  <div class="card">
                     <div class="card-header">
                        <h3 class="card-title">Pending</h3>
                     </div>
                     <div class="card-body">
                            <table class="table table-bordered table-striped">
                              <h3 class="float-right">
                                <span><a href="" class="btn btn-secondary">New Invoice</a></span>
                              </h3>
                               <tbody>
                               <tr>
                                  <td>4</td>
                                  <td>Coffee Powder</td>
                                </tr>
                                <tr>
                                   <td>2</td>
                                   <td>Tomato ketchup</td>
                                </tr>
                               </tbody>
                              
                            </table>
                     </div>
                  </div>
                </div>
              </div>
            <!--OUTTER BOX END-->
             <!--PAYMENTS AND INVOICES AREA START--> 
             <div class="row">
                 <div class="col-md-6">
                    <div class="card">
                       <div class="card-header">
                         <h3 class="card-title">Last 3 Invoices</h3>
                       </div>
                       <div class="card-body">
                         <table class="table table-bordered table-striped">
                           <tr>
                            <th>Nr</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                           </tr>
                           <tbody>
                            <?php 
                             //Last 3 invoices
                             $lastThreeInvoice = "SELECT * FROM sales WHERE client_id = '".$customer_id."' ORDER BY sales_id DESC LIMIT 3";
                             $statement = $connect->prepare($lastThreeInvoice);
                             $statement->execute();
                             $result = $statement->fetchAll();
                             foreach($result as $row)
                             {
                              echo '
                              <tr>
                                <td>'.$row['invoice_number'].'</td>
                                <td>'.$row['date'].'</td>
                                <td>'.$row['payment_type'].'</td>
                                <td>TZS '.number_format($row['grandtotal']).'</td>
                              </tr>
                              ';
                             }
                            ?>
                           
                           </tbody>
                         </table>
                       </div>
                    </div>
                 </div>
                 <div class="col-md-6">
                    <div class="card">
                       <div class="card-header">
                         <h3 class="card-title">Last 3 Payments</h3>
                       </div>
                       <div class="card-body">
                           <table class="table table-bordered table-striped">
                       
                            <tr>
                              <th>ID</th>
                              <th>Invoice</th>
                              <th>Date</th>
                              <th>Method</th>
                              <th>Total</th>
                            </tr>
                            <tbody>
                            <?php
                            //Last 3 payments
                            $lastThreePayments = "SELECT * FROM payments WHERE client_id = '".$customer_id."' ORDER BY payment_id DESC LIMIT 3";
                            $statement = $connect->prepare($lastThreePayments);
                            $statement->execute();
                            $row_count = $statement->rowCount();
                            if($row_count > 0)
                            {
                              $result = $statement->fetchAll();
                              foreach($result as $row)
                              {
                                echo '
                                <tr>
                                  <td>'.$row['payment_id'].'</td>
                                  <td>'.$row['sales_id'].'</td>
                                  <td>'.$row['payment_date'].'</td>
                                  <td>'.$row['payment_method'].'</td>
                                  <td>TZS '.number_format($row['paid']).'</td>
                                </tr>
                                ';
                              }
                            }
                            else
                            {
                              echo '<tr><td colspan="5">No Payments Found</td></tr>';
                            }
                            ?>
                  
                            </tbody>
                           </table>
                       </div>
                    </div>
                 </div>
               </div>
              <!--PAYMENTS AND INVOICES AREA END-->
          
          </div>
          <!-- /.card -->
        </div>
        <!-- /.card -->
        <!--custom navbar end-->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





      <!--modal Set custom price-->
              <div id="customModal" class="modal fade">

      <div class="modal-dialog">
        <form method="post" id="order_form" method="post" action="customPrice/custom_price_add.php" name="autoSumForm">
          <div class="modal-content">
            <div class="modal-header bg-info" >
             
            <h4 class="modal-title" style="color: white;">Add Custom Price</h4>
             <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
            </div>
            <div class="modal-body">
              <p id="message" class="text-dark"></p>

            <div class="form-group">
            <label>Product</label>
           <select class="form-control select2custom" style="width: 100%;" name="product_codecustom" id="product_codecustom" tabindex="1" autofocus required>
  <?php
  $productID = '';
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
   
  $productID = $row['product_id'];

  ?>

   
                     <option value="<?php echo $row['product_code'];?>"><?php echo $row['product_name']." Available(".$row['product_quantity'].") Code(".$row['product_code'].")";?></option>

                  <?php }?>
                </select>
                

            </div>
           
          
            
            <div class="form-group">
              <label>Price</label>
              <input type="number" name="pricecustom" id="pricecustom" class="form-control" value="" required/>
              <input type="hidden" name="clientid_custom" id="clientid_custom" class="form-control" value="<?php echo $last_id1;?>" />
              <input type="hidden" name="product_idcustom" id="product_idcustom" class="form-control" value="<?php echo $productID;?>" />

              
            </div>
            <div class="form-group">
              <label>Notes</label>
              <textarea type="text" name="paymentNotescustom" id="paymentNotescustom" class="form-control"  ></textarea>
            </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="salesID" id="salesID" />
              <input type="hidden" name="clientID" id="clientID" />
              <input type="hidden" name="btn_action1" id="btn_action1" />
              <!--<input type="submit" name="action" id="action" class="btn btn-info" value="" />-->
              
             
                     <button type="submit" name="addcustom" id="addcustom" class="btn btn-info">Add</button>
            </div>
          </div>
        </form>
      </div>

    </div>
    

<!--Modal ya Contacts-->

<div id="contactsModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="contacts_form">
          <div class="modal-content">
            <div class="modal-header bg-info">
                 <h4 class="modal-title"><i class="fa fa-plus"></i> Add Contact</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
           
            </div>
            <div class="modal-body">
              <div class="row">
                 <div class="col-md-6">
                      <div class="form-group">
                          <label>Select Title</label>
                          <select name="title" id="title" class="form-control">
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Miss">Miss</option>
                            <option value="Dr">Dr</option>
                            <option value="Prof">Prof</option>
                          </select>
                      </div>
                 </div>
                 <div class="col-md-6">
                        <div class="form-group">
                          <label>Enter Contact Name</label>
                          <input type="text" name="contacts_name" id="contacts_name" class="form-control" required />
                          <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>" >
                        </div>
                 </div>
              </div>
              
          
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label>Enter Contact Number</label>
                  <input type="text" name="contacts_number" id="contacts_number" class="form-control" required />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label>Enter Contact Number2</label>
                  <input type="text" name="contacts_number2" id="contacts_number2" class="form-control" placeholder="Optional" />
                </div>

            </div>
          </div>
        
           <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Enter Contact Email</label>
                  <input type="email" name="contacts_email" id="contacts_email" class="form-control" required />
                  
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Enter Contact Email2</label>
                    <input type="email" name="contacts_email2" id="contacts_email2" class="form-control" placeholder="Optional"  />
                  </div>
              </div>
           </div>
          
           
            <div class="form-group">
                  <label>Select Contact Position</label>
                  <select name="contacts_position" id="contacts_position" class="form-control">
                    <?php echo fill_position_list($connect); ?>
                  </select>
            </div>
            <div class="form-group">
                  <label>Enter Notes</label>
                  <textarea name="contacts_notes" id="contacts_notes" class="form-control" rows="3" placeholder="Optional"></textarea>
            </div>
          </div>
            <div class="modal-footer">
              <input type="hidden" name="contact_id" id="contact_id" />
              <input type="hidden" name="btn_action" id="btn_action"/>
              <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!--set credit terms modal start--> 
    <div id="creditModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="credit_form">
          <div class="modal-content">
            <div class="modal-header bg-info">
                 <h4 class="modal-title"><i class="fa fa-plus"></i> Add Payterms</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
           
            </div>
            <div class="modal-body">
                   <div class="form-group">
                        <label>Enter Maximum Credit (TZS)</label>
                        <input type="number" name="max_credit" id="max_credit" class="form-control" required />
                        <input type="hidden" id="cid" name="cid" value="<?php echo $customer_id; ?>" >
                      </div>

                      <div class="form-group">
                        <label>Days</label>
                        <input type="number" name="days" id="days" class="form-control" required />
                        
                      </div>

                      <div class="form-group">
                          <label>Select Payterms</label>
                          <select name="payterms" id="payterms" class="form-control" required>
                            <option value="invoice_date">Invoice Date</option>
                            <option value="prepay">Prepay</option>
                            <option value="eom">EOM</option>
                          </select>
                      </div>
                     
  
                      </div>
                        <div class="modal-footer">
                          <input type="hidden" name="credit_id" id="credit_id" />
                          <input type="hidden" name="btn_action_credit" id="btn_action_credit"/>
                          <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

    <!--set credit terms modal end-->


<script>

$(document).ready(function(){
 

  $('#add_contacts').click(function(){
    $('#contacts_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Add Contact");
    $('#action').val('Add');
    $('#btn_action').val('Add');
  });
  
  $(document).on('submit','#contacts_form', function(event){
    event.preventDefault();
    $('#action').attr('disabled','disabled');
    var form_data = $(this).serialize();
    $.ajax({
      url:"contact/contact_action.php",
      method:"POST",
      data:form_data,
      success:function(data)
      {
        $('#contacts_form')[0].reset();
        $('#contactsModal').modal('hide');
        $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
        $('#action').attr('disabled', false);
        contactdataTable.ajax.reload();
      }
    })
  });

  $(document).on('click', '.update_contact', function () {
    // Get the contact ID from the button
    var contact_id = $(this).attr("id");
    var btn_action = 'fetch_single';

    // Make the AJAX call
    $.ajax({
        url: "contact/contact_action.php", // Your PHP handler URL
        method: "POST", // Request type
        data: { contact_id: contact_id, btn_action: btn_action }, // Data sent to PHP
        dataType: "json", // Expect JSON response
        success: function (data) {
            if (data) {
                // Populate modal with fetched data
                $('#contactsModal').modal('show');
                $('#title').val(data.title);
                $('#contacts_name').val(data.contacts_name);
                $('#contacts_number').val(data.contacts_number);
                $('#contacts_number2').val(data.contacts_number2);
                $('#contacts_email').val(data.contacts_email);
                $('#contacts_email2').val(data.contacts_email2);
                $('#contacts_position').val(data.contacts_position);
                $('#contacts_notes').val(data.contacts_notes);

                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Contact");
                $('#contact_id').val(contact_id); // Set contact ID
                $('#action').val('Edit'); // Set action value
                $('#btn_action').val("Edit"); // Set button action
            } else {
                alert("Failed to fetch contact details.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error); // Log any AJAX error
            alert("Something went wrong. Check the console for details.");
        },
    });
});

//SETTING PAY TERMS
$('#add_credit').click(function(){
    $('#credit_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Add Payterms");
    $('#action').val('Add');
    $('#btn_action_credit').val('Add');
  });

  $(document).on('submit','#credit_form', function(event){
    event.preventDefault();
    $('#action').attr('disabled','disabled');
    var form_data = $(this).serialize();
    $.ajax({
      url:"payterms/payterms_action.php",
      method:"POST",
      data:form_data,
      success:function(data)
      {
        $('#credit_form')[0].reset();
        $('#creditModal').modal('hide');
        $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
        $('#action').attr('disabled', false);
        // Update part of the div with the response
        $('#creditarea').load(' #creditContent');
        
      }
    })
  });

  // Fetching from URL
  const urlParams = new URLSearchParams(window.location.search);
    const customerId = urlParams.get('view'); // Get 'customer_id' from URL 
  

  var contactdataTable = $('#contact_table').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"contact/contact_fetch.php",
      type:"POST",
      data:{customer_id:customerId}
    },
    "columnDefs":[
      {
        "targets":[6,7],
        "orderable":false,
      },
    ],
  })


});






  
</script>

<?php

include('includes/footer.php');
}
?>





