



<?php
include_once "./Database/Database.php";

class transac extends Database
{

    public $code;
    public $trans_total;
    public $trans_quan;
    public $cus_id;
    public $trans_pay;
    public $table = "transactions";





    public function insertTransact()
    {


        $sql = "INSERT INTO " . $this->table . " (transac_code, transac_total, transac_quan, cus_id, transac_created_at, transac_updated_at, transac_payment)
        VALUES (:transac_code, :transac_total, :transac_quan, :cus_id, now(), now(), :transac_payment)";
        $stmt = $this->getConnect()->prepare($sql);



        $stmt->bindParam(":transac_code", $this->code);
        $stmt->bindParam(":transac_total", $this->trans_total);
        $stmt->bindParam(":transac_quan", $this->trans_quan);
        $stmt->bindParam(":cus_id", $this->cus_id);
        $stmt->bindParam(":transac_payment", $this->trans_pay);


        if ($stmt->execute()) {

            return true;
        }
    }

    public function showTransaction()
    {
        $sql = "
            SELECT 
                s.username, 
                p.prod_name, 
                t.sub_quantity, 
                p.prod_price, 
                t.sub_price, 
                c.cus_fname, 
                c.cus_phone, 
                t.trans_code,
                t.created_date 
            FROM 
                trans_history t 
            INNER JOIN 
                product p 
            ON 
                t.prod_id = p.prod_id 
            JOIN 
                supplier c 
            ON 
                t.cus_id = c.cus_id 
            JOIN 
                user_account s 
            ON 
                t.user_id = s.user_id 
            WHERE 
                t.trans_code = :trans_code;
        ";
    
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":trans_code", $this->code);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    

    public function getCode()
    {
        $sql = "select t.trans_code from trans_history t where t.trans_code = :trans_code
        ";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":trans_code", $this->code);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getCalculation()
    {
        $sql = "select t.payment , (t.payment - t.total_price) as total_change, t.total_price
from trans_history t where t.trans_code = :trans_code
        ";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->bindParam(":trans_code", $this->code);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function showTranss()
    {
        $sql = "
            SELECT 
                t.trans_code, 
                c.cus_fname, 
                count(t.prod_id) AS total_quan, 
                t.created_date 
            FROM 
                trans_history t 
            INNER JOIN 
                supplier c 
            ON 
                t.cus_id = c.cus_id 
            GROUP BY 
                t.trans_code;
        ";
    
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result;
    }
    

    public function sales()
    {
        $sql = "select sum(transac_total) as sales from transactions";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllProduct()
    {
        $sql = "SELECT COUNT(*) AS total_count FROM product";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllTotalTransactions()
    {
        $sql = "SELECT COUNT(*) AS total_count FROM trans_history";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}











?>

