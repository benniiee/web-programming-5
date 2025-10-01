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
            else
            {
                $productObj->deleteProduct($id);
                header("Location: viewproduct.php");
            }
        }
        else
        {
            echo "<a href='viewproduct.php'>View Product</a>";
            exit("Product Not Found");
        }
    }

?>