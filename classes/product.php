<?php

require_once "databases.php";

class Product extends Database
{
    public $name = "";
    public $category = "";
    public $price = "";
    public $deleted = "";

    public function addProduct()
    {
        $sql = "INSERT INTO product (name, category, price) VALUE (:name, :category, :price)";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":name", $this->name);
        $query->bindParam(":category", $this->category);
        $query->bindParam(":price", $this->price);

        return $query->execute();
    }

    public function viewProduct($name="", $category="")
    {
        $sql = "SELECT * from product WHERE name LIKE CONCAT('%', :name, '%') AND category LIKE CONCAT('%', :category, '%') ORDER BY name ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":name", $name);
        $query->bindParam(":category", $category);

        if ($query->execute())
            return $query->fetchAll();
        else
            return null;
    }

    public function doesProductExist($name, $id="")
    {
        // count how many book title exist in the database from the given name
        $sql = "SELECT COUNT(*) as total from product WHERE name = :name and id <> :id";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":name", $name);
        $query->bindParam(":id", $id);
        
        $book = [];

        // fetch the table column from the resulting query
        if ($query->execute())
            $book = $query->fetch();
        else
            return false;

        // returns true if a book exists, otherwise false
        return $book["total"] > 0 ? true : false;
    }

    public function isProductDeleted($name)
    {
        // count how many book title exist in the database from the given name
        $sql = "SELECT COUNT(*) as total_delete from product WHERE name = :name and deleted = 1";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":name", $name);
        
        $book = [];

        // fetch the table column from the resulting query
        if ($query->execute())
            $book = $query->fetch();
        else
            return false;

        // returns true if a book exists, otherwise false
        return $book["total_delete"] > 0 ? true : false;
    }

    public function fetchProduct($id)
    {
        $sql = "SELECT * FROM product WHERE id = :id";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":id", $id);
        
        if ($query->execute())
            return $query->fetch();
        else
            return null;
    }

    public function editProduct($pid)
    {
        $sql = "UPDATE product SET name=:name, category=:category, price=:price WHERE id=:id";
        
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":name", $this->name);
        $query->bindParam(":category", $this->category);
        $query->bindParam(":price", $this->price);
        $query->bindParam(":id", $pid);
        
        return $query->execute();
    }

    public function deleteProduct($id)
    {
        //$sql = "DELETE FROM product WHERE id = :id";
        // soft
        $sql = "UPDATE product SET deleted = 1 WHERE id = :id";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":id", $id);
        
        return $query->execute();
    }
}

//$obj = new Product();
//$obj->name = "TV XX1";
//$obj->category = "Home Appliance";
//$obj->price = 1200;
//var_dump($obj->addProduct());