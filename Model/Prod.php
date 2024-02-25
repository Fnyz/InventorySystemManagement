



<?php
include_once "./Database/Database.php";

class Prod extends Database
{

    public $prod;
    public $price;
    public $desc;
    public $quantity;
    public $id;
    public $image;
    public $table = "product";





    public function insertItem()
    {


        $sql = "INSERT INTO " . $this->table . " (prod_name,prod_image, prod_price, prod_quan, prod_desc, prod_created_at, prod_updated_at)
        VALUES (:prod_name,:prod_image, :prod_price, :prod_quan, :prod_desc, now(), now())";
        $stmt = $this->getConnect()->prepare($sql);



        $stmt->bindParam(":prod_name", $this->prod);
        $stmt->bindParam(":prod_image", $this->image);
        $stmt->bindParam(":prod_price", $this->price);
        $stmt->bindParam(":prod_quan", $this->quantity);
        $stmt->bindParam(":prod_desc", $this->desc);


        if ($stmt->execute()) {

            return true;
        }
    }

    public function showProduct()
    {
        $sql = "SELECT * FROM " . $this->table . " order BY prod_created_at DESC";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    


    public function getSingleProd()
    {
        $sql = "select * from product where PROD_ID = :PROD_ID";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":PROD_ID", $this->id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateProds()
    {
        $sql = "UPDATE " . $this->table . " SET prod_name = :prod_name , prod_image = :prod_image, prod_price = :prod_price , prod_quan = :prod_quan , prod_desc = :prod_desc , prod_updated_at = now() WHERE prod_id= :prod_id ";
        $stmt = $this->getConnect()->prepare($sql);

        $stmt->bindParam(":prod_id", $this->id);
        $stmt->bindParam(":prod_name", $this->prod);
        $stmt->bindParam(":prod_image", $this->image);
        $stmt->bindParam(":prod_price", $this->price);
        $stmt->bindParam(":prod_quan", $this->quantity);
        $stmt->bindParam(":prod_desc", $this->desc);

        if ($stmt->execute()) {
            return true;
        }
    }
}








?>

