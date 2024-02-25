<?php
session_start();

include "./Model/Saless.php";
$sale = new Saless;
if (isset($_SESSION['adminId'])) {
    $sale->user_id = $_SESSION['adminId'];
    $r = $sale->userGet();
} 
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">


    <title>tinongBakery</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Moon+Dance&family=Nunito:wght@800&family=Playfair+Display:wght@500&family=Poppins:wght@300&display=swap" rel="stylesheet">

</head>

<body>



    <div class=" mw-100 d-flex justify-content-end p-2" style="border-bottom:2px solid gray; box-shadow:0px 0px 3px 0px;">

        <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i class="fa-solid fa-burger fs-2 text-secondary active"></i></i></button>
    </div>

    <div class="m-3 p-3 rounded" style="border:1px solid gray; height:100%;">




        <?php include './Database/dbconnect.php';

        $random_id = date('Ymd') . rand(10000, 99999);







        ?>
        <div class="container-fluid">
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text text-center text-success" style="font-family: 'Playfair Display', serif;">Request Product</h1>

                    </div>
                    <div class="card-body">




                        <form id="input_form">

                            <input  value="<?php echo $random_id ?>" id="codess" name="tCode" type="hidden" >


                            <div class="d-flex justify-content-first mb-3 flex-column" style="gap:10px;">
                                <label class="control-label">STAFF:</label>
                                <select name="cus_id" class="form-control text-center" style="width: 200px;" id="cus_id">
                                    <option value="0" selected="">-- Choose here --</option>
                                    <?php

                                    $customer = $conn->query("SELECT * FROM user_account where userType = 'Staff'");
                                    while ($row = $customer->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['user_id'] ?>"> <?php echo $row['username'] ?></option>

                                    <?php endwhile; ?>
                                </select>

                                <?php foreach ($r as $val) : extract($val) ?>
                                    <input type="hidden" value="<?php echo $user_id ?>" id="user_id" name="user_id">
                                    Employeer: <input class="form-control text-center" value="<?php echo $username; ?>" style="width: 200px;">
                                    </input>
                                <?php break;
                                endforeach; ?>
                            </div>



                            <table class=" table table-bordered mb-5" style="width:100%">
                                <thead>
                                    <tr>

                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>
                                            <select id="prod_id" class="form-control text-center" style="width: 200px;" name="prod_id" onchange="getProductName()">
                                                <option value="0" selected="">-- Choose here --</option>
                                                <?php

                                                $prod = $conn->query("SELECT * FROM product");
                                                while ($row = $prod->fetch_assoc()) :
                                                ?>
                                                    <option value="<?php echo $row['prod_id'] ?>"> <?php echo $row['prod_name'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </td>
                                        <td>
                                           
                                            <input type="text" class="form-control" onkeyup="mykey(this.value)" id="quan" name="subQuan">
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                <button type="button" class="btn btn-success" id="submit"><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </td>
                                    </tr>


                                </tbody>
                            </table>


                        </form>

                        <hr>
                        <div class="container-fluid ">
                            <table id="example" class="table-strip" style="width:100%">
                                <thead>
                                    <tr>

                                        <th>Product Name</th>
                                        <th>Total Quantity</th>
                                        <th>Total Price</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody id="apnd">



                                </tbody>
                            </table>




                            <div class="mt-5 d-flex justify-content-end" style="width: 100%;">


                                <table class=" table table-bordered" style="width:300px;">
                                    <thead>
                                        <tr>
                                        </tr>
                                    </thead>
                                    <tbody id="calcu">



                                    </tbody>
                                </table>


                            </div>

                            <form id="goToTransRe" action="Product.php" method="post">
                                <input type="hidden" value="<?php echo $random_id ?>" name="code">
                                <button type="submit" style="display: none;" class="btn btn-success" onclick="savePurchase()" id="savePur">Save Request</button>
                            </form>




                        </div>

                    </div>

                </div>









            </div>

        </div>
    </div>
    </div>





    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header ">
            <h5 class="offcanvas-title text text-center text-secondary" id="offcanvasWithBothOptionsLabel"><i class="fa-solid fa-bread-slice me-2"></i>TINONG's BAKERYSHOP</h5>
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
            <ul class="list-group">
                <li class="list-group-item "><a href="Dashboard.php" class="text text-secondary text-decoration-none"><i class="fa-solid fa-house-user me-2"></i>Home</a></li>
                <li class="list-group-item"><a href="Accounts.php" class="text text-secondary text-decoration-none"><i class="fa-solid fa-key me-2"></i> Registered Accounts</a></li>
                <li class="list-group-item"><a href="Customer.php" class="text text-secondary text-decoration-none"><i class="fa-solid fa-users me-2"></i>Customer</a></li>
                <li class="list-group-item"><a href="Product.php" class="text text-secondary text-decoration-none"><i class="fa-solid fa-cart-shopping me-2"></i>Product</a></li>
                <li class="list-group-item active"><a href="Sales.php" class="text text-white text-decoration-none"><i class="fa-brands fa-gg-circle me-2"></i>Sales</a></li>
                <li class="list-group-item "><a href="Transaction.php" class="text text-secondary text-decoration-none "><i class="fa-solid fa-money-bill-1-wave me-2"></i></i>Transactions</a></li>
                <li class="list-group-item "><a href="login.php" class="text text-secondary text-decoration-none "><i class="fa-solid fa-right-from-bracket me-2"></i></i>Log-Out</a></li>
            </ul>
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




            window.onbeforeunload();



        });

         // Define a global variable to store the product name
    var productName;

function getProductName() {
    // Get the selected option
    var selectElement = document.getElementById('prod_id');
    var selectedOption = selectElement.options[selectElement.selectedIndex];

    // Get the product name from the selected option
    productName = selectedOption.text;
    // You can now use the productName variable globally as needed

}







        window.onbeforeunload = function() {
            return "Are you sure you want to leave this page? Your changes will not be saved.";
        }


        function getData(id, callback) {
    $.ajax({
        type: "GET",
        url: "showData.php",
        success: function(response) {
            var result = response.find(res => parseInt(id) === parseInt(res.prod_id) && res.request_type === "Pending");
            callback(result);
        },
        error: function() {
            alert('Error');
        }
    });
}

// Example usage



        function getTOTAL(codes) {

            var code = codes;
            var mother = $('#calcu');

            $.ajax({
                type: "POST",
                url: "getRequestTotal.php",
                data: {
                    code: code,
                },
                success: function(response) {

                    setTimeout(function() {
                        mother.html(response);
                    }, 1);
                },
                error: function() {
                    alert('Error');
                }
            });


        }



        function SearchDataInsert() {

            var codes = $('#codess').val();
            var prodId = $('#prod_id').val();

            $.ajax({
                type: 'post',
                url: 'op.php',
                data: {
                    codes: codes,
                    prodId: prodId,
                    action: 'searchAvailable'

                },
                success: function(response) {
                    alert(response);


                },
                error: function() {
                    alert('Error!');
                }
            })
        }





        function dataUpdatequan() {

            var b = $('#total_quan').val();
            var id = $('#prod_id').val();

            $.ajax({
                type: 'post',
                url: 'op.php',
                data: {
                    quan: b,
                    id: id,
                    action: 'upQuan'

                },
                success: function(response) {


                },
                error: function() {
                    alert('Error!');
                }
            })
        }


// Initialize an array to store form data
var formDataArray = [];

$('#submit').on('click', function(event) {
    event.preventDefault();
 

  getData($('#prod_id').val(), function(result) {
    if (result) {
        alert("Item is already in a pending request , please add a new one!");
        return;
    }else{
 // Serialize the form data
 var formData = $('#input_form').serialize();

// Get the selected product name
var productName = $('#prod_id option:selected').text();

// Concatenate the product name with the serialized form data
formData += '&productName=' + encodeURIComponent(productName);

// Check if the same name already exists in the array
var existingIndex = formDataArray.findIndex(function(item) {
    return item.indexOf('prod_id=') !== -1 && item.split('prod_id=')[1].split('&')[0] === formData.split('prod_id=')[1].split('&')[0];
});

// If the same name exists, replace the existing entry
if (existingIndex !== -1) {
    formDataArray[existingIndex] = formData;
    alert("Item is already exist!");
} else {
    // If the same name does not exist, push new data to the array
    formDataArray.push(formData);
    displayFormData(formDataArray)
    $('#savePur').show();
  
}
    }
    
  });

   
});




function deleteData(id) {
    // Find the index of the item with the specified ID
    var indexToDelete = formDataArray.findIndex(function(item) {
        return item.indexOf('prod_id=' + id) !== -1;
    });

    // If the item is found, remove it from the array
    if (indexToDelete !== -1) {
        formDataArray.splice(indexToDelete, 1);
        console.log("Item with ID " + id + " removed from the array.");
    } else {
        console.log("Item with ID " + id + " not found in the array.");
    }

    // Log the array to see the updated data
    displayFormData(formDataArray);
    
}




function displayFormData(formDataArray) {
    var container = $('#apnd');
    container.empty(); // Clear previous content

    // Generate HTML markup for each item in the formDataArray and append it to the container
    formDataArray.forEach(function(formData) {
        var formDataHTML = generateFormDataHTML(formData);
        container.append(formDataHTML);
    });
}

function generateFormDataHTML(formData) {
    // Deserialize the form data
    var formDataArray = formData.split('&');
    var formDataObject = {};
    formDataArray.forEach(function(item) {
        var pair = item.split('=');
        formDataObject[pair[0]] = decodeURIComponent(pair[1] || '');
    });

    // Extract data from the formDataObject
    
    var prod_id = formDataObject['prod_id'];
    var prod_name = formDataObject['productName'];
    var quantity = formDataObject['subQuan'];


    var html = `
    <tr style="width: 100%;">
        <td>${prod_name}</td>
        <td>${quantity}</td>
        <td>
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-danger" onclick="deleteData(${prod_id})"><i class="fa-sharp fa-solid fa-xmark"></i></button>
            </div>
        </td>
    </tr>
`;

    return html;


}





        function getID(id) {

            var fill = $('#placehere');

            $.ajax({
                url: "op.php",
                type: "GET",
                data: {
                    ids: id,
                    action: 'getId'
                },
                success: function(data) {
                    fill.html(data);
                },

            });

        }


        $('#prod_id').change(function() {
            var $op = $('#prod_id option:selected').val();
            $('#total_quan').val("");
            $('#subQuan').val("");
            $('#total_price').val("");
            $.post('op.php', {
                id: $op,
                action: 'getProduct'
            }, function(data, status) {

                var datas = JSON.parse(data);
                datas.map(function(dt) {


                    if (!dt.prod_price) {
                        $('#price').prop("disabled", false);
                        $('#quan').val("");
                        $('#price').val("");
                        return;
                    }
                    $('#quan').val("");
                    $('#price').prop("disabled", true);
                    $('#price').val(dt.prod_price);





                })



            })





        })










        function mykey(value) {


            var $price = $('#price').val();
            var $total_quan = $('#onhand').val();


            var diff, prod;

            if (value != 0) {
                diff = parseInt($total_quan) - parseInt(value);
                prod = parseInt($price) * parseInt(value);
            }



            $('#total_quan').val(diff);
            $('#total_price').val(prod);






        }

        function mykey2(value) {


            var $price = $('#priceTotal').val();
            var $change = $('#change');


            var diff;

            if (value != 0) {
                diff = parseInt(value) - parseInt($price);
            }

            $change.val(diff);






        }


       



        function savePurchase() {


            $.ajax({
                url: "op.php",
                type: "post",
                data: {
                    formDataArray,
                    action: 'saveRequest'
                },
                success: function(response) {
                    setTimeout(function() {

                        alert('Requested product is successfully save!');

                    }, 1);

                },
                error: function() {
                    alert('Error!');
                }



            });


        }


        function DeletMe(id) {
            var transss = $('#transactView');
            $.ajax({
                type: "POST",
                url: "deleteTrans.php",
                data: {
                    id: id,
                },
                success: function(response) {
                  
                    setTimeout(function() {
                        getData();

                    }, 1);



                },
                error: function() {
                    alert('Error');
                }
            });

        }
    </script>

</body>

</html>