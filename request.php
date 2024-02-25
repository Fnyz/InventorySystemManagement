<?php


require_once "./Model/Request.php";
$sales = new Request();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
   
    $error = [];
    $success = '';
    $sales->prod_id = $_POST['prod_id'];
    $sales->request_code = $_POST['tCode'];
    $r = $sales->searchDuplicate();
    if ($r > 0) {
        $error[] = "This product is already added!";
    } else {
      
        $sales->prod_id = $_POST['prod_id'];
        $sales->staff_id = $_POST['cus_id'];
        $sales->request_code = $_POST['tCode'];
        $sales->sub_price = $_POST['tPrice'];
        $sales->total_quan = $_POST['subQuan'];
        $sales->insertData();
    }

    foreach ($error as $key => $value) {
        $response = array(
            'error' => $value,
        );
    }

  
}
