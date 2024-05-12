<?php
@include 'config.php';

// Add Product
if(isset($_POST['add_product'])){
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/'.$product_image;

    if(empty($product_name) || empty($product_price) || empty($product_image)){
        $message[] = 'Please fill out all fields';
    }else{
        $insert = "INSERT INTO products(name, price, image) VALUES('$product_name', '$product_price', '$product_image')";
        $upload = mysqli_query($conn,$insert);
        if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'New product added successfully';
        }else{
            $message[] = 'Could not add the product';
        }
    }
}

// Delete Product
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location:add_product.php');
    exit();
}

// Update Product
if(isset($_POST['update_product'])){
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_name'];
    $update_p_price = $_POST['update_p_price'];
    $update_p_image = $_FILES['update_p_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_p_image_folder = 'uploaded_img/'.$update_p_image;

    $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', price = '$update_p_price', image = '$update_p_image' WHERE id = '$update_p_id'");

    if($update_query){
        move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
        $message[] = 'Product updated successfully';
        header('location:add_product.php');
        exit();
    }else{
        $message[] = 'Product could not be updated';
        header('location:add_product.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>
   <style>
      body {
         font-family: Arial, sans-serif;
         background-color: #f4f4f4;
         margin: 0;
         padding: 0;
      }

      .container {
         max-width: 1200px;
         margin: 0 auto;
         padding: 20px;
      }

      .admin-product-form-container {
         background-color: #fff;
         padding: 20px;
         border-radius: 5px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .admin-product-form-container h3 {
         font-size: 24px;
         color: #333;
         margin-bottom: 20px;
         text-align: center;
      }

      .box {
         width: 100%;
         padding: 10px;
         margin-bottom: 20px;
         border: 1px solid #ccc;
         border-radius: 4px;
         box-sizing: border-box;
         font-size: 16px;
      }

      .btn {
         display: inline-block;
         width: 200px;
         padding: 10px;
         border: none;
         border-radius: 4px;
         background-color: #007bff;
         color: #fff;
         font-size: 16px;
         cursor: pointer;
         text-align: center;
      }
     .dbtn{
        display: inline-block;
         width: 180px;
         padding: 10px;
         border: none;
         border-radius: 4px;
         background-color: #007bff;
         color: #fff;
         font-size: 16px;
         cursor: pointer;
         text-align: center;
     }
      .btn:hover {
         background-color: #0056b3;
      }

      .message {
         display: block;
         background-color: #f8d7da;
         color: #721c24;
         padding: 10px;
         margin-bottom: 20px;
         border-radius: 4px;
      }

      .product-display {
         margin-top: 20px;
      }

      .product-display-table {
         width: 100%;
         border-collapse: collapse;
         background-color: #fff;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .product-display-table th,
      .product-display-table td {
         padding: 10px;
         border-bottom: 1px solid #ddd;
         text-align: left;
      }

      .product-display-table th {
         background-color: #f8f9fa;
         font-weight: bold;
      }

      .product-display-table tr:hover {
         background-color: #f2f2f2;
      }

      .product-display-table td img {
         max-width: 100px;
         height: auto;
      }

      .product-display-table td:last-child {
         text-align: center;
      }

      @media screen and (max-width: 600px) {
         .container {
            padding: 10px;
         }

         .admin-product-form-container {
            padding: 15px;
         }

         .box,
         .btn {
            font-size: 14px;
         }

         .product-display-table th,
         .product-display-table td {
            padding: 8px;
         }
      }
   </style>
</head>
<body>

<?php
// Display messages
if(isset($message)){
   foreach($message as $msg){
      echo '<span class="message">'.$msg.'</span>';
   }
}
?>

<div class="container">
   <div class="admin-product-form-container">
      <!-- Add Product Form -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
         <h3>Add a new product</h3>
         <input type="text" placeholder="Enter product name" name="product_name" class="box">
         <input type="number" placeholder="Enter product price" name="product_price" class="box">
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
         <input type="submit" class="btn" name="add_product" value="Add Product">
      </form>
   </div>

   <div class="product-display">
      <table class="product-display-table">
         <thead>
            <tr>
               <th>Product Image</th>
               <th>Product Name</th>
               <th>Product Price</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php 
            // Fetch products from the database
            $select = mysqli_query($conn, "SELECT * FROM products");
            while($row = mysqli_fetch_assoc($select)){ 
            ?>
            <tr>
               <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
               <td><?php echo $row['name']; ?></td>
               <td>Rs.<?php echo $row['price']; ?></td>
               <td>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="update_p_id" value="<?php echo $row['id']; ?>">
                     <input type="hidden" name="update_p_name" value="<?php echo $row['name']; ?>">
                     <input type="hidden" name="update_p_price" value="<?php echo $row['price']; ?>">
                     <input type="file" accept="image/png, image/jpeg, image/jpg" name="update_p_image" class="box">
                     <input type="submit" class="btn" name="update_product" value="Update">
                  </form>
                  <a href="add_product.php?delete=<?php echo $row['id']; ?>" class="dbtn">Delete</a>
               </td>
            </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>
</div>

</body>
</html>
