<?php

require_once "./Model/Prod.php";
include_once "./Model/Cust.php";
include_once "./Model/transac.php";
include_once "./Model/Saless.php";
include_once "./Model/User.php";
include_once "./Model/Request.php";
$cus = new Cust();
$prod = new Prod();
$trans = new transac();
$sales = new Saless();
$user = new User();
$request = new Request();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {




    if ($_POST['action'] === "getProduct") {

        $prod->id = $_POST['id'];
        $r = $prod->getSingleProd();

        echo json_encode($r);
    }

    if ($_POST['action'] === "saveTransac") {

        foreach ($_POST['formDataArray'] as $formData) {
            parse_str($formData, $formDataArray); // Convert query string to associative array
    
            // Check if required fields exist
            if (isset($formDataArray['prod_id']) 
            && isset($formDataArray['cus_id'])
            && isset($formDataArray['user_id'])
            && isset($formDataArray['tCode'])
            && isset($formDataArray['total_price'])
            && isset($formDataArray['onhand'])
            && isset($_POST['pay'])
             && isset($_POST['totalPur'])
             && isset($formDataArray['price'])
            ) {
                // Extract values from $formDataArray
                $prod_id = $formDataArray['prod_id'];
                $cus_id = $formDataArray['cus_id'];
                $user_id = $formDataArray['user_id'];
                $trans_code = $formDataArray['tCode'];
                $sub_price = $formDataArray['total_price'];
                $prod_quantity = $formDataArray['onhand'];
                $price = $formDataArray['price'];
                

                $sales->prod_id = $prod_id;
                $sales->cus_id = $cus_id;
                $sales->trans_code = $trans_code;
                $sales->sub_price = $sub_price;
                $sales->total_quan = $prod_quantity;
                $sales->user_id = $user_id;
                $sales->request_type = "Available";
                $sales->payment = $_POST['pay'];
                $sales->total_prices = $_POST['totalPur'];
                $sales->prices = $price;
                $sales->insertData();
                $sales->updateType();
                $sales->updateProduct();
            } else {
                // Handle error if required fields are missing
                echo "Error: Missing required fields.";
            }
        }


    }

    if ($_POST['action'] === "saveRequest") {



        foreach ($_POST['formDataArray'] as $formData) {
            parse_str($formData, $formDataArray); // Convert query string to associative array
    
            // Check if required fields exist
            if (isset($formDataArray['prod_id']) 
            && isset($formDataArray['cus_id'])
            && isset($formDataArray['tCode'])
            && isset($formDataArray['subQuan'])
            && isset($formDataArray['user_id'])
            ) {
                // Extract values from $formDataArray
                $prod_id = $formDataArray['prod_id'];
                $cus_id = $formDataArray['cus_id'];
                $prod_code = $formDataArray['tCode'];
                $prod_quantity = $formDataArray['subQuan'];
                $user_id = $formDataArray['user_id']
                ;

    
                // Perform insert operation for each set of data
                $request->prod_id = $prod_id;
                $request->staff_id = $cus_id;
                $request->request_code = $prod_code;
                $request->total_quan = $prod_quantity;
                $request->user_id = $user_id;
                $request->insertDataHistory();
            } else {
                // Handle error if required fields are missing
                echo "Error: Missing required fields.";
            }
        }
    }

    if ($_POST['action'] === "upQuan") {


        $sales->total_quan = $_POST['quan'];
        $sales->sub_price = $_POST['price'];
        $sales->prod_id = $_POST['id'];
        $sales->updateProduct();
       
    }

    if ($_POST['action'] === "updateToZero") {

        $sales->prod_id = $_POST['id'];
        $sales->updateToZero();
       
    }

    if ($_POST['action'] === "getCodeme") {


        $trans->code = $_POST['code'];
        $trans->getCode();
    }






    if ($_POST['action'] === 'getId') {

        $prod->id = $_POST['ids'];
        $result = $prod->getSingleProd();

        foreach ($result as $res) {
            extract($res);
          
            $div = '
               <form action="updates.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" value="' . $prod_id . '" name="id">
                            <div class="d-flex justify-content-center">
                            <img src="'. $prod_image .'" alt="" srcset="" style="width:150px; height:150px; border-radius:10%; ">
                            </div>
                           
                            <div class="form-floating mb-3 ">
                                <input type="text" class="form-control" id="floatingInput" value = "' . $prod_name . '" name = "prod">
                                <label for="floatingInput">Product Name:</label>
                            </div>
                            
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" placeholder="Input price here"  id="floatingInput" value = "' . $prod_price  . '" name ="price">
                                <label for="floatingInput">Price:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput"  placeholder="Input quantity here" value = "' . $prod_quan . '" name = "quan">
                                <label for="floatingInput">Quantity:</label>
                            </div>
                            <div class="form-floating">
                                <input class="form-control" id="floatingInput" name="desc" value = "' . $prod_desc . '"></input>
                                <label for="floatingInput">Description</label>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name = "save">Save</button>
                        </div>
                    </form>
            ';

            break;
        }

        echo $div;
    }

    if ($_POST['action'] === 'viewCust') {

        $cus->id = $_POST['ids'];
        $res = $cus->getSingleCus();


        foreach ($res as $result) {
            extract($result);

            $div = '
                <form action="updateCus.php" method="POST">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                             <input type="hidden" value="' . $cus_id . '" name="id">
                                <input type="text" class="form-control" id="floatingInput" value = "' . $cus_fname . '" name="cname">
                                <label for="floatingInput">Customer Name:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" value = "' . $cus_lname . '" name="lname">
                                <label for="floatingInput">Last Name:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" value = "' . $cus_phone . '" name="phone">
                                <label for="floatingInput">Phone number:</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="save">Save Changes</button>
                        </div>
                    </form>
            ';

            break;
        }

        echo $div;
    }


    if ($_POST['action'] === 'viewUser') {
        $user->id = $_POST['ids'];
        $currentUser = $_POST['currentUser'];
        $res = $user->getSingleUser();
    
        foreach ($res as $result) {
            extract($result);
    
            $div = '
                <form action="updateUser.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="' . $user_id . '">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" value="' . $username . '" name="user">
                            <label for="floatingInput">Account Name:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" value="' . $user_fname . '" name="name">
                            <label for="floatingInput">FirstName:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" value="' . $user_lname . '" name="lname">
                            <label for="floatingInput">LastName:</label>
                        </div>';
    
            // Conditionally display the password field based on the comparison
            if ($currentUser == $user_id) {
                $div .= '
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingInput" value="' . $user_pass . '" name="pass">
                            <label for="floatingInput">New Password:</label>
                        </div>';
            }
    
            $div .= '
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="save">Save</button>
                    </div>
                </form>';
    
            break;
        }
    
        echo $div;
    }

    if ($_POST['action'] === 'viewUser1') {
        $user->id = $_POST['ids'];
    
        $res = $user->getSingleUser();
    
        foreach ($res as $result) {
            extract($result);
    
            $div = '
    <form action="updateUser.php" method="POST">
        <div class="modal-body">
            <input type="hidden" name="id" value="' . $user_id . '">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="' . $username . '" name="user">
                <label for="floatingInput">Account Name:</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="' . $user_fname . '" name="name">
                <label for="floatingInput">FirstName:</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="' . $user_lname . '" name="lname">
                <label for="floatingInput">LastName:</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingInput" value="' . $user_pass . '" name="pass">
                <label for="floatingInput">New Password:</label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="save">Save</button>
        </div>
    </form>';

    
            break;
        }
    
        echo $div;
    }
    
}
