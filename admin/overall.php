<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
  header('location:login.php');
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
              <li class="breadcrumb-item active">Purchase List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<



<!-- page content -->
        <div class="right_col ml-3" role="main"> 
      <div class = "row">
        <div class = "col-md-12 col-lg-12 hide-section">
      <div class = "panel">
        <div class="panel-heading">
          <h3 class="box-title">Select Date</h3>
          <a class = "btn btn-success btn-print" href = "" onclick = "window.print()"><i class ="glyphicon glyphicon-print"></i> Print</a>
          <a class = "btn btn-primary btn-print" href = "home.php"><i class ="glyphicon glyphicon-arrow-left"></i> Back to Homepage</a>
        </div>
        <div class="box-body">
        
          <!-- /.form group -->
          <form method="post" >
          <div class="form-group col-md-6">
            <label></label>

            <div class="input-group">
              <div class="input-group-prepend">
                    <span class="input-group-text">  <i class="far fa-calendar-alt"></i></span>
                  </div>
            <select class="form-control select2" name="month" tabindex="1" autofocus required>
              <option value="1">January</option>
              <option value="2">February</option>
              <option value="3">March</option>
              <option value="4">April</option>
              <option value="5">May</option>
              <option value="6">June</option>
              <option value="7">July</option>
              <option value="8">August</option>
              <option value="9">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
                  
            </select>
          </div>
                <!-- /.input group -->
          </div>
          <div class="form-group col-md-5">
            <label></label>

            <div class="input-group">
             <div class="input-group-prepend">
                    <span class="input-group-text">  <i class="far fa-calendar-alt"></i></span>
                  </div>
            <select class="form-control select2" name="year" tabindex="1" required>
              <option>2017</option>
              <option>2018</option>
              <option>2019</option>
              <option>2020</option>
              <option>2021</option>
              <option>2022</option>
              <option>2023</option>
              <option>2024</option>
              <option>2025</option>
              <option>2026</option>
              <option>2027</option>
              <option>2028</option>
              <option>2029</option>
              <option>2030</option>




              
                  
            </select>
          </div>
                <!-- /.input group -->
          </div>
              <!-- /.form group --><br>
          <button type="submit" class="btn btn-primary" name="display">Display</button>
        </form>
        
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->  
        
        </div>      
      </div>
      
      
      <div class="row">
                
        
        <div class="col-md-12 col-sm-12 col-xs-12">         
          <div id="graph"></div>
          
                  
                 
            
                        <table id="example1" class="table table-bordered table-striped">
                        <tr>
                        <th>MONTH</th>
                        <th>BRANCH</th>
                        <th class="text-right">SALES</th>
                      </tr>
      
                    
                    <tbody>
<?php
  
  // if (isset($_POST['display'])){
  //     $year=$_POST['year'];
  //     $month=$_POST['month'];
  //     $_SESSION['year']=$year;
  //     $_SESSION['month']=$month;
      
  //     $query=mysqli_query($con,"select *,SUM(payment) as payment,DATE_FORMAT(payment_date,'%b') as month from payment natural join branch
  //     where YEAR(payment_date)='$year' and MONTH(payment_date)='$month' group by branch_id,MONTH(payment_date) order by  MONTH(payment_date)")or die(mysqli_error($con));
  //     $total=0;
      
  //     echo "<h2 style='text-align:center'><b>Monthly Sales</b></h2>";
  //     while($row=mysqli_fetch_array($query)){
  //       $total=$total+$row['payment'];  


if(isset($_POST['display']))
{
       $year=$_POST['year'];
       $month=$_POST['month'];
       $_SESSION['year']=$year;
       $_SESSION['month']=$month;

      $query = "
  SELECT sum(grandtotal) as totalsales,DATE_FORMAT(date,'%b') AS month FROM Sales
   
  WHERE YEAR(date) = ".$_POST['year']." AND MONTH(date)=".$_POST['month']." GROUP BY branch_id,MONTH(date) ORDER BY MONTH(date)
  ";

 
 
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $total=0;
  echo "<h2 style='text-align:center'><b>Monthly Sales</b></h2>";
  foreach($result as $row)
  {
    
  
$total=$total+$row['totalsales']; 

    
  

?>
            
      <tr>
                <th><?php echo $row['month']." ".$year;?></th>
        <th>Bethelbd</th>
        <td class="text-right"><b><?php echo number_format($row['totalsales'],2);?></b></td>
      </tr>
  <?php }
    echo "<tr>
                <th><h2>TOTAL</h2></th>
        <th colspan='2' class='text-right'><h2><b>$total</b></h2></td>
      </tr>";
  }?> 
      
              </tbody>
                    <tfoot>
          
                  
       
        </tfoot>
       </table>
        </div>
      </div>
        </div>    
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Sales and Inventory System <a href="#"></a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>




  </div>





      



<script type="text/javascript">

  

    $(document).ready(function(){
    
  $("#purchase_table").DataTable({
      "responsive": true,
      "autoWidth": false,
    })


  //Initialize Select2 Elements
    $('.select3').select2({
      theme: 'bootstrap4'
    });


 

    });
</script>




<?php

include('includes/footer.php');
?>





