<?php
    include 'db_connection.php';
    // =========== Fetch Employee Details ==========
    $select = "SELECT * FROM `employee`";
    $s_query = mysqli_query($conn,$select); 

    if(isset($_POST) && !empty($_POST)){ 

            // ============== Select employee On the basis of email id ===============
            $selectEmployee = "SELECT * FROM `employee` WHERE email = '$employeeEmail'";
            $se_query = mysqli_query($conn,$selectEmployee);
            $is_employee = mysqli_num_rows($se_query);

            // =========== Add Employee ===========
            $employeeName = $_POST['employeeName'];
            $employeeEmail = $_POST['employeeEmail'];
            $employeePhone = $_POST['employeePhone'];
            $employeeAddress = $_POST['employeeAddress'];
            $employeeRole = $_POST['employeeRole'];
            $employeeExperience = $_POST['employeeExperience'];
            $employeeEducation = $_POST['employeeEducation'];
            $employeeSalary = $_POST['employeeSalary'];
            $employeeID = $_POST['employeeID'];
        
            
            // Check if employee already exists
            if(!$is_employee){

                $headers = array('alg'=>'HS256','typ'=>'JWT');
                $payload = array('username'=>$employeeEmail, 'exp'=>(time() + 60));

                //generate auth token
                $jwt = generate_jwt($headers, $payload);

                // Insert new employee into database
                $insert = "INSERT INTO `employee`(`name`,`emp_id`, `email`, `phone`, `address`, `emp_role`,`experience`,`education`,`salary`,`auth_token`, `created_at`, `updated_at`) VALUES ('$employeeName','$employeeID','$employeeEmail','$employeePhone','$employeeAddress', '$employeeRole','$employeeExperience','$employeeEducation','$employeeSalary','$jwt', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                $i_query = mysqli_query($conn,$insert);
                // Check if insertion was successful
                if($i_query){
                    $result = ['statusCode'=>200];
                    echo json_encode($result);
                }else{
                    $result = ['statusCode'=>400];
                    echo json_encode($result);
                }
            }else{
                $result = ['statusCode'=>409];
                echo json_encode($result);
            }
                
        
    }


    function generate_jwt($headers, $payload, $secret = 'secret') {
        $headers_encoded = base64url_encode(json_encode($headers));
        
        $payload_encoded = base64url_encode(json_encode($payload));
        
        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
        $signature_encoded = base64url_encode($signature);
        
        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
        
        return $jwt;
    }

    function base64url_encode($data) {
        $base64 = base64_encode($data);
        $base64url = strtr($base64, '+/', '-_');
        return rtrim($base64url, '=');
    }

    
    
    // ========= Fetch Employee Detail According to id===========
    $employee_id = $_GET['employee_id'];
    $select_eid = "SELECT * FROM `employee` WHERE id = '$employee_id'";
    $sid_query = mysqli_query($conn,$select);
    $sid_row = mysqli_fetch_assoc($sid_query);

    // ============ Update Employee ==================
    $editEmployeeName = $_POST['editEmployeeName'];
    $editEmployeeEmail = $_POST['editEmployeeEmail'];
    $editEmployeePhone = $_POST['editEmployeePhone'];
    $editEmployeeAddress = $_POST['editEmployeeAddress'];
    $editEmployeePassword = $_POST['editEmployeePassword'];
    $editEmployeeConfirmPassword = $_POST['editEmployeeConfirmPassword'];
    
    if(isset($_POST['update-employee-btn'])){
        
        // Check if passwords match
        if($editEmployeePassword === $editEmployeeConfirmPassword){
            // Update employee information in the database
            $update = "UPDATE `employee` SET `name`='$editEmployeeName',`email`='$editEmployeeEmail',`phone`='$editEmployeePhone',`address`='$editEmployeeAddress',`password`='$editEmployeePassword',`updated_at`=CURRENT_TIMESTAMP WHERE id = '$employee_id'";
            
            // Check if update was successful
            if(mysqli_query($conn,$update)){
                // Redirect to home page
                header("location:http://localhost/employeeManagementPHP/admin/home.php?username=$_SESSION[adminName]");
            }else{
                // Display error message and redirect back to update employee page
                echo "<script>alert('Something went wrong try again...try again!!'); window.location='../../admin/updateEmployee.php?employee_id=$employee_id';</script>";
            }
                
        }else{
            // Display error message and redirect back to update employee page
            echo "<script>alert('Password and Confirm Password does not match...try again!!'); window.location='../../admin/updateEmployee.php?employee_id=$employee_id';</script>";
        }
    }
     
    // ============= Delete Employee ==============
    // This code checks if the 'del-employee' form has been submitted.
// It then gets the employee_id from the URL and stores it in a variable.
// It then runs two delete queries: one to delete any tasks associated with the employee from the tasklist table, and one to delete the employee from the employee table.
// If the first delete query is successful, it checks if the second delete query is also successful. If both are successful, the user is redirected to the home page.
// If either delete query is unsuccessful, an alert is displayed and the user remains on the current page.
    if(isset($_POST['del-employee'])){
        $employee_id = $_GET['employee_id'];
        $delete = "DELETE FROM `employee` WHERE id='$employee_id'";
        $d_query = mysqli_query($conn,$delete);
        if($dtq_query){
            if($d_query){
                header("location:http://localhost/employeeManagementPHP/admin/home.php?username=$_SESSION[adminName]");
            }else{
                echo "<script>alert('Deleted Successfully!!'); window.location='../../admin/home.php?username=$_SESSION[adminName]';</script>";
            }
        }else{
            // echo $row['id'];
            echo "<script>alert('Something Went wrong...try again!!'); window.location='../../admin/home.php?username=$_SESSION[adminName]';</script>";
        }
    }
?>