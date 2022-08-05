<?php 
require_once('header.php'); 

if(isset($_POST['create_btn'])){
    $class_name = $_POST['class_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if(isset($_POST['subjects'])){
        $subjects = $_POST['subjects'];
    }
    else{
        $subjects = '';
    }
    
    // Subject code count
    // $codeCount = getCount('subjects','code',$sub_code);

   
    if(empty($class_name)){
        $error = "Class name is required!";
    }
    else if(empty($start_date)){
        $error = "Start date is required!";
    }
    else if(empty($end_date)){
        $error = "End date is required!";
    }
    else{
        $subjects = json_encode($subjects);
        $insert = $pdo->prepare("INSERT INTO class (class_name,start_date,end_date,subjects) VALUES(?,?,?,?)");
        $insert->execute(array($class_name,$start_date,$end_date,$subjects));

        $success = "Create Class Successfully Done!";
    }
}
?>


<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-library menu-icon"></i>                 
    </span>
    Add New Class
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
                        <label for="class_name">Class Name</label>
                        <input type="text" name="class_name" class="form-control" id="class_name" placeholder="Class Name">
                    </div>
                
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" class="form-control" id="start_date" placeholder="Start Date">
                    </div>
                
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" class="form-control" id="end_date" placeholder="End Date">
                    </div>

                    <div class="form-group">
                        <label>Subjects</label>  
                        <?php 
                            $stm = $pdo->prepare("SELECT * FROM subjects ");
                            $stm->execute();
                            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

                            foreach($result as $row): 
                        ?>
                        <br><label><input type="checkbox" value="<?php echo $row['id'];?>" name="subjects[]" style="margin-left:50px;"> <?php echo $row['name'];?> - <?php echo $row['code'];?> </label>
                        <?php endforeach; ?>
                    </div>

                    <button type="submit" name="create_btn" class="btn btn-gradient-primary mr-2">Create Subject</button> 
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
        
