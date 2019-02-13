<?php
    session_start();
  
 
     require 'database.php';
    
     if(!empty($_POST['email']) && !empty($_POST['password'])){
        
        $records = $conn->prepare('SELECT id,email,password FROM users WHERE email=:email');
        $records->bindParam(':email', $_POST['email']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        
       /*  $_SESSION['email'] = "CECILIANO";*/
        $mensaje = '';
        
        if(password_verify($_POST['password'],$results['password'])){
            $_SESSION['user_id'] = $results['id'];
            /*una vez que inicio sesion lo redirijo a otra pagina*/
            header('Location: /PHP-Login/login.php');
        }else{
            $mensaje = 'Sorry, those credentials do not match';
        }
    }

   /* echo $_SESSION['email']; */



    

?>



<!DOCTYPE html>
<html>
    <head>
        
        <meta charset= "utf-8">
        
        <title>Login</title>
        
        <!--estilo de la caja-->
        <style type="text/css">  
            #box{
                  width: 480px;
                  height: 500px;              
                  border: 1px solid #c4c8ce;
                  border-radius: 8px;
                  margin: auto;            
            }
        </style>
    </head>
    
    <body>
    
    
     <br>
     <br>
     <br>
     <br>
     <br>
     <br>   
     <br> 
     <br>               
    
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
   
    
    <link rel="stylesheet" href="asserts/css/style.css">
     
     <div id="box"> <!--dentro de la caja-->
         <br>
         <br>
         <br>
         <img src="https://graffica.info/wp-content/uploads/2017/06/ColoresGoogleLogo.jpg"
          width="100"
          height="30">
             
         <br>
         <br>
         <h3> Sign in
with your Google Account</h3>
        
         <?php if(!empty($mensaje)):  ?>
            <p>Sorry, those credentials do not match,try again</p>
            <?php endif; ?>
         
         <form action="index.php" method="post">
            
            <input type="text"  name="email" placeholder="Enter your email">
            <input type="password" name="password" placeholder="Enter your password">
            <input type="submit" value="Login">
            
        </form>  <!––Address to send the data of the form, in this case login.php––>
    
      
    
    <a href="register.php">
      <button class="loginBtn loginBtn--facebook">
      SingUp
      </button> 
    </a>
    
    <br>
    
    <a href="forgot_pass.php"> Forgot password? </a>
     
         
     </div>
     
    
    </body>
    
</html>