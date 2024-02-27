



<?php
include_once "./Database/Database.php";

class Request extends Database
{

    public $prod_id;
    public $staff_id;
    public $sub_price;
    public $total_quan;
    public $request_code;
    public $table = "request_history";
    public $id;
    public $request_type = "Pending";
    public $user_id;
    public $code;





    public function insertData()
    {
        try {
            $sql = "INSERT INTO " . $this->table . " (prod_id, staff_id, request_code, quantity, sub_price, created_at)
                    VALUES (:prod_id, :staff_id, :request_code, :quantity, :sub_price, NOW())";
            $stmt = $this->getConnect()->prepare($sql);
    
            $stmt->bindParam(":prod_id", $this->prod_id);
            $stmt->bindParam(":staff_id", $this->staff_id);
            $stmt->bindParam(":request_code", $this->request_code);
            $stmt->bindParam(":quantity", $this->total_quan);
            $stmt->bindParam(":sub_price", $this->sub_price);
    
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

    public function insertDataHistory()
    {
        try {
            $sql = "INSERT INTO request_product (employee_id, prod_id, quantity, staff_id, request_code, request_type, created_at)
                    VALUES (:employee_id, :prod_id, :quantity, :staff_id, :request_code, :request_type , NOW())";
            $stmt = $this->getConnect()->prepare($sql);
    
            $stmt->bindParam(":employee_id", $this->user_id);
            $stmt->bindParam(":prod_id", $this->prod_id);
            $stmt->bindParam(":quantity", $this->total_quan);
            $stmt->bindParam(":staff_id", $this->staff_id);
            $stmt->bindParam(":request_code", $this->request_code);
            $stmt->bindParam(":request_type", $this->request_type);
        
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
    

    public function showHistoryRecord()
    {
        $sql = "
            SELECT 
                c.request_code AS requestCode,
                t.username AS staff,
                COUNT(c.prod_id) AS total_quan,
                c.request_type,
                c.created_at
            FROM 
                request_product c 
            INNER JOIN 
                user_account t ON c.employee_id = t.user_id 
            GROUP BY 
                c.request_code, t.username
            ORDER BY 
                c.request_code DESC
        ";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    

    public function showTrans()
    {
        try {
            $sql = "SELECT * FROM request_product";
            $stmt = $this->getConnect()->prepare($sql);
            $stmt->execute();   
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Error in showTrans(): " . $e->getMessage(), 0);
            // Return an error message or an empty array
            return array(); // Or return an error message like: return array('error' => 'Failed to retrieve data');
        }
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
        $sql = "select sum(sub_price) as total_price, sum(t.quantity) as total_quan from request_history t inner join product p on t.prod_id = p.prod_id where request_code = :request_code";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":request_code", $this->request_code);
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
    $sql = "UPDATE product SET prod_quan = :prod_quan, prod_price = :prod_price WHERE prod_id = :prod_id";
    $stmt = $this->getConnect()->prepare($sql);
    $stmt->bindParam(":prod_quan", $this->total_quan);
    $stmt->bindParam(":prod_price", $this->sub_price);
    $stmt->bindParam(":prod_id", $this->prod_id);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;  // Add this line to handle the case where the execution fails
    }
}
public function showTransaction()
{
    $sql = "
    SELECT  
        c.username AS username,
        p.prod_name AS productName,
        t.quantity AS quantity,
        c.user_phone,
        t.request_code AS requestCode,
        t.request_type AS request_type,
        (SELECT username FROM user_account WHERE user_id = t.staff_id) AS staff_username,
        t.created_at AS created_at
    FROM 
        request_product t 
    INNER JOIN 
        product p ON t.prod_id = p.prod_id 
    JOIN 
        user_account c ON t.employee_id = c.user_id 
    WHERE 
        t.request_code = :request_code";
    
    $stmt = $this->getConnect()->prepare($sql);
    $stmt->bindParam(":request_code", $this->code);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
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
        $sql = "select * from request_history where prod_id = :prod_id and request_code = :request_code";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":prod_id", $this->prod_id);
        $stmt->bindParam(":request_code", $this->request_code);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }

    public function getAllPendings()
    {
        $sql = "SELECT COUNT(*) AS total_count FROM request_product where request_type = 'Pending'";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}








?>

