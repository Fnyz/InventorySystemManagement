<?php

include_once "./Model/Cust.php";
include_once "./Model/transac.php";
include_once "./Model/Request.php";
$cus = new Cust();
$res = $cus->showCust();
$trans = new transac();
$request = new Request();




$request->code = $_GET['code'];
$result = $request->showTransaction();
$amount = $trans->getCalculation();





?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">


    <title>Inventory Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Moon+Dance&family=Nunito:wght@800&family=Playfair+Display:wght@500&family=Poppins:wght@300&display=swap" rel="stylesheet">

</head>

<body>



    <div class=" mw-100 d-flex justify-content-end p-2" style="border-bottom:2px solid gray; box-shadow:0px 0px 3px 0px;">


    </div>

    <div class="m-3 p-3 rounded" >





        <div>


            <div class="card shadow mb-4">

                <div class="card-body">
                    <?php foreach ($result as $val) : extract($val) ?>

                        <div class="form-group row text-left mb-0">
                            <div class="col-sm-9">
                                <h5 class="font-weight-bold">
                                    <h1 class="text text-start text-secondary" style="font-family: 'Playfair Display', serif;">Product Request</h1>
                                </h5>
                            </div>

                            <div class="col-sm-3 py-1">
                                <h6>
                                    Date: <?php echo $created_at ?>
                                </h6>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row text-left mb-0 py-2">
                            <div class="col-sm-4 py-1">
                                <h6 class="font-weight-bold">
                                    Employeer: <?php echo $username ?>
                                </h6>
                                <h6>
                                    Phone: <?php echo $user_phone ?>
                                </h6>
                            </div>
                            <div class="col-sm-4 py-1"></div>
                            <div class="col-sm-4 py-1">
                                <h6>
                                    Request Code # <?php echo $requestCode ?>
                                </h6>
                                <h6 class="font-weight-bold">
                                    Staff: <?php echo $staff_username ?>
                                </h6>
                                <h6>

                                </h6>
                            </div>
                        </div>

                    <?php break;
                    endforeach; ?>

                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Products</th>
                                <th width="8%">Qty</th>
                                <th width="20%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $val) : extract($val) ?>
                                <tr>
                                    <td style="color: #c0392b; font-weight:bold;"> <?php echo $productName ?></td>
                                    <td> <?php echo $quantity ?></td>
                                    <td style= "font-weight:bold; color: <?php echo $request_type === "Available" ? "blue" : "red";  ?>"><?php echo $request_type ?></td>
                                </tr>

                            <?php
                            endforeach; ?>
                        </tbody>
                    </table>


                    <?php foreach ($amount as $val) : extract($val) ?>
                        <div class="form-group row text-left mb-0 py-2">
                            <div class="col-sm-4 py-1"></div>
                            <div class="col-sm-3 py-1"></div>
                            <div class="col-sm-4 py-1">


                                <h4>
                                    Cash Amount: <b class="text text-danger"><?php echo $transac_payment ?></b>
                                </h4>
                                <table width="100%">
                                    <tr>
                                        <td class="font-weight-bold">Total: </td>
                                        <td class="font-weight-bold text-right text-primary">₱ <?php echo $transac_total ?></td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Change: </td>
                                        <td class="font-weight-bold text-right text-primary">₱ <?php echo $total_change ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-1 py-1"></div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>


            <a href="Request_history.php" class="text text-end btn btn-danger">Back</a>




        </div>









        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>


        <script src="./scripts/jquary-3.6.3.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>

        <script>

        </script>

</body>

</html>