
<!DOCTYPE html>

<html>

  <head>

    <!-- link refrences -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
    <link rel="stylesheet" href="log_in.css">

    <!-- set title -->
    <title>Login</title>
	  
  </head>

  <body>
	  
    <!-- set form for logging in -->
    <form action="authentication.php" method="POST">

      <div class="imgcontainer">

        <img src="../images/sportsball.png" alt="Sportsball" class="sportsball">

      </div>
	    
      <!-- create username input box --> 
      <div class="container">

        <input type="text" placeholder="Username" name="usrname" class="usrname" required></br>

      </div>

      <!-- create password input box -->
      <div class="container">

        <input type="password" placeholder="Password" name="pswd" class="pswd" required>

      </div>

      <!-- create login button -->
      <div class="container">

        <button type="submit" value="Login">Login</button>

      </div>

    </form>

    <!-- set form for registering -->
    <form action="registration.php">

      <!-- create register button -->
      <div class="container">
	      
        <button type="submit" value="Register" class="regisbtn" href="registration.php">Register</button>

      </div>

    </form>

  </body>

</html>

