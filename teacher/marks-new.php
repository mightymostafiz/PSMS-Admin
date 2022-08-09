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
   $exam_id = $_POST['select_exam'];
    //  Attendance Cound
    $stm = $pdo->prepare("SELECT * FROM exam_marks WHERE class_id=? AND subject_id=? AND teacher_id=? AND exam_id=? ");
    $stm->execute(array($class_id,$subject_id,$teacher_id,$exam_id));
    $exCount = $stm->rowCount();
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
    else if(empty($exam_id)){
        $error = "Please Select Select a Exam";
    }
    else if($exCount ==1){
        $error = "This Subject Marks Already Submited, Thanks!";
    }
    else{
        $stm = $pdo->prepare("SELECT id,name,roll FROM students WHERE current_class=?");
        $stm->execute(array($class_id));
        $studentCount = $stm->rowCount();
        $studentList = $stm->fetchAll(PDO::FETCH_ASSOC);

   }
}

// Submit Students Marks
if(isset($_POST['mark_submit'])){

    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $marks = $_POST['marks'];

    $length = count($student_id);
    $studentData = [];
    for($i=0;$i<$length;$i++){
        $studentData[$i]['id'] = $student_id[$i];
        $studentData[$i]['name'] = $student_name[$i];
        $studentData[$i]['marks'] = $marks[$i];
    }

    $final_st_data = json_encode($studentData);
    
    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];
    $exam_id = $_POST['exam_id'];

    $insert = $pdo->prepare("INSERT INTO exam_marks(teacher_id,class_id,subject_id,exam_id,student_data) VALUES(?,?,?,?,?)");
    $insert->execute(array($teacher_id,$class_id,$subject_id,$exam_id,$final_st_data));
    $success = "Student Marks Submit Successfully Done, Thanks!";

}

?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-lead-pencil"></i>                 
                </span>
                Submit Exam Marks
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
                                <label for="select_exam">Select Exam</label>
                                <select name="select_exam" id="select_exam" class="form-control">
                                    <option 
                                    <?php
                                        if(isset($_POST['select_exam']) AND $_POST['select_exam'] == 1){
                                            echo "selected";
                                        }
                                    ?>
                                    value="1">1st Term</option>
                                    <option 
                                    <?php
                                        if(isset($_POST['select_exam']) AND $_POST['select_exam'] == 2){
                                            echo "selected";
                                        }
                                    ?>
                                    value="2">2nd Term</option>
                                    <option
                                    <?php
                                        if(isset($_POST['select_exam']) AND $_POST['select_exam'] == 3){
                                            echo "selected";
                                        }
                                    ?>
                                    value="3">Final Exam</option>
                                </select>
                                </div>
                            </div>

                            <div class="col-md-3 mt-3">
                                <div class="form-group">
                                <button type="submit" name="submit_btn" class="btn btn-gradient-primary mr-2">Submit</button> 
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
    <?php if($studentCount >0): ?>
<div class="content-wrapper" style="margin-top:-80px">
    <div class="row">
        <div class="col-md-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body"> 
                    <form action="" method="POST">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Student Name</th>
                                    <th class="text-center">Student Marks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i=1; 
                                $a=0; 
                                foreach($studentList as $newList) :
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i;?></td>
                                    <td><?php echo $newList['name'];?> 
                                    <input type="hidden" value="<?php echo $newList['id'];?>" name="student_id[]">
                                    <input type="hidden" value="<?php echo $newList['name'];?>" name="student_name[]">

                                    <input type="hidden" value="<?php echo $_POST['select_class'];?>" name="class_id">
                                    <input type="hidden" value="<?php echo $_POST['select_subject'];?>" name="subject_id">
                                    <input type="hidden" value="<?php echo $_POST['select_exam'];?>" name="exam_id">
                                    </td>

                                    <td>
                                    <input type="number" class="form-control text-center" name="marks[<?php echo $a;?>]">
                                    </td>
                                </tr>
                                <?php $i++;$a++; endforeach;?>
                            </tbody>
                        </table>
                <br>
                <br>
                <div class="form-group">
                    <input type="submit" name="mark_submit" class="btn btn-success btn-sm" value="Submit Marks">
                </div>

                </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
    <div class="alert alert-danger text-center">
        <h4>Student Not Found</h4>
    </div>
<?php endif; ?>
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

       
