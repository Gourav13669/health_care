
<?php session_start(); ?>
<?php include "db.php"


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>HEALTHCARE</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merienda+One">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">


  </head>
  <body>
<?php
if(isset($_POST['submit'])){
$user = $_POST['username'];
$pass = $_POST['password'];
$query = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'  " ;

$read = mysqli_query($connection,$query);

$count = mysqli_num_rows($read);

if($count==1){
$login_user =  mysqli_fetch_assoc($read);
 $_SESSION['username'] = $login_user['username'];

$role = $login_user['role'];
 $_SESSION['role'] = $role;


if ($role == 'admin') {
  header("Location:include/admin.php");
}
else if ($role == 'staff') {

    header("Location:include/staff.php");
}
else {
  header("Location:include/doctor.php");
}



}
else {
  ?>

   <script type="text/javascript"> alert("Wrong Information") </script>
  <?php
  
}

}


?>


   <div class="login-form">    
    <form  method="post">
    <div class="avatar"><i class="material-icons">&#xE7FF;</i></div>
      <h4 class="modal-title">Login to Your Account</h4>
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Username" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" required="required">
        </div>
        <div class="form-group small clearfix">
            <label class="form-check-label"><input type="checkbox"> Remember me</label>
            
        </div> 
        <input type="submit" class="btn btn-primary btn-block btn-lg" name="submit" value="Login">              
    </form>     
           </div>




<?php include "include/footer.php"; ?>
