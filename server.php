<?php


require_once "./Model/Saless.php";
$sales = new Saless();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
   
    $error = [];
    $success = '';
    $sales->prod_id = $_POST['prod_id'];
    $sales->trans_code = $_POST['tCode'];
    $r = $sales->searchDuplicate();
    if ($r > 0) {
        $error[] = "This product is already added!";
    } else {
        
        $sales->prod_id = $_POST['prod_id'];
        $sales->cus_id = $_POST['cus_id'];
        $sales->trans_code = $_POST['tCode'];
        $sales->sub_price = $_POST['total_price'];
        $sales->total_quan = $_POST['onhand'];
        $sales->user_id = $_POST['user_id'];
        $sales->insertData();

    }

    foreach ($error as $key => $value) {
        $response = array(
            'error' => $value,
        );
    }

    echo json_encode($response);
}
