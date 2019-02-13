<?php
    session_start();/*iniciar la sesion*/
    require 'database.php';

    if(isset($_SESSION['user_id'])){ /*si se inica la sesion*/
        $records= $conn->prepare(/*'SELECT id ,email, name, password, id_role FROM users WHERE id = :id'*/
        'SELECT u.email, CONCAT(u.name," ", u.lastname) as Uname, r.role_name FROM users u, account_role r WHERE u.id_role = r.id_role and u.id = :id');
        $records->bindParam(':id' , $_SESSION['user_id']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        
        $user = null;
        if(count($results) > 0)
        {
           $user = $results; 
        }
        
    } 
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
   
    
         <link rel="stylesheet" href="asserts/css/style.css">
        <meta charset= "utf-8">
        <style type="text/css"> 
            #welcome{
               padding-top: -px;
                text-align: center;
                font-size: 30px;
                color: black;
            }
            #logout{
                width: 190%;
                font-size: 20px;
                color:#1a75ff;  
            }
            #user_role{
                text-align: center;
                font-size: 15px;
                color:firebrick;
            }#box{
                  width: 480px;
                  height: 500px;              
                  border: 1px solid #c4c8ce;
                  border-radius: 8px;
                  margin: auto; 
                padding: 0px;
                
            }
            #email{
                padding-top: -px;
                text-align: center;
                font-size: 15px;
                color: black;
            }
        </style>
        
       </head>
       
       
      <body>
        
         <div id= logout>
         <a href="logout.php" >Logout</a>
         </div>
         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
         <div id="box"> <!--dentro de la caja-->
         <br>
         
         <h3 id=user_role><?= $user['role_name'] ?></h3>
         <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKJEvVxwRw6hl-_6KhsLSSHeaC6TFHQZKv0Hw6ABYuaRZh0ZO_"
          width="100"
          height="100">

          
         <?php if(!empty($user)): ?>

          <h1 id=welcome><?= $user['Uname'] ?></h1>
          <h1 id=email><?= $user['email'] ?> </h1> 
          <br>
          <br><br><br><br><br><br><br>
          <a href="change_pass.php" id= logout>Change password</a>
          
          <?php endif; ?>
          
          </div>
      </body>
     </html>