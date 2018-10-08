<?php 
$regEmail = '/^([a-zA-Z0-9\-\_.ôîûêéèçà\']+)(\@){1}((hotmail)|(outlook)|(laposte)|(free)|(orange)|(gmail)){1}.((fr)|(com)|(net)){1}$/';
if(isset($_POST['submit'])){
    if(!empty($_POST['email']) && preg_match($regEmail, $_POST['email'])){
        $email = htmlspecialchars($_POST['email']);
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $display = 1;
            $displayEmail = $email;
        }
    }
}
?>