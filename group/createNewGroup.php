
<!DOCTYPE html>
<html>

	<head>

		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<title>New Group</title>
		<link rel="stylesheet" href="createNewGroup.css">

	</head>
	<body>

    <form action="makeNewGroup.php" method="post" autocomplete="off">

      <div class="imgcontainer">

        	<img src="../images/sportsballBanner.jpeg" alt="sportsballBanner" class="sportsballBanner">

      </div>

      <div class="container">

        	<input type="text" placeholder="Group Name" name="groupname" class="groupname" required></br>

      </div>

      <div class="container">

		<!--<label class="sportLabel">Group Sport: </label>-->

		<select class="dropdown" name="sport" id="sport">
            <option value="" disabled selected>Choose a Sport</option>
		    <option value="hockey">Hockey</option>
		    <option value="football">Football</option>
		    <option value="baseball">Baseball</option>
		    <option value="soccer">Soccer</option>
		    <option value="soccer">Basketball</option>
		</select>

      </div>

      <div class="container">

	  	<input type="text" placeholder="Maximum Group Size" name="maxGroupSize" class="maxGroupSize" required>

      </div>

      <div class="container">
        
        	<button type="submit" value="createGroup" class="createbtn" href="group.php">Create Group</button>

      </div>

	</form>

	<form action="group.php">

	  <div class="container">
  
  		<button type="submit" value="Cancel" class="cancelbtn" href="group.php">Cancel</button>

	  </div>
	
	</form>

  </body>
  
</html>
