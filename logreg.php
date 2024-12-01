<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="logreg.css">
    <title>Rizq © Blankreaper</title>
</head>

<body>

    <header class="header" id="header">
        <nav class="nav__container">

            <a href="index.html" class="nav__logo">
                Rizq
            </a>


        </nav>

    </header>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="signup-check.php" method="post">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>

                <?php if (isset($_GET['success'])) { ?>
                    <p class="success"><?php echo $_GET['success']; ?></p>
                <?php } ?>

                <h1>Sign Up</h1>

                <?php if (isset($_GET['name'])) { ?>
                    <input type="text"
                        name="name"
                        placeholder="Name"
                        value="<?php echo $_GET['name']; ?>"><br>
                <?php } else { ?>
                    <input type="text"
                        name="name"
                        placeholder="Name"><br>
                <?php } ?>


                <?php if (isset($_GET['email'])) { ?>
                    <input type="email"
                        name="email"
                        placeholder="Email"
                        value="<?php echo $_GET['email']; ?>"><br>
                <?php } else { ?>
                    <input type="email"
                        name="email"
                        placeholder="Email"><br>
                <?php } ?>

                <input type="password" name="password" placeholder="Password"><br>
                <input type="password" name="re_password" placeholder="Repeat Password"><br>

                <button type="submit">Sign Up</button>
            </form>
        </div>
        <div class="form-container login">
            <form action="login.php" method="post">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
                <h1>Login</h1>

                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <a href="#">Forgot Your Password?</a>
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Already have an account?</h1>
                    <p>Login with your personal details to use all of site features</p>
                    <button class="hidden" id="login">Login</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Don't have an account?</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>