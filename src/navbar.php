<!-- <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light"> -->
<!-- <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark"> -->
<nav class="navbar navbar-expand-lg fixed-top navbar-light" style="background-color: powderblue;">
    <div class="container-md">
        <!-- <a class="navbar-brand mb-0 h1" href="/">BookMCC · BMCC Book Exchange</a> -->
        <a class="navbar-brand mb-0 h1" href="home.php">
            <img src="./assets/images/logo.png" alt="BookMCC Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto">
            <?php if(isset($_SESSION['UserID'])): ?>
                <span class="navbar-text">
                    Welcome, <?php echo htmlspecialchars($_SESSION['Username']); ?>&nbsp;&nbsp;
                </span>
                <a class="nav-link" href="post-book.php">Post a Book</a>
                <a class="nav-link" href="logout.php">Logout</a>
            <?php else: ?>
                <span class="navbar-text">
                    Welcome, Guest&nbsp;&nbsp;
                </span>
                <a class="nav-link" href="post-book.php">Post a Book</a>
                <a class="nav-link" href="index.php">Login</a>
            <?php endif; ?>
        </div>
        </div>
    </div>
</nav>
