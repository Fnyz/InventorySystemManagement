



<?php
include_once "./Database/Database.php";

class Saless extends Database
{

    public $prod_id;
    public $cus_id;
    public $sub_price;
    public $total_quan;
    public $trans_code;
    public $table = "trans_history";
    public $id;
    public $user_id;
    public $request_type;
    public $payment;
    public $total_prices;
    public $prices;




    public function insertData()
    {
        try {
            $sql = "INSERT INTO " . $this->table . " (prod_id, cus_id, user_id, trans_code, sub_price, total_price, payment, sub_quantity, created_date)
                    VALUES (:prod_id, :cus_id, :user_id, :trans_code, :sub_price, :total_price, :payment , :sub_quantity,  NOW())";
            $stmt = $this->getConnect()->prepare($sql);
    
            $stmt->bindParam(":prod_id", $this->prod_id);
            $stmt->bindParam(":cus_id", $this->cus_id);
            $stmt->bindParam(":trans_code", $this->trans_code);
            $stmt->bindParam(":sub_price", $this->sub_price);
            $stmt->bindParam(":sub_quantity", $this->total_quan);
            $stmt->bindParam(":payment", $this->payment);
            $stmt->bindParam(":total_price", $this->total_prices);
            $stmt->bindParam(":user_id", $this->user_id);
    
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Log or handle the error appropriately
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function showTrans()
    {
        $sql = "select * from trans_history t inner join product p on t.prod_id = p.prod_id where trans_code = :trans_code";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":trans_code", $this->trans_code);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function userGet()
    {
        $sql = "select * from user_account where user_id = :user_id";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function totalPrice()
    {
        $sql = "select sum(sub_price) as total_price, sum(t.sub_quantity) as total_quan from trans_history t inner join product p on t.prod_id = p.prod_id where trans_code = :trans_code";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":trans_code", $this->trans_code);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function deleteData()
    {
        $sql = "delete from trans_history where trans_id = :trans_id";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":trans_id", $this->id);
        if ($stmt->execute()) {
            return true;
        }
    }


    public function updateProduct()
    {
        // Get the current product quantity
        $currentQuantity = $this->getCurrentProductQuantity();
    
        // Calculate the new total quantity
        $newTotalQuantity = $currentQuantity + $this->total_quan;
    
        // Update the product with the new total quantity
        $sql = "UPDATE product SET prod_quan = :prod_quan WHERE prod_id = :prod_id";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":prod_quan", $newTotalQuantity);
        $stmt->bindParam(":prod_id", $this->prod_id);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Function to get the current product quantity
    private function getCurrentProductQuantity()
    {
        $sql = "SELECT prod_quan FROM product WHERE prod_id = :prod_id";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":prod_id", $this->prod_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['prod_quan'];
    }
    
public function updateType()
{
    $sql = "UPDATE request_product SET request_type = :request_type WHERE prod_id = :prod_id";
    $stmt = $this->getConnect()->prepare($sql);
    $stmt->bindParam(":request_type", $this->request_type);
    $stmt->bindParam(":prod_id", $this->prod_id);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;  // Add this line to handle the case where the execution fails
    }
}


public function updateToZero()
{
    $sql = "UPDATE product SET prod_quan = NULL, prod_price = NULL WHERE prod_id = :prod_id";
    $stmt = $this->getConnect()->prepare($sql);
    $stmt->bindParam(":prod_id", $this->prod_id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;  // Add this line to handle the case where the execution fails
    }
}



    public function searchDuplicate()
    {
        $sql = "select * from trans_history where prod_id = :prod_id and trans_code = :trans_code";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":prod_id", $this->prod_id);
        $stmt->bindParam(":trans_code", $this->trans_code);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }
}








?>

