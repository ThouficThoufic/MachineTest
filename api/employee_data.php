<?php
    include '../assets/backend/db_connection.php';


    header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");


	if ($_SERVER['REQUEST_METHOD'] === 'POST') {


		if(empty($_POST))
		{
			$result = [
				'statusCode'=>400,
				'message'=>'Request body cannot be blank',
				'data'=>[]
			];

			echo json_encode($result);die;
		}

		if(!isset($_POST['emp_id']) || !isset($_POST['token']))
		{
			$result = [
				'statusCode'=>400,
				'message'=>'Request params emp_id and token are missing',
				'data'=>[]
			];

			echo json_encode($result);die;
		}

		$employeeID = $_POST['emp_id'];
		$selectEmployee = "SELECT * FROM `employee` WHERE emp_id = '$employeeID'";
        $result = mysqli_query($conn,$selectEmployee);
        $row = $result -> fetch_assoc();

        if($row['auth_token'] != $_POST['token'])
        {
        	$result = [
				'statusCode'=>400,
				'message'=>'Token is not match !!',
				'data'=>[]
			];

			echo json_encode($result);die;
        }




		$url = 'http://localhost/employeeManagementPHP/api/fetch_data.php';
		$authToken = $_POST['token'];

		// User data to be sent
		$userData = array(
		    'emp_id' => $employeeID
		);

		// Convert the user data to JSON
		$jsonData = json_encode($userData);

		// Initialize cURL
		$curl = curl_init();

		// Set the cURL options
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $userData);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		//     'Content-Type: application/json',
		//     'Authorization: Bearer ' . $authToken,
		// ));

		// Execute the cURL request
		$response = curl_exec($curl);


		// Check if the request was successful
		if ($response === false) {
		    $error = curl_error($curl);
		    echo "cURL Error: " . $error;
		} else {
		    echo $response;
		}

		// Close the cURL session
		curl_close($curl);

	}

?>