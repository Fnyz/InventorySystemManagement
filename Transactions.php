<?php
session_start();

include "./Model/Saless.php";
$sale = new Saless;
if (isset($_SESSION['adminId'])) {
    $sale->user_id = $_SESSION['adminId'];
    $r = $sale->userGet();
} ?>


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

        <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i class="fa-solid fa-bars fs-2"></i></button>
    </div>

    <div class="m-3 p-3 rounded" style="border:1px solid gray; height:100%;">




        <?php include './Database/dbconnect.php';

        $random_id = date('Ymd') . rand(10000, 99999);







        ?>
        <div class="container-fluid">
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text text-center text-primary" style="font-family: 'Playfair Display', serif;">ORDER TRANSACTION</h1>

                    </div>
                    <div class="card-body">




                        <form id="input_form">

                            <input type="hidden" value="<?php echo $random_id ?>" id="codess" name="tCode">


                            <div class="d-flex justify-content-first mb-3 flex-column" style="gap:10px;">
                                <label class="control-label">SUPPLIER:</label>
                                <select name="cus_id" class="form-control text-center" style="width: 200px;" id="cus_id">
                                    <option value="0" selected="">-- Choose here --</option>
                                    <?php

                                    $customer = $conn->query("SELECT * FROM supplier");
                                    while ($row = $customer->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['cus_id'] ?>"> <?php echo $row['cus_fname'] ?></option>

                                    <?php endwhile; ?>
                                </select>

                                <?php foreach ($r as $val) : extract($val) ?>
                                    <input type="hidden" value="<?php echo $user_id ?>" id="user_id" name="user_id">
                                    <input class="form-control text-center" id="userType" type="hidden" value="<?php echo $userType; ?>" style="width: 200px;">
                                    </input>
                                    Encoder: <input class="form-control text-center" value="<?php echo $username; ?>" style="width: 200px;">
                                    </input>
                                  
                                <?php break;
                                endforeach; ?>
                            </div>



                            <table class=" table table-bordered mb-5" style="width:100%">
                                <thead>
                                    <tr>

                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Sub_total</th>
                                        <th></th>
                                      

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>
                                        <select id="prod_id" class="form-control text-center" style="width: 200px;" name="prod_id" onchange="getQuantity()">
                                        <option value="0" selected>-- Choose here --</option>
                                        <?php
                                        $prod = $conn->query("SELECT a.*, p.prod_name, p.prod_price, a.quantity
                                                                FROM request_product a 
                                                                INNER JOIN product p ON a.prod_id = p.prod_id 
                                                                WHERE request_type = 'Pending'");
                                        while ($row = $prod->fetch_assoc()) :
                                        ?>
                                            <option value="<?php echo $row['prod_id'] ?>" data-quantity="<?php echo $row['quantity'] ?>" data-price="<?php echo $row['prod_price'] ?>"> 
                                                <?php echo $row['prod_name'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>

                                        </td>

                                        <td><input type="text" class="form-control"  id="price" onkeyup="mykey(this.value)" name ="price"></td>
                                        <td><input type="text" class="form-control"  id="onhand" name="onhand" onkeyup="mykey(this.value)"  ></td>
                                        <td><input type="text" class="form-control"  id="total_price" name="total_price"  ></td>
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

                         
                            <form id="goToTransRe" action="transactionRecord.php?" >
                                <input type="hidden" value="<?php echo $random_id ?>" name="code">
                                <label id="paylabel" style="margin-bottom:5px; display: none; color:blue; font-weight:bold;">Input Payment Amount: </label>
                                <input type="text" class="form-control" placeholder="Input payment here..."  id="payment" style="margin-bottom:20px; display: none; border: 1px solid gray;">
                                <button type="submit" style="display: none;" class="btn btn-success" onclick="savePurchase()" id="savePur" >Save Purchase</button>
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
            <?php $path = "Transactions" ?>
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




            window.onbeforeunload();



        });





      let prodId;

        window.onbeforeunload = function() {
            return "Are you sure you want to leave this page? Your changes will not be saved.";
        }


        function getData() {

            var code = $('#codess').val();
            var mother = $('#apnd');

            


            $.ajax({
                type: "POST",
                url: "getdata.php",
                data: {
                    id: code,
                },
                success: function(response) {
                
                    setTimeout(function() {

                        mother.html(response);
                        

                      



                    }, 1);
                    $('#savePur').show();

                    getTOTAL(code);
                },
                error: function() {
                    alert('Error');
                }
            });


        }


        function getTOTAL(codes) {

            var code = codes;
            var mother = $('#calcu');

            $.ajax({
                type: "POST",
                url: "getTotal.php",
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

            var b = $('#onhand').val();
            var d = $('#price').val();
            var id = $('#prod_id').val();
            prodId = id;
       
            $.ajax({
                type: 'post',
                url: 'op.php',
                data: {
                    quan: b,
                    price:d,
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

        function dataUpdatequan1(id) {


$.ajax({
    type: 'post',
    url: 'op.php',
    data: {
    
        id: prodId,
        action: 'updateToZero'

    },
    success: function(response) {


    },
    error: function() {
        alert('Error!');
    }
})
}



        var productName;

        function getQuantity() {
    var selectElement = document.getElementById('prod_id');
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var productId = selectedOption.value;
    var productName = selectedOption.text;
    var quantity = selectedOption.getAttribute('data-quantity');
    var price = selectedOption.getAttribute('data-price');
    var totalPrice = quantity * parseFloat(price);
    $('#onhand').val(parseInt(quantity));
    $('#price').val(!price ? 0.00 : parseFloat(price).toFixed(2)); // Set the price in the price input field
    $('#total_price').val(!totalPrice ? 0.00 : totalPrice.toFixed(2)); // Clear the total price field
}


var formDataArray = [];
var totalPrices;

$('#submit').on('click', function(event) {
    event.preventDefault();

    const pr = $('#price').val();
   

    if(parseInt(pr) === 0 ) {
        alert("Please provide price of the product!")
        return;
    }
    
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
        displayFormData(formDataArray);
        $('#savePur').show();
        $('#payment').show();
        $('#paylabel').show();
        
        console.log($('#input_form').serialize());
    }
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

    // Initialize total price variable
    var totalPrice = 0;

    // Generate HTML markup for each item in the formDataArray and calculate total price
    formDataArray.forEach(function(formData) {
        var formDataHTML = generateFormDataHTML(formData);
        container.append(formDataHTML);

        // Extract price from formData and add it to the total price
        var price = parseFloat(formData.split('&').find(item => item.startsWith('total_price=')).split('=')[1]);
        totalPrice += price;
    });

     // Append total price to the container
     container.append('<p style="margin-top:10px; margin-left:10px;">Total Price: <span style="color: red; font-weight: bold;">$' + totalPrice.toFixed(2) + '</span></p>');

    totalPrices = totalPrice.toFixed(2);
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
    var quantity = formDataObject['onhand'];
    var price = formDataObject['total_price'];

    var html = `
    <tr style="width: 100%;">
        <td style= "color:#c0392b; font-weight:bold; text-decoration:uppercase;">${prod_name}</td>
        <td>${quantity}</td>
        <td>${price}</td>
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


     









        function mykey(value) {


            var $total_quan = $('#onhand').val();


            var diff, prod;

            if (value != 0) {
                prod = parseInt($total_quan) * parseInt(value);
            }


            $('#total_quan').val(diff);
            $('#total_price').val(prod);    


        }

        function mykey2(value) {


            var $price = $('#priceTotal').val().split("₱")[1];
            var $change = $('#change');


            var diff;

            if (value != 0) {
                diff = parseInt(value) - parseInt($price);
            }

            $change.val(diff);






        }


        




        function savePurchase() {

           const pay = $('#payment').val();
            console.log(pay, totalPrices)
           if(parseFloat(pay) < totalPrices){
            alert("Payment amount should not be below the total price.")
            return;
           }else{
            
                        $.ajax({
                url: "op.php",
                type: "post",
                data: {
                    formDataArray,
                    totalPur:totalPrices,
                    pay:pay,
                    action: 'saveTransac'
                },
                success: function(response) {



                    setTimeout(function() {

                        alert('Transaction is successfully save!');
                
                    

                    }, 1);

                },
                error: function() {
                    alert('Error!');
                }



            });
           }
            
            


        }







        function DeletMe(id) {
            dataUpdatequan1(id);

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