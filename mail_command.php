<?php
////////// script written by Don Caplon - BS CS FSU 2021 //////////

$nameErr = $emailErr = "";
$name = $email = $message = "";
$valid = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // if the name field is empty - not valid
    if (empty($_POST["name"])) {
         $nameErr = "Full Name is required";
         $valid = false;
    }
    else {
         $name = test_input($_POST["name"]);
    }
    // if the email format is improper - not valid
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
         $emailErr = "Email is invalid";
         $valid = false;
    }
    // if the email is left blank - not valid
    if (empty($_POST["email"])) {
         $emailErr = "Email is required";
         $valid = false;
    }
    else {
         $email = test_input($_POST['email']);
    }
    // if the message is blank - still ok, but confirm on server side a blank mssg. is sent
    if (empty($_POST["message"])) {
         $message ="";
    }
    else {
         $message = test_input($_POST['message']);
    }

    $formcontent=" From: $name \nMessage: $message";
    $recipient = "jw19bc@my.fsu.edu"; // ATTN: only send to an @fsu.edu email (officer or advisor)
    $subject = "FSU Online ACM Club Contact Form Submission";
    $mailheader = "From: $email \r\n";
    // if all tests are passed and contact form is valid, send the email and display success alert
    if ($valid) {
         if (mail($recipient, $subject, $formcontent, $mailheader)) {
              // success message was sent ! - redirect back to index.html home page with a 'mailsentsuccess' suffix
              echo '<script>';
              echo 'alert("Thank you for contacting the FSU Online ACM Club, we will reply soon!");';
              echo 'location.href="index.html?mailsentsuccess"';
              echo '</script>';
         }
         // extra error checking, should never get here ... redirect to index.html home page with a 'fatalerror' suffix
         else {
              echo '<script>';
              echo 'alert("Oops, something went wrong!!");';
              echo 'location.href="index.html?fatalerror"';
              echo '</script>';
         }
    }
    // contact form was not valid, redirect to index.html home page with an 'error' suffix and failed reasons alert
    else {
        echo '<script>';
        echo 'alert("Form cannot have empty fields, or have an invalid email format. Sorry, please re-submit.");';
        echo 'location.href="index.html?error"';
        echo '</script>';
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
