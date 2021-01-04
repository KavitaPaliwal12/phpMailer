<?php
session_start();

include_once('pdoconfig.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$nameError    = "";
$emailError   = "";
$mobileError  = "";
$dateError    = "";
$courseError  = "";
$genderError  = "";
$addressError = "";
$detailsError = ""; 

$flag=false;

if (isset($_POST['submit'])) {
    //print_r($_POST);                //For Dubugging 
    $Name   = isset($_POST['name']) ? $_POST['name'] : '';
    $Email  =  $_POST['email'];
    $Mobile =  $_POST['mob'];
    $Date   =  $_POST['date'];
    $Course =  $_POST['course'];
    @$Gender = $_POST['gender'];
    $Address = $_POST['address'];
    $Details = $_POST['details'];

    
    
    //Name Validation
    if (empty($Name)) {
        
        $nameError = "Please Enter Your Name";
        $flag=true;
        
    } else if (!preg_match("/^([a-zA-Z' ]+)$/", $Name)) {
        $nameError = "Only alphabets and whitespace are allowed.";
        $flag=true;
        
    }
    
    
    
    //Email Validation
    if (empty($Email)) {
        $emailError = "Please Enter Your Email";
        $flag=true;
    } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Please Enter Valid Email";
        $flag=true;
    } 
    //Mobile Validation
    if (empty($Mobile)) {
        $mobileError = "Please Enter Mobile Number";
        $flag=true;
    } else if (strlen($Mobile) < 10) {
        $mobileError = "Mobile Number Should Be of 10 Digits";
        $flag=true;
    } else if (!preg_match("/^[6-9]\d{9}$/", $Mobile)) {
        $mobileError = "Invalid Mobile Number!!";
        $flag=true;
    }
    
    //Gender Validation
    if (!isset($Gender)) {
        $genderError = "Please Select Your Gender";
        $flag=true;
    }

    //Course Validation 
      if(empty($Course)){
      $courseError = "You forgot to select your Course!";
      $flag=true;
    }

    //Date Validation
    if (empty($Date)) {
        $dateError = "Enter Your Date of Birth";
        $flag=true;
    }

    //Address Validation
   if (!isset($Address)){
      $addressError="Please Enter Your Address";
      $flag=true;
    }
      else if(!preg_match('/[A-Za-z0-9\-\\,.]+/', $Address)) {
        $addressError = "Please Enter Valid Address";
        $flag=true;
    }
    

    //Address details Validation
    if (!isset($Details)){
      $detailsError="Please Enter Your Address details";
      $flag=true;
    }
      else if(!preg_match('/[A-Za-z0-9\-\\,.]+/', $Address)) {
        $detailsError = "Please Enter Valid Address details";
        $flag=true;
    }
    
      
    if(!$flag)
    {

  //insert values in database
   $stmt = $conn->prepare("INSERT INTO reg_tbl (Name, Email, Mobile, dateOfBirth, Course, Gender, Address, Details)
  VALUES (:Name, :Email, :Mobile ,:iDate, :Course, :Gender, :Address, :Details)");
  $stmt->bindParam(':Name', $Name);
  $stmt->bindParam(':Email', $Email);
  $stmt->bindParam(':Mobile', $Mobile);
  $stmt->bindParam(':iDate',$Date);
  $stmt->bindParam(':Course', $Course);
  $stmt->bindParam(':Gender', $Gender);
  $stmt->bindParam(':Address', $Address);
  $stmt->bindParam(':Details', $Details);
   $check=$stmt->execute();
 }

if($check)
{

        $to     = 'paliwalkavita27@gmail.com'; 
        $toUser = 'paliwalkavita128@gmail.com'; 
        
        $userSubject = 'Thankyou for submitting your query';
        $subject     = 'New query submitted at XYZ.com';
        
        $message     = "Please find the details below:
                    Name.'$Name',
                    Email.'$Email',
                    Mobile.'$Mobile',
                    Date.'$Date',
                    Course.'$Course',
                    Gender.'$Gender',
                    Address.'$Address' 
                    Details.'$Details'";
        $userMessage = "Hii user,your query was submitted successfully";
  
        $mail = new PHPMailer(true);


        try 
        {                     
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.hostinger.com';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'support@sonuhaircut.com';                   
        $mail->Password   = 'poojaT@89';                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port       = 587;                                    
        //Recipients
        $mail->setFrom('support@sonuhaircut.com', 'Mailer');
        $mail->addAddress("$to", 'hello');     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "$subject";
        $mail->Body    = "$message";

    
        $sendMailAdmin= $mail->send();

        $mail->clearAllRecipients();
        $mail->addAddress("$toUser", 'hello');
        $mail->Subject = "$userSubject";
        $mail->Body    = "$userMessage";

        $sendMailUser=$mail->send();

        //echo 'Message has been sent';
        } 
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
        if($sendMailAdmin && $sendMailUser){
          $_SESSION['msg'] = "Message has been send successfully";
        }
        else {
          $_SESSION['msg'] = "Unable to send query";
       
        }
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
.reg-flex-dir-col{
  flex-direction: column;
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
       
        
              <form method="POST" action="">
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
            <span class="error"><?php
echo $dateError;
?></span>
</div>
          </div>
        
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="course">Course</label>
                <select  class="form-control" name="course">
                  <option value="">Select</option>
                  <option value="BCA">BCA</option>
                  <option value="MCA">MCA</option>
                  <option value="IT">IT</option>
                  <option value="ECE">ECE</option>
                </select>
                <span  class="error"><?php
echo $courseError;
?></span>
              </div>
              <div class="form-group col-md-6 d-flex justify-content-center align-items-center reg-flex-dir-col">
                  
                <div class="d-flex justify-content-center align-items-center mt-4">
                  <label for="gender" class="mx-5 my-0">Gender:</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="inlineCheckbox1" name="gender" value="male">
                    <label class="form-check-label" for="inlineCheckbox1">Male</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="inlineCheckbox2"  name="gender" value="female">
                    <label class="form-check-label" for="inlineCheckbox2">Female</label>
                  </div>
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
                <span class="error" ><?php
echo $detailsError;
?></span>
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