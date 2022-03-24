
<!DOCTYPE html>
<html>

	<head>

		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<title>Register</title>
		<link rel="stylesheet" href="registration.css">

	</head>
	<body>

    <form action="register.php" method="POST" autocomplete="off">

	  <div class="imgcontainer">

        <img src="../images/pengpeng.png" alt="peng" class="pengpeng">

      </div>

      <div class="container">

        <input type="text" placeholder="Username" name="usrname" class="usrname" required></br>

      </div>

      <div class="container">

        <input type="password" placeholder="Password" name="pswd" class="pswd" required></br>

      </div>

      <div class="container">

	  	<input type="email" placeholder="Email" name="email" class="email" required>

      </div>

      <div class="container">
        
        <button type="submit" value="Register" class="regisbtn" href="register.php">Register</button>

      </div>

	</form>

	<form action="log_in.php">

	  <div class="container">
  
  		<button type="submit" value="Go Back" class="gbkbtn" href="log_in.php">Go Back</button>

	  </div>
	
	</form>

  </body>
  
</html>
