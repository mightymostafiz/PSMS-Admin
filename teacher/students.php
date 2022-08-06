<?php require_once('header.php');

if(isset($_POST['filter_btn'])){

    $class_id = $_POST['class_id'];
    $stm=$pdo->prepare("SELECT name,mobile,email,current_class,class_name,gender FROM students
    INNER JOIN class ON students.current_class=class.id
    WHERE students.current_class=?
    ");
    $stm->execute(array($class_id));
    $filter_student=$stm->fetchAll(PDO::FETCH_ASSOC);
}

?>
<div class="main-panel">
    <div class="content-wrapper"> 
        <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-account-multiple"></i>                 
            </span>
            Students
        </h3> 
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">  
                    <?php if(isset($error)) :?>
                    <div class="alert alert-danger"><?php echo $error;?></div>
                    <?php endif;?>
                    <?php if(isset($success)) :?>
                    <div class="alert alert-success"><?php echo $success;?></div>
                    <?php endif;?>
                    <form class="forms-sample" method="POST" action="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="select_class">Select Class:</label>
                                    <select name="class_id" class="form-control" id="select_class">
                                        <?php 
                                        $stm=$pdo->prepare("SELECT class_name,id FROM class");
                                        $stm->execute();
                                        $result=$stm->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result as $row):
                                        ?>
                                        <option
                                        <?php 
                                        if(isset($_POST['filter_btn']) AND $_POST['class_id'] == $row['id']){
                                            echo "selected";
                                        }
                                        ?>
                                        value="<?php echo $row['id'];?>"><?php echo $row['class_name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div> 
                            </div> 
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" name="filter_btn" class="btn btn-gradient-primary mr-2">Filter Student</button> 
                                </div> 
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php if(isset($_POST['filter_btn'])) :?>
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <h4 class="text-center mt-2"><?php echo  getClassName($_POST['class_id'],'class_name');?> Students</h4>
        <div class="card-body"> 
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Student Name</th>
                        <th class="text-center">Class Name</th>
                        <th class="text-center">Mobile</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Gender</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    foreach($filter_student as $row):
                    ?>
                    <tr>
                        <td class="text-center">1</td>
                        <td class="text-center"><?php echo $row['name'];?></td>
                        <td class="text-center"><?php echo $row['class_name'];?></td>
                        <td class="text-center"><?php echo $row['mobile'];?></td>
                        <td class="text-center"><?php echo $row['email'];?></td>
                        <td class="text-center"><?php echo $row['gender'];?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table> 
        </div>
    </div>
</div>
<?php else :?>
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <h4 class="text-center pt-2">All Students</h4>
        <div class="card-body"> 
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Student Name</th>
                        <th class="text-center">Class Name</th>
                        <th class="text-center">Mobile</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Gender</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stm=$pdo->prepare("SELECT name,mobile,email,current_class,class_name,gender FROM students
                    INNER JOIN class ON students.current_class=class.id
                    ");
                    $stm->execute();
                    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $row):
                    ?>
                    <tr>
                        <td class="text-center">1</td>
                        <td class="text-center"><?php echo $row['name'];?></td>
                        <td class="text-center"><?php echo $row['class_name'];?></td>
                        <td class="text-center"><?php echo $row['mobile'];?></td>
                        <td class="text-center"><?php echo $row['email'];?></td>
                        <td class="text-center"><?php echo $row['gender'];?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table> 
        </div>
    </div>
</div>

<?php endif;?>

<?php require_once('footer.php'); ?>