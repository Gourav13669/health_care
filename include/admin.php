<?php session_start();?>
<?php include "../db.php"; 

if(!$_SESSION['username']){
  header("location:../index.php");
}

if($_SESSION['role'] !== 'admin' ){

  header("location:access_denied.html");
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    .col{

      background-color: #28a745 !important;
    }

  </style>
</head>

<body>
 <!---navbar-->

 <?php include "header.php"; ?>


<h3 style="text-align: center;"> WELCOME ADMIN </h3>



<div class="col-lg-4 col-md-3">
<div class="container">

  <a href="#demo" class="btn btn-info" data-toggle="collapse">Add Branch</a>
  <div id="demo" class="collapse">
    <form method="post">
  <label for="fname">Branch Name</label><br>
  <input type="text" id="fname" name="branch_name" ><br>
  <label for="lname">Amount Per Patient</label><br>
  <input type="text" id="lname" name="amount" > <br>
  <input type="submit" name="branch_submit">



</form>
<?php   
if(isset($_POST['branch_submit'])){
  
$branch_name =  $_POST['branch_name'];
$branch_amount  = $_POST['amount'];

  $query = " INSERT INTO `branch`(`branch_name`, `amount_per`) ";
$query .= " VALUES('$branch_name' , '$branch_amount') ";
//print_r($query); die();

$add_branch = mysqli_query($connection,$query);

//print_r($add_branch); die();
if(!$add_branch){
  die("fail");
} 


}


function validate_staff($branch_id){

$validation = False;

global $connection;
  $query = "SELECT count(*) as staff_count  FROM `users` where branch_id='$branch_id'" ;            
  $result = mysqli_query($connection,$query);
  $user_count   = mysqli_fetch_assoc($result);

    $query2 = "SELECT amount_per FROM branch WHERE branch_id='$branch_id' ";
    $result = mysqli_query($connection,$query2);
    $total_quota   = mysqli_fetch_assoc($result);
if ($total_quota['amount_per'] > $user_count['staff_count']) {
  $validation = TRUE;
}

return $validation;
}
?>

  </div>
</div>
</div>
<!---staff add form--->
<div class="col-lg-4 col-md-3">
<div class="container">

  <a href="#staff" class="btn btn-info" data-toggle="collapse">Add Staff</a>
  <div id="staff" class="collapse">
    <form method="post">
  <label for="fname">Username</label><br>
  <input type="text" id="fname" name="staff_name" ><br>
  <label for="lname">Password</label><br>
  <input type="password" id="lname" name="staff_pass" > <br>
  <label for="lname">Phone</label><br>
  <input type="text" id="lname" name="staff_ph" > <br>

   <select name="branch_select">

<?php
   $query = "SELECT branch_id, branch_name FROM branch " ; 
           
                $result_categories = mysqli_query($connection,$query);


                  while ($row = mysqli_fetch_assoc($result_categories)) {
            
                    $id = $row['branch_id'];
                    $name = $row['branch_name']; 
                

                   echo "<option value='$id'> $name </option> ";

                }


?>
</select> <br>

  


  <input type="submit" name="staff_submit">



</form>


<!----staff register-->

<?php   
if(isset($_POST['staff_submit'])){
  
$staff_name =  $_POST['staff_name'];
$staff_pass = $_POST['staff_pass'] ;
$staff_ph =  $_POST['staff_ph'] ;
$branch_id = $_POST['branch_select'];

$status = validate_staff($branch_id);

if ($status == False) {
  ?>

   <script type="text/javascript"> alert("Apologies!!Selected branch reached the maximun staff quota. ") </script>
  <?php

}
 else { 
$staff_name = mysqli_real_escape_string($connection,$staff_name);

$staff_pass= mysqli_real_escape_string($connection,$staff_pass);

//password secure
$hashformat = "$2y$10$";
$salt = "iusesomecrazystrings22";
$hf_salt = $hashformat . $salt;
$staff_pass = crypt($staff_pass,$hf_salt);


  $query = " INSERT INTO `users`(`username`, `password` , `role` , `phone` , `branch_id`) ";
$query .= " VALUES('$staff_name' , '$staff_pass' , 'staff' , '$staff_ph' , '$branch_id') ";
//print_r($query); die();

$add_staff = mysqli_query($connection,$query);

//print_r($add_branch); die();
if(!$add_staff){
  die("fail");
} 


}
}



?>

  </div>
</div>
</div>

<!---doctor add form--->
<div class="col-lg-4 col-md-3">


<div  class="container">

  <a href="#doctor" class="btn btn-info" data-toggle="collapse">Add Doctor</a>
  <div id="doctor" class="collapse">
    <form method="post">
  <label for="fname">Username</label><br>
  <input type="text" id="fname" name="doctor_name" ><br>
  <label for="lname">Password</label><br>
  <input type="password" id="lname" name="doctor_pass" > <br>
   <label for="lname">Phone</label><br>
  <input type="text" id="lname" name="doctor_ph" > <br>
  <input type="submit" name="doctor_submit">



</form>
<?php   
if(isset($_POST['doctor_submit'])){
  
$doctor_name =  $_POST['doctor_name'];
$doctor_pass = $_POST['doctor_pass'] ; 
$doctor_phone = $_POST['doctor_ph'] ; 

  
$doctor_name = mysqli_real_escape_string($connection,$doctor_name);

$doctor_pass= mysqli_real_escape_string($connection,$doctor_pass);



  $query = " INSERT INTO `users`(`username`, `password` , `role` , `phone`) ";
$query .= " VALUES('$doctor_name' , '$doctor_pass' , 'doctor' , '$doctor_phone') ";


$add_doctor = mysqli_query($connection,$query);


if(!$add_doctor){
  die("fail");
} 


}



?>






  </div>
</div>
</div>

