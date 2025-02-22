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
     <h4 class="sent_notification"></h4>
    <div class="row">
      <div class="col-md-8 pl-5 pt-5" >
      <form id="myForm">
        <h2>Send an Email</h2>
        <label>Name</label>
        <input type="text" id="name" placeholder="Enter name" class="form-control">

        <label>Email</label>
        <input type="text" id="email" placeholder="Enter Email" class="form-control">

        <label>Subject</label>
        <input type="text" id="subject" placeholder="Enter subject" class="form-control">

        <p>Message</p>
        <textarea id="body" placeholder="Type Message" class="form-control" rows="5"></textarea><br />

        <button type="button" onclick="sendEmail()" value="Send an Email" class="btn btn-info">Submit</button>
      </form>
      </div>
    </div>




  </div>







        <script>

$(document).ready(function(){

function sendEmail(){

  var  name = $("#name");
  var email = $("#email");
  var subject = $("#subject");
  var body = $("#body");

  if(isNotEmpty(name) && isNotEmpty(email) && isNotEmpty(subject) && isNotEmpty(body)){

    $.ajax({
          url: 'sendEmail.php',
          method: 'POST',
          dataType: 'json',
          data:{
            name: name.val(),
            email: email.val(),
            subject: subject.val(),
            body: body.val()
          },

          success: function(response){
            $('#myForm')[0].reset();
            $('.sent_notification').text("Messegae Sent Successfully");
          }

    });
  }
}

function isNotEmpty(caller){
  if(caller.val()==""){
    caller.css('border','1px solid red');
    return false;
  }
  else
  {
    caller.css('border','');
    return true;
  }
}


});

</script>

<?php

include('includes/footer.php');
?>





