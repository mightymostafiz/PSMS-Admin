<?php 
require_once('header.php'); 

$admin_id = $_SESSION['admin_loggedin'][0]['id'];

$statement = $pdo->prepare("SELECT password FROM admin WHERE id=?");
$statement->execute(array($admin_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

$db_password = $result[0]['password'];


if(isset($_POST['change_btn'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if(empty($current_password)){
        $error = "Current Password is required!";
    }
    else if(empty($new_password)){
        $error = "New Password is required!";
    }
    else if(strlen($new_password)< 6){
        $error = "Please Enter more than 6 Digit New Password!";
    }
    else if(empty($confirm_new_password)){
        $error = "Confirm New password is required!";
    }
    else if($new_password != $confirm_new_password){
        $error = "New and Confirm New password doesn't match!";
    }
    else if(SHA1($current_password) != $db_password){
        $error = "Current Password is Wrong!";
    }
    else{
        $newPassword = SHA1($confirm_new_password);

        $stm = $pdo->prepare("UPDATE admin SET password=? WHERE id=?");
        $stm->execute(array($newPassword,$admin_id));

        $success = "Change Password successfully done!";
    }
}
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-lock"></i>                 
                </span>
                Change Password
            </h3> 
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">  
                    <!-- alert -->
                    <?php if(isset($error)):?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($success)):?>
                        <div class="alert alert-success">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <form class="forms-sample" method="POST" action="">
                        <div class="form-group">
                            <label for="c_password">Current Password</label>
                            <input type="password" name="current_password" class="form-control" id="c_password" placeholder="Current Password">
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" class="form-control" id="new_password" placeholder="New Password">
                        </div>
                        
                        <div class="form-group">
                            <label for="c_new_password">Confirm New Password</label>
                            <input type="password" name="confirm_new_password" class="form-control" id="c_new_password" placeholder="Confirm New Password">
                        </div>
                        
                        <button type="submit" name="change_btn" class="btn btn-gradient-primary mr-2">Change Password</button> 
                    </form>
                </div>
                </div>
            </div>
        </div>

    </div>
</div>
        


<?php require_once('footer.php'); ?>