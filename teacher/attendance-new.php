<?php 
require_once('header.php'); 

$teacher_id = $_SESSION['teacher_loggedin'][0]['id'];

$statement = $pdo->prepare("SELECT password FROM teachers WHERE id=?");
$statement->execute(array($teacher_id));
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

        $stm = $pdo->prepare("UPDATE teachers SET password=? WHERE id=?");
        $stm->execute(array($newPassword,$teacher_id));

        $success = "Change Password successfully done!";
    }
}
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-lead-pencil"></i>                 
                </span>
                New Attendance
            </h3> 
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                <label for="select_class">Select Class</label>
                                <select name="" id="select_class" class="form-control">
                                    <option value=""></option>
                                </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                <label for="select_subject">Select Subject</label>
                                <select name="" id="select_subject" class="form-control">
                                    <option value=""></option>
                                </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                <label for="select_class">Select Date</label>
                                <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="change_btn" class="btn btn-gradient-primary mr-2">Submit Attendance</button> 
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body"> 
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Student Name</td>
                                <td>Student Roll</td>
                                <td>Absent</td>
                                <td>Present</td>
                            </tr>
                            <tbody>
                                <td>1</td>
                                <td>Mosta</td>
                                <td>245</td>
                                <td><label for="absent"><input type="radio" name="attendance" id="absent"> Absent</label></td>
                                <td><label for="present"><input type="radio" name="attendance" id="present"> Present</label></td>
                            </tbody>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
    <!-- finsih -->
</div>
        

<?php require_once('footer.php'); ?>