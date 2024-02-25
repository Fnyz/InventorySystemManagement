<?php


require_once "./Model/Request.php";
$sales = new Request();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sales->request_code = $_POST['code'];
    $r = $sales->totalPrice();


    foreach ($r as $val) {
        extract($val);

        echo '<tr>';
        echo '
         <td>                                   
                                                Total Quantity: <input type="number" class="form-control text-end" id="allquan" disabled value="' . $total_quan . '">
                                                Total Price: <input type="text" class="form-control text-end" id="priceTotal" value="₱' . $total_price . '" disabled>
                                             
                                            </td>
        
        ';
        echo '</tr>';
    }
}
