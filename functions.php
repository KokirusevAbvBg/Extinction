<?php  
    session_start(); 
    
    function register(){
        if( (isset($_POST['username']) and isset($_POST['password']) and (isset($_POST['confirm']))
        and (!empty($_POST['username'])) and !empty($_POST['password']) and !empty($_POST['confirm'])) ){
            $username=htmlentities (mysql_real_escape_string($_POST['username']));
            $password=htmlentities (mysql_real_escape_string(md5($_POST['password'])));
            $confirm=htmlentities (mysql_real_escape_string(md5($_POST['confirm'])));
            $email=htmlentities (mysql_real_escape_string($_POST['email']));   

            $result=mysql_query("SELECT username FROM users WHERE username='$username'");
            $name_num_rows=mysql_num_rows($result);

            if($name_num_rows!=0){
                $errors[] = '<p class="error">The username is taken</p>';
            }
            if($password!=$confirm){
                $errors[] = '<p class="error">The passwords doesnt match</p>';  
            }

        }else{
            $errors[] = '<p class="error">Please fill the fields</p>';  
        }

        if (empty($errors)) {
            $query = "INSERT INTO users (username,password,email) VALUES ('$username','$password','$email')";
            $result = @mysql_query($query);
            if (mysql_affected_rows() == 1) {

                set_stats();
                send_email($email);       
                echo '<p id="welmsg">You have been registered.</p>';
            } else {
                echo '<p class="error">There was an error while registering</p>';
            }

        } else {
            echo '<p class="error">The following error(s) occured:</p>';
            foreach ($errors as $msg) {
                echo  $msg;
            }
        }

    }

    function set_stats(){
        $health=100;
        $damage=20;
        $defense=10;
        $luck=10;
        $exp=0;
        $level=1;

        $query = "INSERT INTO hero_stats (health,damage,defense,luck,exp,level) 
        VALUES ('$health','$damage','$defense','$luck','$exp','$level')";
        $result = @mysql_query($query);
    }

    function send_email($email){
        $to = $email;
        $subject = 'Extinction e-mail address confirmation';
        $message = "
        <p>Hey! Thanks for signing up for the browsergame. Click below to confirm your e-mail address.</p>
        <p><a href='http://website.com/confirm.php?email=$email'>below</a></p>";
        $headers = 'From: NikIvRu@Extinction.com' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        mail($to,$subject,$message,$headers);

    }

    function emai_confrim(){
        if($_GET) {
            $email = $_GET['email'];

            $query = sprintf("SELECT COUNT(id) FROM users WHERE email = '%s' AND confirmed=0",
            mysql_real_escape_string($email));
            $result = mysql_query($query);
            list($count) = mysql_fetch_row($result);
            if($count >= 1) {
                $query = sprintf("UPDATE users SET confirmed=1 WHERE email = '%s'",
                mysql_real_escape_string($email));
                mysql_query($query);
            ?>
            <span style='color:#8F7B55'>Congratulations, you've confirmed your e-mail address!</span>
            <?php
            } else {
            ?>
            <span style='color:red'>Oops! Either that user doesn't exist, or that e-mail address has already been confirmed.</span>
            <?php
            }
        }   
    }

    function login(){

        echo "Ive been called";
        if(isset($_POST['username']) and isset($_POST['password'])
        and !empty($_POST['username']) and !empty($_POST['password'])){

            $username=htmlentities(mysql_real_escape_string($_POST['username']));
            $password=htmlentities(mysql_real_escape_string(md5($_POST['password'])));
            $query="SELECT id,username FROM users 
            WHERE username='$username' AND password='$password'";
            $result=mysql_query($query);
            $count=mysql_num_rows($result);
            if($count==1){
                $_SESSION['username']=$username;
                //echo $_SESSION['username'];
                header("Location:index.php");                    
            }else{
                echo 'Incorrect username or passoword';    
            }
        }else{
            echo 'Please fill all the fields';  
        }        
    }
?>