<?php

require_once "../classes/product.php";
$productObj = new Product();
$name = $category = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $name = isset($_GET["name"]) ? trim(htmlspecialchars($_GET["name"])) : "";
        $category = isset($_GET["category"]) ? trim(htmlspecialchars($_GET["category"])) : "";
    }
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Documents</title>
    <link rel="stylesheet" href="viewproduct.css">
</head>
<body>
    <div class="container">
        <div class="layout">
        <h1>List of Products</h1>
        <form action="" method="get">
            <label for="name">Search</label>
            <input type="text" name="name" value="<?= $name ?>">
            <select name="category" id="category">
                <option value="">--All--</option>
                <option value="Home Appliances" <?= ($category == "Home Appliances") ? "selected" : ""; ?>>Home Appliances</option>
                <option value="Gadget" <?= ($category == "Gadget") ? "selected" : "" ?>>Gadget</option>
            </select>
            <input type="submit" value="Search">
        </form>
        <br>
        <table>
            <tr>
                <th>No.</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Option</Option>
            </tr>
            <?php
            $counter = 1;
            foreach ($productObj->viewProduct($name, $category) as $product)
            {
                $message = "Do you wish to delete the product " . $product["name"] . "?";

                if ($product["deleted"])
                    continue;

            ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= $product["name"] ?></td>
                    <td><?= $product["category"] ?></td>
                    <td><?= number_format($product["price"], 2) ?></td>
                    <td>
                        <a class="table_edit" href="editproduct.php?id=<?= $product["id"] ?>">Edit</a>
                        <a class="table_delete" href="deleteproduct.php?id=<?= $product["id"] ?>" onclick="return confirm('<?= $message ?>')">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
        <button class="add"><a href="addproduct.php">Add Product</a></button><br>
        </div>
    </div>
    
</body>
</html>