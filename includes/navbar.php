<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/index.php">
            <img src="<?= BASE_URL ?>/assets/images/logo.png" alt="logo" class="img-fluid" style="width: 200px; height: auto;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="<?= BASE_URL ?>/index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/products.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/contact.php">Contact</a></li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['username'])): ?>
                        <a class="nav-link" href="<?= BASE_URL ?>/users_area/profile.php">My Account</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?= BASE_URL ?>/users_area/user_registration.php">Join Us</a>
                    <?php endif; ?>
                </li>
            </ul>
            <form class="d-flex me-2" action="search_product.php" method="GET">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search_data">
                <button class="btn btn-outline-primary ms-2" type="submit" name="search_data_btn">Search</button>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/cart.php">
                        <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 27C11.5523 27 12 26.5523 12 26C12 25.4477 11.5523 25 11 25C10.4477 25 10 25.4477 10 26C10 26.5523 10.4477 27 11 27Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M25 27C25.5523 27 26 26.5523 26 26C26 25.4477 25.5523 25 25 25C24.4477 25 24 25.4477 24 26C24 26.5523 24.4477 27 25 27Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M3 5H7L10 22H26" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10 16.6667H25.59C25.7056 16.6667 25.8177 16.6267 25.9072 16.5535C25.9966 16.4802 26.0579 16.3782 26.0806 16.2648L27.8806 7.26479C27.8951 7.19222 27.8934 7.11733 27.8755 7.04552C27.8575 6.97371 27.8239 6.90678 27.7769 6.84956C27.73 6.79234 27.6709 6.74625 27.604 6.71462C27.5371 6.68299 27.464 6.66661 27.39 6.66666H8" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <sup><?php cart_item(); ?></sup>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">
                        <?php echo isset($_SESSION['username']) ? "Welcome, " . $_SESSION['username'] : "Welcome, Guest"; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['username'])): ?>
                        <a class="nav-link" href="<?= BASE_URL ?>/users_area/logout.php">Logout</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?= BASE_URL ?>/users_area/user_login.php">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>