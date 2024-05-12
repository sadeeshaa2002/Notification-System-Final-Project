<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Header with Cart Count</title>

   <style>

.header .flex .navbar a{
   margin-left: 2rem;
   font-size: 2rem;
   color:var(--white);
}

.header .flex .navbar a:hover{
   color:yellow;
}


  </style>
</head>
<body>

   <header class="header">
      <div class="flex">
         <!-- Navbar link -->
         <nav class="navbar">
            <a href="cart.php">View products</a>
         </nav>

         <?php

         $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
         $row_count = mysqli_num_rows($select_rows);
         ?>

         
         <a href="mycart.php" class="cart">My cart<span><?php echo $row_count; ?></span></a>
      </div>
   </header>



</body>
</html>
