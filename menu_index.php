<header class="fixed-header">
    <style>
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .btn-rounded {
            border-radius: 15px;
            /* Ajusta este valor para hacer las esquinas más o menos curvas */
        }
    </style>

    <div class="navbar navbar-expand-lg navbar-dark bg-black py-2 ">
        <div class="container">
            <a href="index.php" class="navbar-brand d-flex align-items-center">
                <img src="imagenes/logo1.png" alt="Logo de Arkatech" height="40" class="me-2">
                <span style="font-size: 25px; font-weight: 600;">Arkatech</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-3">
                        <a href="#C" class="nav-link active"> Catalogo</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="#CO" class="nav-link "> Contacto</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="checkout.php" class="btn btn-primary me-2 btn-rounded">
                        <i class="fa-solid fa-cart-shopping"></i> Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?> </span>
                    </a>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <div class="dropdown">
                            <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i> &nbsp; <?php echo $_SESSION['user_name']; ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btn_session">
                                <li><a class="dropdown-item" href="logout.php">Cerrar sesion</a></li>
                                <li><a class="dropdown-item" href="compras.php">Mis compras</a></li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <a href="login.php" class="btn btn-danger btn-rounded"> <i class="fa-solid fa-user"></i> Ingresar</a><?php } ?>
                </div>
            </div>
        </div>
    </div>


</header>