<ul class="list-group">
    <?php foreach ($r as $val) : extract($val) ?>
        <?php
        $currentPage = basename($_SERVER['PHP_SELF']); // Get the current page filename
        
        switch ($userType) {
            case "Employee":
                ?>
                <li class="list-group-item <?php echo ($currentPage == 'Dashboard.php') ? 'active' : ''; ?>"><a href="Dashboard.php" class="text <?php echo ($currentPage == 'Dashboard.php') ? 'text-white' : 'text-secondary'; ?> text-decoration-none "><i class="fa-solid fa-house-user me-2"></i>Home</a></li>
                <li class="list-group-item <?php echo ($currentPage == 'Product.php') ? 'active' : ''; ?>"><a href="Product.php" class="text <?php echo ($currentPage == 'Product.php') ? 'text-white' : 'text-secondary'; ?>  text-secondary text-decoration-none"><i class="fa-solid fa-cart-shopping me-2"></i>Product</a></li>
                <li class="list-group-item <?php echo ($currentPage == 'Request_history.php') ? 'active' : ''; ?>"><a href="Request_history.php" class="text text-secondary text-decoration-none"><i class="fa-brands fa-gg-circle me-2"></i>Request History</a></li>
                <li class="list-group-item <?php echo ($currentPage == 'RequestProduct.php') ? 'active' : ''; ?>"><a href="RequestProduct.php" class="text text-secondary text-decoration-none"><i class="fa-brands fa-gg-circle me-2"></i>Request Product</a></li>
                <?php
                break;
            case "Staff":
                ?>
                <li class="list-group-item <?php echo ($currentPage == 'Supplier.php') ? 'active' : ''; ?>"><a href="Supplier.php" class="text text-secondary text-decoration-none"><i class="fa-solid fa-users me-2"></i>Supplier</a></li>
                <li class="list-group-item <?php echo ($currentPage == 'Transactions.php') ? 'active' : ''; ?>"><a href="Transactions.php" class="text text-secondary text-decoration-none"><i class="fa-brands fa-gg-circle me-2"></i>Transactions</a></li>
                <li class="list-group-item <?php echo ($currentPage == 'Transaction.php') ? 'active' : ''; ?>"><a href="Transaction.php" class="text text-secondary text-decoration-none"><i class="fa-solid fa-money-bill-1-wave me-2"></i>History</a></li>
                <?php
                break;
            // Add more cases as needed
            default:
                echo "<p>Today is not Monday, Tuesday, or Wednesday.</p>";
        }
        ?>
    <?php endforeach; ?>

    <li class="list-group-item <?php echo ($currentPage == 'Accounts.php') ? 'active' : ''; ?>"><a href="Accounts.php" class="text text-secondary text-decoration-none"><i class="fa-solid fa-key me-2"></i> Registered Accounts</a></li>
    <li class="list-group-item <?php echo ($currentPage == 'login.php') ? 'active' : ''; ?>"><a href="login.php" class="text text-secondary text-decoration-none"><i class="fa-solid fa-right-from-bracket me-2"></i>Log-Out</a></li>
</ul>
