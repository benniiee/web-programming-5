<?php

require_once "../classes/product.php";
$productObj = new Product();

$product = [];
$errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $product["name"] = trim(htmlspecialchars($_POST["name"]));
        $product["category"] = trim(htmlspecialchars($_POST["category"]));
        $product["price"] = trim(htmlspecialchars($_POST["price"]));

        if (empty($product["name"]))
            $errors["name"] = "Product name is required";

        if (empty($product["category"]))
            $errors["category"] = "Please select a category";
        
        if (empty($product["price"]) && $product["price"] != 0)
            $errors["price"] = "Price is required";
        else if (!is_numeric($product["price"]) || $product["price"] <= 0)
            $errors["price"] = "Price must be a number and greater than zero";
        
        // check for a existing book title
        if ($productObj->doesProductExist($product["name"]) && !$productObj->isProductDeleted($product["name"]))
            $errors["name"] = "This book already exists in the database";

        if (empty(array_filter($errors)))
        {      
            $productObj->name = $product["name"];
            $productObj->category = $product["category"];
            $productObj->price = $product["price"];

            if ($productObj->addProduct())
                header("Location: viewproduct.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="addproduct.css">
</head>
<body>
    <div class="container">
        <div class="layout">
        <h1>Add Product</h1>
        <form action="" method="post">
            <label for="">Field with <span>*</span> is required</label>
            <label for="name">Product Name <span>*</span></label>
            <input type="text" name="name" id="name" value="<?= $product["name"] ?? "" ?>">
            <p class="error"><?= $errors["name"] ?? "" ?></p>
            <label for="">Category <span>*</span></label>
            <select name="category" id="category">
                <option value="">--Select--</option>
                <option value="Home Appliances" <?= (isset($product["category"]) && $product["category"] == "Home Appliances") ? "selected" : ""; ?>>Home Appliances</option>
                <option value="Gadget" <?= (isset($product["category"]) && $product["category"] == "Gadget") ? "selected" : "" ?>>Gadget</option>
            </select>
            <p class="error"><?= $errors["category"] ?? "" ?></p>
            <label for="price">Price <span>*</span></label>
            <input type="text" name="price" id="price" value="<?= $product["price"] ?? "" ?>">
            <p class="error"><?= $errors["price"] ?? "" ?></p>
            <br>
            <input class="save" type="submit" value="Save Product">
        </form>
        <button class="check"><a href="viewproduct.php">Check Product</a></button>
        </div>
    </div>
</body>
</html>