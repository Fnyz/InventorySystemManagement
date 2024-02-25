<?php

include_once "./Model/Prod.php";
$prod = new Prod();
$prod = $prod->showProduct();





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


        <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i class="fa-solid fa-bars fs-2"></i></button>
    </div>

    <div class="m-3 p-3 rounded" style="border:1px solid gray; height:100%;">

        <h1 class="text text-center text-primary" style="font-family: 'Playfair Display', serif;">COMPUTER PRODUCTS</h1>
        <div class="mb-3">

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
                <i class="fa-solid fa-plus"></i>
            </button> <label for="" class="text text-primary fw-bold">ADD PRODUCT</label>
        </div>


        <div class="modal fade" id="addProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h1 class="modal-title fs-5 text text-white fw-bold text-uppercase" id="staticBackdropLabel" style="font-family: 'Playfair Display', serif; letter-spacing:2px; "><i class="fa-solid fa-cart-plus me-2"></i>New Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="insertProd.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="prod">
                        <label for="floatingInput">Product Name:</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" class="form-control" id="imageInput" name="image">
                        <label for="imageInput">Product Image:</label>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control" id="floatingTextarea" name="desc"></textarea>
                        <label for="floatingTextarea">Description</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



        <div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h1 class="modal-title fs-5 text text-white fw-bold text-uppercase" id="staticBackdropLabel" style="font-family: 'Playfair Display', serif; letter-spacing:2px; "><i class="fa-sharp fa-solid fa-pen-to-square me-2"></i>Edit Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div id="placehere">


                    </div>



                </div>
            </div>
        </div>

        <table id="example" class="table-strip" style="width:100%">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Description</th>
                    <th>Date Created</th>
                    <th>Action</th>
                
                    <th></th>

                </tr>
            </thead>
            <tbody>
                <?php
                usort($prod, function ($a, $b) {
                    return strtotime($b['prod_created_at']) - strtotime($a['prod_created_at']);
                });

                foreach ($prod as $val) : extract($val) 
                ?>
                    <tr>
                    <td>
                                <img src="<?php echo $prod_image ?>" alt="" srcset="" style="width:50px; height:50px; border-radius:10%;">
                            </td>
                        <td ><?php echo $prod_name ?></td>
                        <td><?php echo  !$prod_price ? "NULL" : $prod_price ?></td>
                        <td ><?php echo !$prod_quan ? "NULL" : $prod_quan ?></td>
                        <td><?php echo $prod_desc ?></td>
                        <td><?php echo $prod_created_at ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit" onclick="getID(<?php echo $prod_id ?>)"><i class="fa-regular fa-pen-to-square"></i></button>

                            </div>
                        </td>
                       

                        <td  style="color:<?php echo !$prod_price ? "red" : "blue  " ?>;  border: 1px;  height:10px " class="fw-semibold opacity-75"><?php echo !$prod_price ? "NOT AVAILABLE" : "AVAILABLE" ?></td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
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
                        <h5 class="card-title" style="font-family: 'Playfair Display', serif;"> <i class="fa-sharp fa-solid fa-user me-2"></i>Welcome <?php echo $username ?></h5>

                    <?php break;
                    endforeach; ?>
                     
                    <?php include_once "./dropModal.php"; ?>
                </div>
            </div>
            <?php $path = "Product" ?>
            <?php include "./links.php"; ?>
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
        
            var fill = $('#placehere');

            $.ajax({
                url: "op.php",
                type: "POST",
                data: {
                    ids: id,
                    action: 'getId'
                },
                success: function(data) {
                    fill.html(data);
                },

            });

        }
    </script>

</body>

</html>