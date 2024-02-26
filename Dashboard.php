<?php

require_once "./Model/transac.php";
require_once "./Model/Request.php";
$trans = new transac();
$request = new Request();
$sales = $trans->getAllProduct();
$transacs = $trans->getAllTotalTransactions();
$total = $request->getAllPendings();



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
        <?php
        session_start();

        include "./Model/Saless.php";
        $sale = new Saless;
        if (isset($_SESSION['adminId'])) {
            $sale->user_id = $_SESSION['adminId'];
            $r = $sale->userGet();
        } ?>

        <?php foreach ($r as $val) : extract($val) ?>
            <button class="btn btn-success btn-sm" style="outline: none; background:none; border:none;" data-bs-toggle="modal" data-bs-target="#edit"><i class="fa-solid fa-user-pen" style="color:blue; font-size:25px;" onclick="getID(<?php echo $user_id ?>)"></i></button>
        <?php break;
        endforeach; ?>
        <?php require_once "./dropModal.php" ?>
        <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i class="fa-solid fa-bars fs-2 text-secondary active"></i></button>
    </div>

   

    <div class="m-3 p-3 rounded" >

        <h1 class="text text-center mb-3 text-primary" style="font-family: 'Playfair Display', serif;">DASHBOARD</h1>
        
        <div class="col-md-3 gap-2 d-flex">
           

            <!-- Employee record -->
            <div class="col-md-12 mb-3 ">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-0">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ">Total Products</div>
                               
                                    <div class="h6 mb-0  text-gray-800">
                                        * <?php echo $sales["total_count"] ?>
                                     
                                        
                                        
                                </div>
                           
                            </div>
                            <div class="col-auto">
                            <i class="fa-solid fa-box fs-2 "></i>
                            </div>
                        </div>

                    </div>
                </div>

              
            </div>
          
            <?php if($userType === "Staff"): ?>
<div class="col-md-12 mb-3 ">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body ">
            <div class="row no-gutters align-items-center">
                <div class="col mr-0">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ">Transactions</div>
                    <div class="h6 mb-0  text-gray-800">
                        * <?php echo $transacs["total_count"] ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-receipt fs-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php elseif($userType === "Admin"): ?>
<div class="col-md-12 mb-3 ">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body ">
            <div class="row no-gutters align-items-center">
                <div class="col mr-0">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ">Transactions</div>
                    <div class="h6 mb-0  text-gray-800">
                        * <?php echo $transacs["total_count"] ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-receipt fs-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 mb-3 ">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body ">
            <div class="row no-gutters align-items-center">
                <div class="col mr-0">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ">Pending Request</div>
                    <div class="h6 mb-0  text-danger">
                        * <?php echo $total["total_count"] ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-spinner fs-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="col-md-12 mb-3 ">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body ">
            <div class="row no-gutters align-items-center">
                <div class="col mr-0">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ">Pending Request</div>
                    <div class="h6 mb-0  text-danger">
                        * <?php echo $total["total_count"] ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-spinner fs-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


            

        </div>


        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header ">
                <h5 class="offcanvas-title text text-center text-secondary" id="offcanvasWithBothOptionsLabel">INVENTORY MANAGEMENT SYSTEM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">



                <div class="card mb-3">
                    <div class="card-header">
                    </div>
                    <div class="card-body d-flex align-items-center flex-column">
                        <?php foreach ($r as $val) : extract($val) ?>
                                      <input class="form-control text-center" hidden id="idUser" value="<?php echo $user_id; ?>" style="width: 200px;">
                                        </input>
                            <h5 class="card-title" style="font-family: 'Playfair Display', serif;"> <i class="fa-sharp fa-solid fa-user me-2"></i>Welcome <?php echo $username ?></h5>

                        <?php break;
                        endforeach; ?>

                        <?php include_once "./dropModal.php"; ?>
                    </div>
                </div>

                <?php include_once "./links.php"; ?>
    
            </div>
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
            $(document).ready(function() {
                $('#example').DataTable({
                    select: true,
                    responsive: true,
                });


            });

            function getID(id) {
            
                var fill = $('#placeme');

                $.ajax({
                    url: "op.php",
                    type: "post",
                    data: {
                        ids: id,
                  
                        action: 'viewUser1'
                    },
                    success: function(data) {
                        fill.html(data);
                    },

                });

            }
        </script>

</body>

</html>