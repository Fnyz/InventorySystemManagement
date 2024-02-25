<?php


require_once "./Model/Saless.php";
$sales = new Saless();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sales->trans_code = $_POST['code'];
    $r = $sales->totalPrice();


    foreach ($r as $val) {
        extract($val);

        echo '<tr>';
        echo '
         <td>                                   
                                                Total Quantity: <input type="number" class="form-control text-end" id="allquan" disabled value="' . $total_quan . '">
                                                Payment: <input type="text" class="form-control text-end" onkeyup="mykey2(this.value)" id="payment" placeholder="payment">
                                                Total Price: <input type="text" class="form-control text-end" id="priceTotal" value="₱' . $total_price . '" disabled>
                                                Change: <input type="text" class="form-control text-end" id="change" disabled>

                                            </td>
        
        ';
        echo '</tr>';
    }
}
