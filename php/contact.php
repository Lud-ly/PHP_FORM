<?php

$array = array("firstname" =>"","name" =>"","email" =>"","phone" =>"","subject" =>"","message" =>"","firstnameError" =>"","nameError" =>"","emailError" =>"","phoneError" =>"","subjectError" =>"","messageError" =>"","isSuccess" =>false);

  
   $emailTo = "*****@gmail.com";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $array["firstname"] = verifyInput($_POST["firstname"]);
    $array["name"] = verifyInput($_POST["name"]);
    $array["email"] = verifyInput($_POST["email"]);
    $array["phone"] = verifyInput($_POST["phone"]);
     $array["subject"] = verifyInput($_POST["subject"]);
    $array["message"] = verifyInput($_POST["message"]);
    $array["isSuccess"] = true;
    $emailText = "";
    
    
    if(empty($array["firstname"])){
        
        $array["firstnameError"] = "Je veux connaître votre prénom !";
        $array["isSuccess"] = false;
    }
    else
        $emailText .= "firstName : {$array['firstname']}\n";
    
    if(empty($array["name"])){
        
        $array["nameError"] = "Et oui je veux tout savoir, Même votre nom !";
         $array["isSuccess"] = false;
        
    }
    else 
         $emailText .= "Name : {$array['name']}\n";
    
    
    if(!isEmail($array["email"])){
        
        $array["emailError"] = "c'est pourtant pas compliqué ,allez courage !";
        $array["isSuccess"] = false;
    }
     else 
         $emailText .= "Email : {$array['email']}\n";
         
    
    if (!isphone($array["phone"])){
        
        $array["phoneError"] = "Que des chiffres et des espaces, svp...";
        $array["isSuccess"] = false;
    }
     else 
         $emailText .= "Phone : {$array['phone']}\n";
         
    if (empty($array["subject"])){
        
        $array["subjectError"] = "De quoi veut-tu me parler ?";
        $array["isSuccess"] = false;
    }
    
    if(empty($array["message"])){
        
        $array["messageError"] = "Qu'est-ce que vous voulez me dire ?";
        $array["isSuccess"] = false;
     }
     else 
         $emailText .= "Message : {$array['message']}\n";
    
    
    if( $array["isSuccess"]){
        
        $headers = "from :{$array['firstname']} {$array['name']} <{$array['email']}>\r\nReply-To: {$array['email']}";
        mail($emailTo,$array["subject"],$emailText , $headers);
       
    }
    
    echo json_encode($array);
    
}
    function isPhone($var){
        return preg_match("/^[0-9 ]*$/",$var);
    }

    function isEmail($var){
        
        return filter_var($var,FILTER_VALIDATE_EMAIL);
    }
    
    function verifyInput($var){
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }

?>