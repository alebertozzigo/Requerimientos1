<!--iniciar la sesion-->
   <?php
    session_start();/*iniciar la sesion*/
    require 'database.php';

    if(isset($_SESSION['user_id'])){ /*si se inica la sesion*/
        $records= $conn->prepare('SELECT id ,email, name, password FROM users WHERE id = :id');
        $records->bindParam(':id' , $_SESSION['user_id']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        
        $user = null;
        if(count($results) > 0)
        {
           $user = $results; 
        }
        /*si no estan vacios los espacios*/
        if(!empty($_POST['old_pass']) && !empty($_POST['new_pass'])
          && !empty($_POST['confirm_new_pass'])){
            
            /*encripto la vieja para comparar*/    
            if(password_verify($_POST['old_pass'],$results['password'])){
                /*si las contraseñas coinciden*/
                $records1= $conn->prepare('UPDATE `users` SET `password` = :pass WHERE `users`.`id` = :id');
                $records1->bindParam(':id' , $_SESSION['user_id']);
                
                /*encriptar contraseña nueva*/
                $password = password_hash($_POST['new_pass'], PASSWORD_BCRYPT); /*encripto contraseña*/
                $records1->bindParam(':pass',$password );             
                /* ------------- */
                $records1->execute();
                $results1 = $records1->fetch(PDO::FETCH_ASSOC);
                
                    if($records1->execute()){
                        $mensaje = 'Successfully changed ';
                    }else{/*no hay suficientes datos*/
                        $mensaje = 'Sorry there must have been an error, please try again';
                    }
                
            }else{
                $mensaje='You must give the correct password';
            }
            
        }else if(empty($_POST['old_pass']) && empty($_POST['new_pass'])
          && empty($_POST['confirm_new_pass'])){
            $mensaje='';
        }else{
            $mensaje='You must complete the data';
        }
    } 
?>
<!----------------------------------------------------------->
<!----------------------------------------------------------->
<!----------------------------------------------------------->

<!DOCTYPE html>
<html>
   <!--REGISTRO DE USUARIO-->
    <head>
        <link rel="stylesheet" href="asserts/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <style type="text/css">  
            #box{
                  width: 480px;
                  height: 800px;              
                  border: 1px solid #c4c8ce;
                  border-radius: 8px;
                  margin: auto;            
            }
            #old_password{
                width: 250px;
            }
            
        </style>
    </head>
    <body>

     <br>
     <br>
     <br>
     <br>
     
     <div id="box"> <!--dentro de la caja-->
         <br>
         <br>
         <br>
         <img src="https://graffica.info/wp-content/uploads/2017/06/ColoresGoogleLogo.jpg"
          width="100"
          height="30">
          <br>
          <br>
         <h3>Change your password</h3>
                 <!--mensaje de error o confirmacion de cambio-->
               
        <?php if(!empty($mensaje)): ?> <!--si el mensaje no esta vacio-->
                <p id="error"> <?= $mensaje ?></p>

        <?php endif;?>
        
          <!--sesion inciada-->
          <?php if(!empty($user)): ?>
          <br>User: <?= $user['name']?>
          <br>Email: <?= $user['email']?>
          <?php endif; ?>
               
        <h4 id=old_password>Old password:</h4>
        <form action="change_pass.php" method="post">
            <input type="password"  name="old_pass" placeholder="Old password" required> 
            <h4 id=old_password>New password:</h4>
            <input type="password"  name="new_pass" placeholder="New password" required>
            <h4 id=old_password>Confirm pass:</h4>
            <input type="password"  name="confirm_new_pass" placeholder="Confirm New password" required> 
            <input type="submit" value="Send">
        </form>
        <br>
        <br>
        <a href="login.php" id=linkLogin>Login Menu</a>
        
          
     </div>
    </body>
</html>