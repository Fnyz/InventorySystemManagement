



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
        select s.username, p.prod_name, t.sub_quantity, p.prod_price, t.sub_price, c.cus_fname, c.cus_phone, t.trans_code,
t.created_date from trans_history t inner join product p on t.prod_id = p.prod_id join supplier
c on t.cus_id = c.cus_id join user_account s on t.user_id = s.user_id where t.trans_code = :trans_code
        
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
        
select t.transac_code, c.cus_fname, sum(t.transac_quan)as total_quan, t.transac_created_at from transactions t inner join supplier
c on t.cus_id = c.cus_id group by t.transac_code;
        
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
        $sql = "SELECT COUNT(*) AS total_count FROM transactions";
        $stmt = $this->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}











?>

