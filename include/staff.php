<?php 

session_start();


include "../db.php";
 
if(!$_SESSION['username']){
  header("location:../index.php");
}

if($_SESSION['role'] !== 'staff' ){

  header("location:access_denied.html");
}

function get_branches(){
  global $connection;


$query = "SELECT * FROM `branch` " ; 
           
                $result_categories = mysqli_query($connection,$query);
               
                $data = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
                return $data;

}

get_branches();

 ?>
<!DOCTYPE html>
<html>
<head>
  <title>HEALTHCARE</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!----bootstrap--->

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



</head>
<body>
 
 <!---navbar-->

 <?php include "header.php"; ?>



<div style="margin: 5% 25%;" class="col-lg-6">
  <h1 style="text-align: center;">Patient Register</h1>
<form method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" name="name"  aria-describedby="emailHelp" placeholder="Enter name">
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Contact</label>
    <input type="number" class="form-control" name="contact" placeholder="Phone">
  </div>
    <div class="form-group">
    <label for="exampleInputPassword1">AGE</label>
    <input type="number" class="form-control" name="age"  placeholder="Age">
  </div>

 


  
  
  <input type="submit" class="btn btn-primary" name="patient_submit" value="Submit">
</form>
</div>
<!----php code--->

<?php 

if(isset($_POST['patient_submit'])){
 
$patient_name = $_POST['name'];
 $patient_contact =  $_POST['contact'];
 $patient_age = $_POST['age'];



 $query = " INSERT INTO `patient`(`name`, `phone`, `age` ,`patient_date` ) ";
$query .= " VALUES( '$patient_name' , '$patient_contact' , ' $patient_age' , now()) ";


$add_patient = mysqli_query($connection,$query);


if($add_patient){  
 ?>

   <script type="text/javascript"> alert("Paatient Register") </script>
  <?php
  
  
} 


}




?>

