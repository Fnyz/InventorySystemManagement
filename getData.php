<?php


require_once "./Model/Saless.php";
$sales = new Saless();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sales->trans_code = $_POST['id'];
    $r = $sales->showTrans();

   

    foreach ($r as $val) {
        extract($val);

        echo '    <tr style="width: 100%;">';
        echo '<td>' . $prod_name . '</td>';
        echo '<td>' . $sub_quantity . '</td>';
        echo '<td>₱' . $sub_price . '</td>';
        echo '<td>
        
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                <button type="button" class="btn btn-danger" onclick="DeletMe(' . $trans_id . ')"><i class="fa-sharp fa-solid fa-xmark" ></i></button>

       </div>
        
        </td>';
        echo '<tr>';
    }

    return $r;
}
