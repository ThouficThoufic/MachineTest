<?php
    include '../assets/backend/db_connection.php';
    include '../assets/backend/employee.php';

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Empolyee Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
  </head>
  <style>
  .red{color:red;}
  </style>
  <body>

        <!-- Add Employee Form -->
        <div class="container">
            <div class="row mt-5">
                <h1 class="col-md-6 offset-md-3 text-center">Add Employee</h1>
                <div class="col-md-6 offset-md-3 mt-2 border rounded p-4">
                    <form method="post" action="../assets/backend/employee.php">
                        <div class="mb-3">
                            <label for="employeeName" class="form-label">Employee Name <span class="red"><sup>*</sup></span></label>
                            <input type="text" class="form-control" id="employeeName" name="employeeName" placeholder="Employee Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeID" class="form-label">Employee ID <span class="red"><sup>*</sup></span></label>
                            <input type="text" class="form-control" id="employeeID" name="employeeID" placeholder="Employee ID" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeEmail" class="form-label">Email <span class="red"><sup>*</sup></span></label>
                            <input type="email" class="form-control" id="employeeEmail" name="employeeEmail" placeholder="Employee Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeePhone" class="form-label">Phone <span class="red"><sup>*</sup></span></label>
                            <input type="tel" class="form-control" id="employeePhone" name="employeePhone" placeholder="Employee Phone number" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeAddress" class="form-label">Address <span class="red"><sup>*</sup></span></label>
                            <input type="text" class="form-control" id="employeeAddress" name="employeeAddress" placeholder="Employee Address" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeRole" class="form-label">Role <span class="red"><sup>*</sup></span></label>
                            <input type="text" class="form-control" id="employeeRole" name="employeeRole" placeholder="Employee Role" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeExperience" class="form-label">Experience <span class="red"><sup>*</sup></span></label>
                            <input type="text" class="form-control" id="employeeExperience" name="employeeExperience" placeholder="Employee Experience" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeEducation" class="form-label">Education <span class="red"><sup>*</sup></span></label>
                            <input type="text" class="form-control" id="employeeEducation" name="employeeEducation" placeholder="Employee Education" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeSalary" class="form-label">Salary <span class="red"><sup>*</sup></span></label>
                            <input type="text" class="form-control" id="employeeSalary" name="employeeSalary" placeholder="Employee Salary" required>
                        </div>
                        <span class="error">Please fill Mandatory fields</span>
                        <button type="button" id="add-employee-btn" name="add-employee-btn" class="btn btn-primary">Add Employee</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- ./Add Employee Form -->

                    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  </body>
</html>



<script>
$(document).ready(function() {
    $('.error').hide();
    $('#add-employee-btn').on('click', function() {
        var name = $('#employeeName').val();
        var email = $('#employeeEmail').val();
        var phone = $('#employeePhone').val();
        var address = $('#employeeAddress').val();
        var role = $('#employeeRole').val();
        var experience = $('#employeeExperience').val();
        var education = $('#employeeEducation').val();
        var salary = $('#employeeSalary').val();
        var ID = $('#employeeID').val();

        if(name != '' && email !='' && phone !='' && address !='' && role !='' && experience !='' && education !='' && salary !='' && ID !=''){
        $.ajax({
            url: "../assets/backend/employee.php",
            method: 'POST',
            data: {
                employeeName: name,
                employeeEmail: email,
                employeePhone: phone,
                employeeAddress: address,
                employeeRole: role,
                employeeExperience: experience,
                employeeEducation: education,
                employeeSalary: salary,
                employeeID: ID,
            },
            dataType: "json",
            success: function(dataResult){
                if(dataResult.statusCode==200){
                    alert("Register successfully !");
                    window.location='http://localhost/employeeManagementPHP/admin/home.php';                  
                }
                else if(dataResult.statusCode==201){
                    alert("Error occured !");
                    window.location='http://localhost/employeeManagementPHP/admin/home.php'; 
                }
                
            }
        });
        }else{
            $('.error').show();
            $('.error').css('color', 'red');
        }
    });
});
</script>