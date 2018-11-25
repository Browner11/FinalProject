<?php
 
  $genreSearch = "SELECT * FROM genre";

  $genreSearchStatement = $db->prepare($genreSearch);
  $genreSearchStatement->execute();

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<img id="logo" src="images/Bookishly_logo.png" alt="Logo">
  <nav>    
    <ul>
      <li><a class="left" href="index.php">Home</a></li>
      <div class="dropdown">
      	<button class="dropbtn">Genres 
      	<i class="fa fa-angle-down"></i>
    	</button>
          	<div class="dropdownContent">
      		<ul>
      			<li><a href="search.php?Genre=AllGenres">All Genres</a></li>
      			<?php while($row = $genreSearchStatement->fetch()):?>
        		<li><a href="search.php?Genre=<?=$row['Genre'] ?>"><?=$row['Genre'] ?></a></li>
        		<?php endwhile ?> 
        	</ul>
      	</div>
  	  </div>
      
      <?php if(isset($_SESSION['login'])): ?>
      	<li><a class="left" href="newBook.php">New Book</a></li>
        <li class="right"><a href="index.php?logout='1'">Logout</a></li>
        <li class="welcome">Welcome, <?=$_SESSION['username'] ?></li>
      <?php else : ?>
        <li><a class="right" href="register.php">Register</a></li>
        <li><a class="right" href="login.php">Login</a></li>
 	  <?php endif ?>
 	  <form name="navsearch" id="navsearch" method="post" action="search.php" >
 	  	<select form="navsearch" id="searchgenre" name="searchgenre">
 	  			<option value="All Genres">All Genres</option>
				<?php while($row = $genreSearchStatement->fetch()):?>
                    <option value="<?= $row['Genre'] ?>">
                      <?= $row['Genre'] ?>
                    </option>
                <?php endwhile ?> 
		</select> 
	  	<input name="searchbar" id="searchbar" type="text" class="search" placeholder="What are you looking for?">	  
	  	<button name="search" id="search" type="submit">Search</button>
	  </form>
	  
    </ul>    
  </nav>  
</body>
</html>