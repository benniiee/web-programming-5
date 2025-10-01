<?php

require_once "../classes/product.php";
$productObj = new Product();

$product = [];
$errors = [];
$id = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if (isset($_GET["id"]))
        {
            $id = trim(htmlspecialchars($_GET["id"]));
            $product = $productObj->fetchProduct($id);
            if (!$product)
            {
                echo "<a href='viewproduct.php'>View Product</a>";
                exit("Product Not Found");
            }
        }
        else
        {
            echo "<a href='viewproduct.php'>Check Product</a>";
            exit("Product Not Found");
        }
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $product["name"] = trim(htmlspecialchars($_POST["name"]));
        $product["category"] = trim(htmlspecialchars($_POST["category"]));
        $product["price"] = trim(htmlspecialchars($_POST["price"]));

        if (empty($product["name"]))
            $errors["name"] = "Product name is required";
        else if ($productObj->doesProductExist($product["name"], $_GET["id"]))
            $errors["name"] = "This book title already exists";

        if (empty($product["category"]))
            $errors["category"] = "Please select a category";
        
        if (empty($product["price"]) && $product["price"] != 0)
            $errors["price"] = "Price is required";
        else if (!is_numeric($product["price"]) || $product["price"] <= 0)
            $errors["price"] = "Price must be a number and greater than zero";
    
        if (empty(array_filter($errors)))
        {      
            $productObj->name = $product["name"];
            $productObj->category = $product["category"];
            $productObj->price = $product["price"];
            
            if ($productObj->editProduct($_GET["id"]))
                header("Location: viewproduct.php");
            else 
                echo "An error has occurred";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="editproduct.css">
</head>
<body>
    <div class="container">
        <div class="layout">
        <h1>Edit Product</h1>
        <form action="" method="post">
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" value="<?= $product["name"] ?? "" ?>">
            <p class="error"><?= $errors["name"] ?? "" ?></p>
            <label for="">Category</label>
            <select name="category" id="category">
                <option value="">--Select--</option>
                <option value="Home Appliance" <?= (isset($product["category"]) && $product["category"] == "Home Appliance") ? "selected" : ""; ?>>Home Appliance</option>
                <option value="Gadget" <?= (isset($product["category"]) && $product["category"] == "Gadget") ? "selected" : "" ?>>Gadget</option>
            </select>
            <p class="error"><?= $errors["category"] ?? "" ?></p>
            <label for="price">Price</label>
            <input type="text" name="price" id="price" value="<?= $product["price"] ?? "" ?>">
            <p class="error"><?= $errors["price"] ?? "" ?></p>
            <br>
            <input class="save" type="submit" value="Save Product Canges">
        </form>
        </div>
    </div>
</body>
</html>