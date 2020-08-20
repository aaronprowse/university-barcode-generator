<?php
require_once('resources/php/db.php');

if($user->loggedin()!="")
{
   $user->redirect('dashboard.php');
}

if(isset($_POST['btnLogin']))
{
    $uName = $_POST['userName'];
    $uPassword = $_POST['password'];

    if($user->login($uName, $uPassword))
    {
        $user->redirect('dashboard.php');
    }
    else
    {
        $error = "Incorrect username/password";
    }
}

include_once('header.php');
?>
    <div id="loginContainer" class="textCenter">
        <form method="post">
            <h2>Welcome to iBar please sign in</h2>
            <?php
            if(isset($error))
            {
                ?>
                <div class="alert">
                    <?php echo $error; ?>
                </div>
                <?php
            }
            ?>
            <div class="formInput">
                Username:
                <input type="text" class="form-control" name="userName" placeholder="Username" required />
                </div>
            <div class="formInput">
                Password:
                <input type="password" class="form-control" name="password" placeholder="Password" required />
            </div>
                <button type="submit" name="btnLogin" class="btn">
                    Log In
                </button>
        </form>
        <h2>Demo Login Details</h2>
        <p>Guest Username: demouser<br /> password: demopassword</p>
        <p>Admin Username: admin<br /> password: ibar123</p>
    </div>


<?php
include_once('footer.php');
?>