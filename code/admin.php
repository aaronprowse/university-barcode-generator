<?php
include_once ('resources/php/db.php');

if(!$user->loggedIn() Or !$user->checkLevel())
{
    $user->redirect('index.php');
}

if(isset($_POST['btnSignup']))
{
    $uName = trim($_POST['userName']);
    $uPassword = trim($_POST['password']);
    $uLevel = trim($_POST['adminBox']);

    if($uName=="") {
        $error[] = "username not found please try again";
    }
    else if($uPassword=="") {
        $error[] = "password not found please try again";
    }
    else if(strlen($uPassword) < 6){
        $error[] = "Password must be atleast 6 characters";
    }
    else
    {
        try
        {
            $stmt = $dbUsers->prepare("SELECT username FROM staff WHERE username='" . $uName . "'");
            $stmt->execute(array(':userName'=>$uName));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            if($row['username'] == $uName) {
                $error[] = "sorry username has already been taken";
            }
            else
            {
                if($admin->register($uName,$uPassword, $uLevel))
                {
                    $admin->redirect('admin.php?joined');
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}
include_once('header.php');
?>
    <div id="loginContainer" class="textCenter">
        <form method="post">
            <h2>Register new user</h2>
            <?php
            if(isset($error))
            {
                foreach($error as $error)
                {
                    ?>
                    <div class="alert">
                        <?php echo $error; ?>
                    </div>
                    <?php
                }
            }
            else if(isset($_GET['joined']))
            {
                ?>
                <div class="alertSuccess">
                    <p>User added successfully</p>
                </div>
                <?php
            }
            ?>
            <div class="formInput">
                Username:
                <input type="text" name="userName" placeholder="Username" />
            </div>
            <div class="formInput">
                Password:
                <input type="password" name="password" placeholder="Password" />
            </div>
            <div class="formInput">
                Is this user an Admin?
                <input type="checkbox" name="adminBox" />
            </div>
            <div class="formInput">
                <button type="submit" class="btn" name="btnSignup">
                    Register new user
                </button>
            </div>
        </form>
    </div>
<?php
include_once('footer.php');
?>