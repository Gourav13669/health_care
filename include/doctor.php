<?php session_start();

include "../db.php"; 


if(!$_SESSION['username']){
	header("location:../index.php");
}
if($_SESSION['role'] !== 'doctor' ){

	header("location:access_denied.html");
}



 
function get_patient_number( $date) {
	global $connection;
	$query = "SELECT count(*) as patient_num  FROM `patient` where patient_date='$date'" ;            
    $result = mysqli_query($connection,$query);
    $patient_number   = mysqli_fetch_assoc($result);
     return $patient_number['patient_num'];

}

get_patient_number(date('y-m-d'));
 
            
      

$dataPoints = array(
	array("y" => get_patient_number(date('y-m-d',strtotime("-7 days"))), "label" => date('d.m.Y',strtotime("-7 days")) ),
	array("y" => get_patient_number(date('y-m-d',strtotime("-6 days"))), "label" => date('d.m.Y',strtotime("-6 days")) ),
	array("y" => get_patient_number(date('y-m-d',strtotime("-5 days"))), "label" => date('d.m.Y',strtotime("-5 days")) ),
	array("y" => get_patient_number(date('y-m-d',strtotime("-4 days"))), "label" => date('d.m.Y',strtotime("-4 days")) ),
	array("y" =>get_patient_number(date('y-m-d',strtotime("-3 days"))), "label" => date('d.m.Y',strtotime("-3 days")) ),
	array("y" => get_patient_number(date('y-m-d',strtotime("-2 days"))), "label" => date('d.m.Y',strtotime("-2 days")) ),
	array("y" =>get_patient_number(date('y-m-d',strtotime("-1 days"))), "label" => date('d.m.Y',strtotime("-1 days")) ),
	array("y" => get_patient_number(date('y-m-d')), "label" => date('d.m.Y') )
);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>HEALTHCARE</title>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Docter's Graph"
	},
	axisY: {
		title: "Number of Patient"
	},

	axisX: {
		title: "Date"

	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">




</head>
<body>
 <?php include "header.php"; ?>

	 <h1 style="text-align: center;"> Welcome Doctor  </h1> <br>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>


<!----canvas.js--->


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>	