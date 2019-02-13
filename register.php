

<?php
    /*DATOS HACIA LA BASE*/
    require 'database.php'; /*importo informacion de a base*/
    
    $mensaje = ''; /*var para imprimir error o aceptacion*/
    if(isset($_SESSION['user_id'])){
        session_unset();
        session_destroy();
    }
    session_start();
    
    /*verifico que no esten vacios*/
    if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['name']) && !empty($_POST['lastname']) && !empty($_POST['confirm_password']) && !empty($_POST['question_answer']) ){
        
        /*VEO SI EL CORREO YA EXISTE*/
         $statement = $conn->prepare('SELECT id FROM users WHERE email=:email');
        $statement->bindParam(':email', $_POST['email']);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
   if($resultado == 0){ 
            /*si no existe ese correo lo puedo usar*/
              $mensaje = '';
        
        if($_POST['password']==$_POST['confirm_password']   &&  strlen($_POST['password']) > 8){
            $sql = "INSERT INTO users (email ,password ,name ,lastname , question_number, question_answer ) VALUES (:email, :password, :name, :lastname, :question_number, :question_answer)"; 
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':lastname', $_POST['lastname']);
            $stmt->bindParam(':question_number', $_POST['question_number']);
            $stmt->bindParam(':question_answer', $_POST['question_answer']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT); /*encripto contraseña*/
            $stmt->bindParam(':password',$password );

            /*no estan vacios los datos*/
            if($stmt->execute()){
                $mensaje = 'Successfully created new user';

                /*En caso de usuario creado, entrar a la sesion de una vez*/
                $records = $conn->prepare('SELECT id FROM users WHERE email=:email');
                $records->bindParam(':email', $_POST['email']);
                $records->execute();
                $results = $records->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $results['id'];
                /*una vez que inicio sesion lo redirijo a otra pagina*/
                header('Location: /PHP-Login/login.php');
            }else{/*no hay suficientes datos*/
                $mensaje = 'Sorry there must have been an error creating your account, please try again.';
            }
        }else{
            $mensaje="The password is wrong.";
        }
       
     }else{
     $mensaje = "The email is already in use" ; 
    }
        
      
      
    }else{
        $mensaje='Complete the data.';
    }

?>


<!DOCTYPE html>
<html>
   <!--REGISTRO DE USUARIO-->
    <head>
        <link rel="stylesheet" href="asserts/css/style.css" type="text/css" >
          
           <style type="text/css">  
            #box{
                  width: 480px;
                  height: 835px;              
                  border: 1px solid #c4c8ce;
                  border-radius: 8px;
                  margin: auto;            
            }
            #security_question{
               text-align: center;
               width: 500px;
               
            }
            #question{
                 width: 300px; 
                padding: 20px;
            }
            #texto1{
                  width: 300px;
            }
           #mensaje{
                 color: blue;
                 font-size: 25px;
                 
               }   
            
            
        </style>
    </head>
    <body>
         
        
         <br>
         <br>
         <br>
         <br>
          
        
        
        
        <span>or <a href="index.php">Login</a></span>
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
      <br>
      
      
      <div id="box">
         <br>
         <br>
         <br>
         <img src="https://graffica.info/wp-content/uploads/2017/06/ColoresGoogleLogo.jpg"
          width="100"
          height="30">
             
         <br>
         <h3>Create your Google Account</h3>
          
              <?php if(!empty($mensaje) ): ?> <!--si el mensaje no esta vacio-->
                <p id=mensaje> <?= $mensaje ?></p>

                <?php endif;?>
           
           <!--formulario de registro-->
           <form action="register.php" method="post">
            
            <input type="text"  name="name" placeholder="Name">
            <input type="text"  name="lastname" placeholder="Lastname">
            <input type="text"  name="email" placeholder="Enter your mail">
            <input type="password" name="password" placeholder="Enter your password">
            <input type="password" name="confirm_password" placeholder="Confirm your password">
            
            <!--pregunta seguridad-->
            <h3 id=texto1>Security question : </h3>
            <p id=security_question >
            
              
               
                <input type="radio" name="question_number" value="1">Name of your best friend

                <br>
                <br>

                <input type="radio" name="question_number" value="2">Name of your favorite pet

                <br>
                <br>

                <input type="radio" name="question_number" value="3">Name of your first place of work
                </p>                
                
            <input id=question type="text"  name="question_answer" placeholder="Security Question answer">
            <!--boton de enviar datos-->
            <input type="submit" value="Send">
            
            
               
            
        </form>  <!––Address to send the data of the form, in this case login.php––>
         
        
        </div>
    </body>
</html>