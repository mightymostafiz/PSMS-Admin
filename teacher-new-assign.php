<?php 
require_once('header.php'); 

if(isset($_POST['create_btn'])){
    $teacher = $_POST['teacher'];
    $subject = $_POST['subject'];
    
    // Assign subject count count
    $subjectCount = getCount('assign_teachers','subject_id',$subject);

    if($subjectCount !=0 ){
        $error = "Already Assign Teacher for This Subject!";
    }
    else{
        $insert = $pdo->prepare("INSERT INTO assign_teachers(teacher_id,subject_id) VALUES(?,?)");
        $insert->execute(array($teacher,$subject));

        $success = "Assign Teacher Successfully!";
    }
}
?>


<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-kodi menu-icon"></i>                 
    </span>
   New Subject Assign
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
                        <!-- Teacher name assign -->
                        <label for="t_name">Teacher Name</label>
                        <?php 
                            $stm = $pdo->prepare("SELECT id,name FROM teachers");
                            $stm->execute();
                            $tLists = $stm->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <select name="teacher" id="t_name" class="form-control">
                            <?php foreach($tLists as $tlist): ?>
                            <option value="<?php echo $tlist['id']; ?>"><?php echo $tlist['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Subject name assign -->
                    <div class="form-group">
                        <label for="sub_name">Subject</label>
                        <?php 
                            $stm = $pdo->prepare("SELECT id,name,code FROM subjects");
                            $stm->execute();
                            $subLists = $stm->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <select name="subject" id="sub_name" class="form-control">
                            <?php foreach($subLists as $sublist): ?>
                            <option value="<?php echo $sublist['id']; ?>"><?php echo $sublist['name']." - ".$sublist['code']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button type="submit" name="create_btn" class="btn btn-gradient-primary mr-2">Assign Subject</button> 
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
        
