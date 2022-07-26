<?php 
require_once('header.php'); 

if(isset($_POST['create_btn'])){
    $t_name = $_POST['t_name'];
    $t_email = $_POST['t_email'];
    $t_mobile = $_POST['t_mobile'];
    $t_address = $_POST['t_address'];
    $t_gender = $_POST['t_gender'];
    $t_password = $_POST['t_password'];
     

    $admin_id = $_SESSION['admin_loggedin'][0]['id'];
    
    // Teachers mobile count
    $mobileCount = getCount('teachers','mobile',$t_mobile);
    // Teachers email count
    $emailCount = getCount('teachers','email',$t_email);

    if(empty($t_name)){
        $error = "Name is required!";
    }
    else if(empty($t_email)){
        $error = "Email is required!";
    }
    else if(empty($t_mobile)){
        $error = "Mobile Number is required!";
    }
    else if(empty($t_address)){
        $error = "Address is required!";
    }
    else if(empty($t_password)){
        $error = "Address is required!";
    }
    else if($mobileCount !=0 ){
        $error = "Mobile number already used!";
    }
    else if($emailCount !=0 ){
        $error = "Email address already used!";
    }
    else{
        $password = SHA1($t_password);
        $created_at = date("Y:m:d H:i:s");

        $insert = $pdo->prepare("INSERT INTO teachers (name,email,mobile,address,gender,password,created_at) VALUES(?,?,?,?,?,?,?)");
        $insert->execute(array($t_name,$t_email,$t_mobile,$t_address,$t_gender,$password,$created_at));

        $success = "Teachers Account Create Successfully!";
    }
}
?>


<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account"></i>                 
    </span>
    Add New Teacher
  </h3> 
</div>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">  
                <?php if(isset($error)) :?>
                    <div class="alert alert-danger"><?php echo $error;?></div>
                <?php endif;?>
                <?php if(isset($success)) :?>
                    <div class="alert alert-success"><?php echo $success;?></div>
                <?php endif;?>

                <form class="forms-sample" method="POST" action="">
                    <div class="form-group">
                        <label for="t_name">Name</label>
                        <input type="text" name="t_name" class="form-control" id="t_name" placeholder="Teacher Name">
                    </div>
                
                    <div class="form-group">
                        <label for="t_email">Email</label>
                        <input type="email" name="t_email" class="form-control" id="t_email" placeholder="Teacher Email">
                    </div>

                    <div class="form-group">
                        <label for="t_mobile">Mobile</label>
                        <input type="text" name="t_mobile" class="form-control" id="t_mobile" placeholder="Teacher Mobile">
                    </div>

                    <div class="form-group">
                        <label for="t_address">Address</label>
                        <input type="text" name="t_address" class="form-control" id="t_address" placeholder="Address">
                    </div>

                    <div class="form-group">
                        <label>Gender:</label> <br>
                        <label><input type="radio" value="Male" name="t_gender" style="margin-left:50px
                        " Checked> Male</label> &nbsp; &nbsp;
                        <label><input type="radio" value="Female" name="t_gender"> Female</label>
                    </div>

                    <div class="form-group">
                        <label for="t_password">Password:</label>
                        <input type="password" name="t_password" class="form-control" id="t_password" placeholder="Password">
                    </div>
                    
                    <button type="submit" name="create_btn" class="btn btn-gradient-primary mr-2">Create Teacher Account</button> 
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
        
