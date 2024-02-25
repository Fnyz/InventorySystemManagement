<?php

session_start();
require_once "./Model/Prod.php";
$prod = new Prod();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['save'])) {



        $prod->prod = $_POST['prod'];
        $prod->price = $_POST['price'];
        $prod->quantity = $_POST['quan'];
        $prod->desc = $_POST['desc'];

        if (!is_dir("images")) {
            mkdir("images");
        }


        function randoms($n)
        {
            $charac = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $str = "";
            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($charac) - 1);
                $str .= $charac[$index];
            }
            return $str;
        }

        $image = $_FILES['image'] ?? null;

        $fullpath = "";

        if ($image && $image['tmp_name']) {



            $path = "images/";
            $folder = randoms(8) . "/";
            $ImName = $image['name'];

            $fullpath = $path . $folder . $ImName;
            mkdir(dirname($fullpath));

            move_uploaded_file($image['tmp_name'], $fullpath);
        }

        $prod->image = $fullpath;



        if ($prod->insertItem()) {
            $_SESSION['Saves'] = "PRODUCT IS SUCCESSFULLY ADDED!";
            header("Location: Product.php");
        };
    }
}
