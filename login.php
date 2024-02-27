<?php
session_start();
include_once './Database/Database.php';
require_once "./Model/User.php";
$user = new User();
$dt = new Database();
$conn = $dt->getConnect();
$acc = $user->showUserAdmin();

if (count($acc) == 1) {
    // If the array has more than 0 elements, hide the <select> element
    $hideAdminOption = true;
} else {
    // If the array has 0 elements, show the <select> element
    $hideAdminOption = false;
}



$message = [];
$user = $pass = "";
if ($_SERVER["REQUEST_METHOD"] == 'POST') {


    $user = $_POST['username'];
    $pass = $_POST['password'];

    $statement = $conn->prepare("SELECT * FROM user_account WHERE user_pass = :user_pass AND username = :username");
    $statement->bindValue(':username', $user);
    $statement->bindValue(':user_pass', $pass);
    $statement->execute();
    $arr = $statement->fetch(PDO::FETCH_ASSOC);


    if (empty($arr)) {
        $arr = [];
        $message[] = 'Invalid Credintials, Please try again!';
    } else {


        if ($arr['username'] === $user || $arr['user_pass'] === $pass) {
            $message[] = "Congratulations, You are successfully login!";
            $_SESSION['adminId'] = $arr['user_id'];
            header('location: Dashboard.php');
        }
    }
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="log.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>



    <div id="parent">

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="row g-3 needs-validation" novalidate method="post">
            <div class="input-group d-flex justify-content-center flex-column align-items-center">
                <img src="" alt="">

                <?php if ($message) : ?>

                    <?php foreach ($message as $key => $value) : ?>

                        <script>
                            alert("<?php echo $value ?>");
                        </script>

                    <?php endforeach; ?>

                <?php endif; ?>
                <h2 class="lh-1" style="font-size:20px;">INVENTORY MANAGEMENT SYSTEM</h2>
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" class="form-control" required placeholder="Username" name="username">
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                <input type="password" class="form-control" required placeholder="Password" name="password">
            </div>

            <div class="input-group mb-2">
                <button class="btn btn-success" type="submit">LOGIN</button>
            </div>



        </form>
        <div class="input-group mb-3">
            <button class="btn btn-primary" type="submit" data-bs-toggle="modal" data-bs-target="#addAccount">CREATE ACCOUNT</button>
        </div>

        <div class=""><?php $message; ?></div>
    </div>



    <div class="modal fade" id="addAccount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5 text text-white fw-bold text-uppercase" id="staticBackdropLabel" style="font-family: 'Playfair Display', serif; letter-spacing:2px; "><i class="fa-sharp fa-solid fa-user me-2"></i>Create Account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="insertUser.php" method="post">
                    <div class="modal-body">
                   
                       <select name="userType" class="form-control text-center mb-3" style="width: 200px;" >
                                    <option value="0" selected="">-- Choose here --</option>
                                    <?php if (!$hideAdminOption): ?>
        <option value="Admin">Admin</option>
    <?php endif; ?>
                                    <option value="Employee"> Employee</option>
                                    <option value="Staff"> Staff</option>
                         </select>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="user">
                            <label for="floatingInput" class="text text-black">Username:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingInput" name="pass">
                            <label for="floatingInput" class="text text-black">Password:</label>
                        </div>
                        <hr>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="first">
                            <label for="floatingInput" class="text text-black">Firstname:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="last">
                            <label for="floatingTextarea" class="text text-black">Lastname:</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" name="phone">
                            <label for="floatingTextarea" class="text text-black">Phone number:</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="save">Save Account</button>
                    </div>
                </form>

            </div>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script>
        (() => {
            'use strict'


            const forms = document.querySelectorAll('.needs-validation')


            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>