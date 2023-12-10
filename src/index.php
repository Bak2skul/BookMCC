<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookMCC - BMCC Book Exchange</title>
    <!-- <link rel="stylesheet" href="./assets/bootstrap-5.3.2-dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="./assets/css/fresh.css">
    <script src="./assets/js/fontawesome-kit.js"></script>
    <script src="./assets/js/fresh.js" defer></script>
</head>
<body>
    <!-- Previous Button -->
    <button id="prev-btn">
        <i class="fas fa-arrow-circle-left"></i>
    </button>

    <!-- Book -->
    <div id="book" class="book">
        <!-- Paper 1 -->
        <div id="p1" class="paper">
            <div class="front">
                <div id="f1" class="front-content">
                    <h2>Welcome, to</h2>
                    <img src="./assets/images/logo.png" alt="BookMCC Logo">
                    <p><br>Books for BMCC students,<br>
                        From BMCC students<br>
                        Same book, Same class<br>
                        Let's get started...
                    </p>
                </div>
            </div>
            <div class="back">
                <div id="b1" class="back-content">
                    <h2>Sign up</h2>
                    <form action="signup-process.php" method="post">
                        <label for="email">Enter your email:</label>
                        <br>
                        <input type="email" name="email" placeholder="@stu.bmcc.cuny.edu" required>
                        <br>
                        <label for="password">Password:</label>
                        <br>
                        <input type="password" name="password" placeholder="pw123" required>
                        <br>
                        <input class="button" type="submit" value="Sign up">
                    </form>
                    <br>
                    <br>
                    <p>
                        If you already have an account, please login.
                    </p>
                </div>
            </div>
        </div> <!-- End Paper 1 -->
        <!-- Paper 2 -->
        <div id="p2" class="paper">
            <div class="front">
                <div id="f2" class="front-content">
                    <h2>Login</h2>
                    <form action="login-process.php" method="post">
                        <label for="email">Enter your email:</label>
                        <br>
                        <input type="email" id="email" name="email" placeholder="@stu.bmcc.cuny.edu" required>
                        <br>
                        <label for="password">Password:</label>
                        <br>
                        <input type="password" id="password" name="password" placeholder="pw123" required>
                        <br>
                        <input class="button" type="submit" value="Login">
                    </form>
                    <br>
                    <br>
                    <p>
                        <?php if(isset($_SESSION['UserID'])): ?>
                            You are logged in.
                            <br>
                            <a href="home.php">Check out the website</a>
                        <?php else: ?>
                            Visit the website as a guest.
                            <br>
                            <a href="home.php">Click here</a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="back">
                <div id="b2" class="back-content">
                    <?php if(isset($_SESSION['UserID'])): ?>
                        <h1>
                            Good Luck!
                            <br>
                            Study hard
                            <br>
                            BREATH
                            <br>
                            <br>
                            <span style="font-size: 0.5em">
                                <a href="home.php">Check out the website</a>
                            </span>
                        </h1>
                    <?php else: ?>
                        <h1>
                            You are not
                            <br>
                            logged in.
                            <br>
                            Please go back
                            <br>
                            to login.
                        </h1>
                    <?php endif; ?>
                </div>
            </div>
        </div> <!-- End Paper 2 -->

    </div> <!-- End Book -->

    <!-- Next Button -->
    <button id="next-btn">
        <i class="fas fa-arrow-circle-right"></i>
    </button>

</body>
</html>