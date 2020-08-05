<?php
    require('header.php');
    $_SESSION['current_page'] = 'signup.php';
?>

      <main role="main">
      <div class="container py-3">
            <?php
                if($_GET['error'] == 'recover'){
            ?>
            <div class="row mx-auto">
                <form class="mx-auto" action="include/recover.php" method="POST" name="recoverform">
                <div class="input-group mb-3 mx-auto">
                    <p>Your login attempt failed.</p>
                    <input type="text" class="form-control-sm text-muted" id="recoveremail" name="recoveremail" placeholder="E-mail" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-outline-info" type="button" id="button-recover" name="recover">Recover</button>
                    </div>
                </div>
                </form>
            </div>
            <?php
                }
            ?>
            <h1>Signup to the QGIS Hub</h1>
            <p class="lead text-muted">
                To be able to submit and edit your submissions you need to have an account.
                In order to be able to help you reset your password, an e-mail is also required.
                Your username must be uniqe and it will be assosiated with the styles you submit.
            </p>
            <form action="include/signup.inc.php" method="POST" name="signup" enctype="multipart/form-data">
            <div class="form-row<?php if($_GET['error']=='username-email'){ echo(" bg-warning");}?>">
            <div class="form-group col-md-6">
                <label for="userName">Username</label>
                <input type="text" class="form-control<?php if($_GET['error']=='username'){ echo(" is-invalid");}?>" id="userName" name="userName" placeholder="Username" value="<?php echo($_GET['user']) ?>">
                <small id="xmlHelp" class="form-text text-muted">Uniqe username will be used for your interactions.</small>
            </div>
            <div class="form-group col-md-6">
                <label for="email">E-mail</label>
                <input type="text" class="form-control<?php if($_GET['error']=='email'){ echo(" is-invalid");}?>" id="email" name="email" placeholder="Valid E-mail" value="<?php echo($_GET['email']) ?>">
                <small id="xmlHelp" class="form-text text-muted">E-main is required to reset password, and can be used to login.</small>
            </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="pwd1">Password</label>
                <input type="password" class="form-control<?php if($_GET['error']=='password'){ echo(" is-invalid");}?>" id="pwd1" aria-describedby="pwdHelp" name="pwd1" placeholder="Password">
                <small id="pwdHelp" class="form-text text-muted">Select a secure password.</small>
            </div>
            <div class="form-group col-md-6">
            <label for="pwd2">Password</label>
                <input type="password" class="form-control<?php if($_GET['error']=='password'){ echo(" is-invalid");}?>" id="pwd2" aria-describedby="pwd2Help" name="pwd2" placeholder="Repeat Password">
                <small id="pwd2Help" class="form-text text-muted">Repeat your secure password.</small>
            </div>
            </div>
            <div class="form-row">
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input<?php if($_GET['error']=='terms'){ echo(" is-invalid");}?>" id="submitCC0" name="terms" value="1" <?php if($_GET['terms']){echo('checked="yes"');} ?>>
                <label class="form-check-label" for="submitCC0">Terms ......</label>
            </div>
            </div>
            <button type="submit" class="btn btn-primary" name="signup">Signup</button>
            </form>
        </div>
        

      </main>
<?php
    require('footer.php');
?>