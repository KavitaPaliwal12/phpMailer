<?php

session_start();

$nameError    = "";
$emailError   = "";
$mobileError  = "";
$dateError    = "";
$courseError  = "";
$genderError  = "";
$addressError = "";




if (isset($_POST['submit'])) {
    //print_r($_POST);                //For Dubugging 
    $Name   = isset($_POST['name']) ? $_POST['name'] : '';
    $Email  = $_POST['email'];
    $Mobile = $_POST['mob'];
    $Date   = $_POST['date'];
    $Course = $_POST['course'];
    @$Gender = $_POST['gender'];
    $Address = $_POST['address'];
    
    
    
    
    //Name Validation
    if (empty($Name)) {
        
        $nameError = "Please Enter Your Name";
        
    } else if (!preg_match("/^([a-zA-Z' ]+)$/", $Name)) {
        $nameError = "Only alphabets and whitespace are allowed.";
        
    }
    
    
    //Email Validation
    if (empty($Email)) {
        $emailError = "Please Enter Your Email";
    } else if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Please Enter Valid Email";
    } else {
        $emailError = "Please Enter Valid Email";
    }

    //Mobile Validation
    if (empty($Mobile)) {
        $mobileError = "Please Enter Mobile Number";
    } else if (strlen($Mobile) < 10) {
        $mobileError = "Mobile Number Should Be of 10 Digits";
    } else if (!preg_match("/^[6-9]\d{9}$/", $Mobile)) {
        $mobileError = "Invalid Mobile Number!!";
    }
    
    //Address Validation
    if (empty($Address) && !preg_match('/^[^@]{1,63}@[^@]{1,255}$/', $Address)) {
        $addressError = "Invalid!!";
    }
    
    //Gender Validation
    if (isset($Gender)) {
        $gmailError = "Please Select Your Gender";
    }

    //Course Validattion 
    if (empty($Course)) {
        $courseError = "Please Select Your Course";
    }

    //Date Validation
    if (empty($Date)) {
        $dateError = "Enter Your Date of Birth";
    }
    
    
    $to     = 'xyz@gmail.com'; 
    $toUser = 'abcd@gmail.com'; 
    
    $userSubject = 'Thankyou for submitting your query';
    $subject     = 'Registration Form';
    
    $message     = "Please find the details below:
                Name.'$Name',
                Email.'$Email',
                Mobile.'$Mobile',
                Date.'$Date',
                Course.'$Course',
                Gender.'$Gender',
                Address.'$Address' ";
    $userMessage = "Hii user,your query was submitted successfully";
    
    
    
      $isAdminMailSent = mail($to, $subject, $message);
      $isUserMailSent = mail($toUser, $userSubject, $userMessage);
    
    
    //Session Set
    if ($isAdminMailSent && $isUserMailSent) {
        $_SESSION['msg'] = "Query submitted successfully";
    } else {
        $_SESSION['msg'] = "Unable to submit query";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Registration Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style type="text/css"> 
.error{
color:red;
}
</style>
</head>

<body>

  <h2><center><u>Registratrion Form </u></center></h2>
    <div class="container">
        
    <div class="row">
      
       <div class="col-md-8 col-sm-12 mx-auto mt-5">
           <?php
if (isset($_SESSION['msg'])):
?>
           <div class="alert alert-primary">
                <?= $_SESSION['msg'] ?>
           </div>
        <?php
    unset($_SESSION['msg']);
endif;
?>
       
        
              <form method="POST" action="#">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">Enter Your Name</label>
              <input type="name" class="form-control" name="name" placeholder="Enter your name">
              <span class="error"><?php
echo $nameError;
?></span>
            </div>
            <div class="form-group col-md-6">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" placeholder="abcd@xyz">
              <span class="error"><?php
echo $emailError;
?></span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="mob">Mobile</label>
              <input type="tel" class="form-control" name="mob" placeholder="Enter Your Mobile Number" >
              <span  class="error"><?php
echo $mobileError;
?></span>

            </div>
            <div class="form-group col-md-6">
              <label for="date">Date of birth</label>
              <input type="date" class="form-control" name="date" placeholder="Date of birth" >
            </div>
            <span class="error"><?php
echo $dateError;
?></span>
          </div>
        
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="course">Course</label>
                <select  class="form-control" name="course">
                  <option selected>Select</option>
                  <option>BCA</option>
                  <option>MCA</option>
                  <option>IT</option>
                  <option>ECE</option>
                </select>
                <span  class="error"><?php
echo $courseError;
?></span>
              </div>
              <div class="form-group col-md-6 d-flex justify-content-center align-items-center">
                  <label for="gender" class="mx-5 my-0">Gender:</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="inlineCheckbox1" name="gender" value="male">
                    <label class="form-check-label" for="inlineCheckbox1">Male</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="inlineCheckbox2"  name="gender" value="female">
                    <label class="form-check-label" for="inlineCheckbox2">Female</label>
                  </div>
                  <span class="error"><?php
echo $genderError;
?></span>
              </div>
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="address" >Address</label>
                <textarea class=" form-control" rows="4" placeholder="Address" name="address"></textarea>
                <span class="error" ><?php
echo $addressError;
?></span>
              </div>
              <div class="form-group col-md-6">
                <label for="address" >Details</label>
                <textarea class=" form-control" rows="4" placeholder="Address" name="details"></textarea>
              </div>
            </div>
    
            <div class="col-md-4">
               <button type="submit" class="btn btn-primary" name="submit">Submit</button>
               </div>
        </form>
       </div>
       </div>
    </div>

</body>
</html>