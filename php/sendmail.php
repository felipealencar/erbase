<?php

include 'functions.php';
require_once 'Mail.php';

if (!empty($_POST)){

  $data['success'] = true;
  $_POST  = multiDimensionalArrayMap('cleanEvilTags', $_POST);
  $_POST  = multiDimensionalArrayMap('cleanData', $_POST);

  //your email adress 
  $emailTo ="felipealencarlopes@gmail.com"; //"yourmail@yoursite.com";

  //from email adress
  $emailFrom = $_POST["email"]; //"contact@yoursite.com";

  //email subject
  $emailSubject = "E-mail do Portal";

  $name = $_POST["name"];
  $email = $_POST["email"];
  $body = $_POST["comment"];

  
  if($name == "")
   $data['success'] = false;
 
 if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) 
   $data['success'] = false;


 if($body == "")
   $data['success'] = false;

 if($data['success'] == true){

  $message = "NOME: $name<br>
  E-MAIL: $email<br>
  MENSAGEM: $body";

  $headers = array(
		'From' => $emailFrom,
		'To' => $emailTo,
		'Subject' => 'E-mail do Portal'
  )
  
  $smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => '465',
        'auth' => true,
        'username' => 'felipealencarlopes@gmail.com',
        'password' => ''
    ));
  
  $mail = $smtp->send($emailTo, $headers, $body

  $data['success'] = true;
  if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
  } else {
    echo('<p>Message successfully sent!</p>');
  }
  echo json_encode($data);
}
}