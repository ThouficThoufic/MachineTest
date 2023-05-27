<?php
    include '../assets/backend/db_connection.php';


    header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");


	if($_POST['emp_id'])
	{
		$employeeID = $_POST['emp_id'];
		$selectEmployee = "SELECT * FROM `employee` WHERE emp_id = '$employeeID'";
        $result = mysqli_query($conn,$selectEmployee);
        $row = $result -> fetch_assoc();
		if($row)
		{
			$result = [
				'statusCode'=>200,
				'message'=>'Employee Details Found',
				'Data'=>$row
			];

			echo json_encode($result);

		}

	}