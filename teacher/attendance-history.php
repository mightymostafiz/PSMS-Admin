<?php 
require_once('header.php'); 
$teacher_id = $_SESSION['teacher_loggedin'][0]['id'];


if(isset($_POST['submit_btn'])){
   $class_id = $_POST['select_class'];
   if(isset($_POST['select_subject'])){
        $subject_id = $_POST['select_subject'];
   }
   else{
    $subject_id = '';
   }
   $att_date = $_POST['att_date'];
    //  Attendance Cound
    $stm = $pdo->prepare("SELECT * FROM attendance WHERE class_id=? AND subject_id=? AND teacher_id=? AND attendance_date=? ");
    $stm->execute(array($class_id,$subject_id,$teacher_id,$att_date));
    $attCount = $stm->rowCount();
    // default set
    $studentCount = NULL;
    // DATE 
    $today = date('Y-m-d');
    // required check 
    if(empty($class_id)){
        $error = "Please Select a Calss Name";
    }
    else if(empty($subject_id)){
        $error = "Please Select a Subject Name";
    }
    else if(empty($att_date)){
        $error = "Please Select Attandace Date";
    }
    else if($attCount !=1){
        $error = "Attendance not Found, Thanks!";
    }
    else{
        $stm = $pdo->prepare("SELECT * FROM attendance WHERE class_id=? AND subject_id=? AND attendance_date=? ");
        $stm->execute(array($class_id,$subject_id,$att_date));
        $studentCount = $stm->rowCount();
        $studentList = $stm->fetchAll(PDO::FETCH_ASSOC);

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
                 Attendance History
            </h3> 
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">  
                    <!-- alert -->
                    <?php if(isset($error)):?>
                        <div class="alert alert-danger text-center">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($success)):?>
                        <div class="alert alert-success text-center">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <form class="forms-sample" method="POST" action="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="select_class">Select Class</label>
                                <select name="select_class" id="select_class" class="form-control">
                                    <option value="">Select Class</option>
                                    <?php
                                    $stm = $pdo->prepare("SELECT DISTINCT class_name FROM class_routine WHERE teacher_id=? ORDER BY class_name ASC");
                                    $stm->execute(array($teacher_id));
                                    $classList = $stm->fetchAll(PDO::FETCH_ASSOC);
        
                                    foreach($classList as $list):
                                    ?>
                                    
                                    <option
                                    <?php
                                        if(isset($_POST['select_class']) AND $_POST['select_class'] == $list['class_name']){
                                            echo "selected";
                                        }
                                    ?>
                                    value="<?php echo $list['class_name'];?>"><?php echo getClassName($list['class_name'],'class_name') ;?></option>
                                    
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="select_subject">Select Subject</label>
                                <select name="select_subject" id="select_subject" class="form-control"> getSubjectName
                                <?php
                                    if(isset($_POST['select_subject'])){
                                        echo '<option value="'.$_POST['select_subject'].'">'.getSubjectName($_POST['select_subject']).'</option>';
                                    }
                                ?>
                                </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="att_date">Select Date</label>
                                <input type="date" value="<?php if(isset($_POST['att_date'])){
                                        echo $_POST['att_date'];
                                    }
                                ?>" name="att_date" id="att_date" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3 mt-3">
                                <div class="form-group">
                                <button type="submit" name="submit_btn" class="btn btn-gradient-primary mr-2">Search</button> 
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>

<?php if(isset($_POST['submit_btn']) AND $studentCount != NULL): ?>
<div class="content-wrapper" style="margin-top:-80px">
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body"> 
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center"><b>#</b></th>
                                <th class="text-center"><b>Student Name</b></th>
                                <th class="text-center"><b>Present</b></th>
                                <th class="text-center"><b>Absent</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            $stList = $studentList[0]['student_data'];
                            $stList = json_decode($stList,true);
                         
                            foreach($stList as $newList) : 

                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i;?></td>
                                <td><?php echo $newList['name'];?></td>
                                <td class="text-center"><?php if($newList['status']==1){
                                    echo '<i class="mdi mdi-check"></i>';
                                };?></td>
                                <td class="text-center"><?php if($newList['status']==0){
                                    echo '<i class="mdi mdi-check"></i>';
                                };?></td>
                                
                            </tr>
                            <?php $i++; endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
    <!-- finsih -->
</div>
        

<?php require_once('footer.php'); ?>

<script>
    $('#select_class').change(function(){
        let class_id = $(this).val();
        let teacher_id = <?php echo $teacher_id; ?>;
        
        $.ajax({
            type: "POST",
            url:'ajax.php',
            data: {
                teacher_id:teacher_id,
                class_id:class_id,
            },
            success:function(response){
                let data = response;
                $('#select_subject').html(data);
                // console.log(data);
            }
        });
    });
</script>

       
