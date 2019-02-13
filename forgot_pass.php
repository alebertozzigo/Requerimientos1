<?php
    session_start();
     
    require 'database.php';
    if($global = 0){
        $results = '';
    }
    
    
     if(!empty($_POST['email']) or !empty($_POST['question_answer']) or ( !empty($_POST['new_pass']) &&  !empty($_POST['confirm_email']) )   ){
         
        
         
        $records = $conn->prepare('SELECT id, password, question_number, question_answer FROM users WHERE email=:email || question_answer = :question_answer');
        
            if(empty($_POST['email'])){/*si el correo esta vacio pruebo con la confirmacion de correo*/
                $records->bindParam(':email', $_POST['confirm_email']);
            }else{
                $records->bindParam(':email', $_POST['email']);
            }
        $records->bindParam(':question_answer', $_POST['question_answer']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        
        $mensaje = '';
         
         if($records->execute()){ 
            
             if($results['question_number'] == 1){$global = 1;}
             if($results['question_number'] == 2){$global = 2;}
             if($results['question_number'] == 3){$global = 3;}           
             
         }else{
             $mensaje = 'That email does not exist';
             
         }
         
         if(!empty($_POST['question_answer'])){ /*no esta vacio el campo de respuesta a la pregunta*/
       
            if($_POST['question_answer'] == $results['question_answer']){ /*si la respuesta es igual a la de la base*/
            $global = 4;
            }else{
            $mensaje = 'Incorrect answer';
          }
        
         }
         if(!empty($_POST['new_pass'])){
             /*cambio la contrasena*/
              $records1= $conn->prepare('UPDATE `users` SET `password` = :pass WHERE `users`.`email` = :email');
                $records1->bindParam(':email' , $_POST['confirm_email'] );
                
                /*encriptar contraseña nueva*/
                $password = password_hash($_POST['new_pass'], PASSWORD_BCRYPT); /*encripto contraseña*/
                $records1->bindParam(':pass',$password);             
                /* ------------- */
                $records1->execute();
                $results1 = $records1->fetch(PDO::FETCH_ASSOC);
             /*ya cambie la contrasena*/
             if($records1->execute()){
                        $mensaje = 'Successfully changed ';
                        sleep(3);
                        header('Location: /PHP-Login');
             }else{/*no hay suficientes datos*/
                 $mensaje = 'Sorry there must have been an error, please try again';
             }
                
         }
         
             
        
       
    }else{
         $mensaje = 'Complete your data';
     }
    
    /*if(!empty($_POST["email"])){
        $records = $conn->prepare('SELECT id FROM users WHERE email=:email');
        $records->bindParam(':email', $_POST['email']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        
    }*/


?>




<!DOCTYPE html>
<html>
    
    <head>
        <style type="text/css">  
            #box{
                  width: 480px;
                  height: 650px;              
                  border: 1px solid #c4c8ce;
                  border-radius: 8px;
                  margin: auto;            
            }
            #texto{
                width: 300px;
                
            }
            #linkLogin{
                color: dimgray;
            }

        </style>
        <link rel="stylesheet" href="asserts/css/style.css">
          <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    </head>
    
    <body>
       
        <div id="box"> <!--dentro de la caja-->
             <br>
             <br>
             <br>
             
             <img src="https://graffica.info/wp-content/uploads/2017/06/ColoresGoogleLogo.jpg" width="100" height="30">
             <br>
              <h1>Account recovery</h1>
              
   <?php if(empty($global)): ?>
              
              <h3 id=texto>Write your email: </h3>
              <form action="forgot_pass.php" method="post">
                  <input type="text" name="email" placeholder="Email">
                  <input type="submit" value="Send">
                  
              </form>
              
    <?php else: ?>
              
               <?php if($global == 1): ?>
                <!--si el correo si existe debo mandar la pregunta 1-->
                <h2>Answer the secutiry question:</h2>
                <br>
                <br>
                <h3>* Name of your best friend: </h3>
                <br>
                <br>
                  <form action="forgot_pass.php" method="post">
                  <input type="text" name="question_answer" placeholder="Question answer">
                  <input type="submit" value="Send">
                  
                  </form>
                <?php endif; ?>
                <?php if($global == 2): ?>
                <!--si el correo si existe debo mandar la pregunta 1-->
                <h2>Answer the secutiry question:</h2>
                <br>
                <br>
                <h3>* Name of your favorite pet </h3>
                <br>
                <br>
                <form action="forgot_pass.php" method="post">
                  <input type="text" name="question_answer" placeholder="Question answer">
                  <input type="submit" value="Send">
                  
                  </form>
                <?php endif; ?>
                <?php if($global == 3): ?>
                <!--si el correo si existe debo mandar la pregunta 1-->
                <h2>Answer the secutiry question:</h2>
                <br>
                <br>
                <h3>* Name of your first place of work </h3>
                <br>
                <br>
                <form action="forgot_pass.php" method="post">
                  <input type="text" name="question_answer" placeholder="Question answer">
                  <input type="submit" value="Send">
                  
                  </form>
                
                <?php endif; ?>
                
                <?php if($global == 4):?>
                <h2>Confirm your email</h2>
                <br>
                <br>
                <form action="forgot_pass.php" method="post">
                 <input type="text" name="confirm_email" placeholder="Confirm email">
                 <br>
                 <br>
                 <h2>Write your new password</h2>
                 <br>
                 <br>
                  <input type="password" name="new_pass" placeholder="New password">
                  <input type="submit" value="Send">
                  
                  </form>
                
                
                <?php endif; ?>
                
         <?php endif; ?>      
            
            <br>
            <br>
        <?php if(!empty($mensaje)):?> <!--si el mensaje no esta vacio-->
        <p> <?= $mensaje ?></p>

        <?php endif;?> 
        
           <br>
           <br>
           <a href="index.php" id=linkLogin>Login</a>   
        </div>
        
    </body>
</html>