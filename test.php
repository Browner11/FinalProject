<?php

  require('server.php');
  // gather all data from our book table

    $search = "%" . $_POST['search'] . "%";
    $genre = $_POST['searchgenre'];

 

 
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>

  <link rel="stylesheet" type="text/css" href="formstyle.css">
</head>
<body>  

  
  <?php include('nav.php'); ?>

  
  <h3>Search Results</h3>
  <?= $search ?>
  <?= $genre ?>

    
  </body>
</html>