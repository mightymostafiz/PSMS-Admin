<?php 
require_once('header.php'); 


if(isset($_POST['submit_btn'])){
    $class_id = $_POST['select_class'];
    // marks count by default
    $marksCount = NULL;

    // required check 
    if(empty($class_id)){
        $error = "Please Select a Calss Name";
    }
    else{
        // get subjects name
        $allSubject = $pdo->prepare("SELECT subjects FROM class WHERE id=?");
        $allSubject->execute(array($class_id));
        $allSubjectList = $allSubject->fetchAll(PDO::FETCH_ASSOC);
        $allSubjectList = $allSubjectList[0]['subjects'];
        $allSubjectArray = json_decode($allSubjectList);


        // get submited marks list  
        $stm = $pdo->prepare("SELECT exam_marks.id,exam_marks.class_id,exam_marks.subject_id,exam_marks.exam_id,exam_marks.teacher_id,teachers.name as teacher_name,subjects.name as subject_name,subjects.code as subject_code FROM exam_marks 
        INNER JOIN teachers ON exam_marks.teacher_id = teachers.id 
        INNER JOIN subjects ON exam_marks.subject_id = subjects.id
        WHERE exam_marks.class_id=?");

        $stm->execute(array($class_id));
        $marksCount = $stm->rowCount();
        $marksList = $stm->fetchAll(PDO::FETCH_ASSOC);

        $markSubjectArray = [];
        foreach($marksList as $subMark){
            $markSubjectArray[] = $subMark['subject_id'];
        }
        $notSumitted = array_diff($allSubjectArray,$markSubjectArray); 

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
                 Student Marks
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
                                    $stm = $pdo->prepare("SELECT id,class_name FROM class ORDER BY class_name ASC");
                                    $stm->execute();
                                    $classList = $stm->fetchAll(PDO::FETCH_ASSOC);
        
                                    foreach($classList as $list):
                                    ?>
                                    
                                    <option
                                    <?php
                                        if(isset($_POST['select_class']) AND $_POST['select_class'] == $list['id']){
                                            echo "selected";
                                        }
                                    ?>
                                    value="<?php echo $list['id'];?>"><?php echo $list['class_name'] ;?></option>
                                    
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                <button type="submit" name="submit_btn" class="btn btn-gradient-primary mr-2">Check submit Marks</button> 
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>

<?php if(isset($_POST['submit_btn']) AND !empty($_POST['select_class'])) : ?>
<div class="content-wrapper" style="margin-top:-80px">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body"> 
                    <table class="table table-bordered">
                        <mark> Class Name:</mark> <?php echo getClassName($_POST['select_class'],'class_name') ;?>
                        <thead>
                            <tr>
                                <th class="text-center"><b>#</b></th>
                                <th class="text-center"><b>Teacher Name</b></th>
                                <th class="text-center"><b>Subject Name</b></th>
                                <th class="text-center"><b>Exam Type</b></th>
                                <th class="text-center"><b>Marks Status</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;  
                            foreach($marksList as $marks) : 
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i;?></td>
                                <td><?php echo $marks['teacher_name'];?> </td> 
                                <td class="text-center"><?php echo $marks['subject_name']."-".$marks['subject_code'];?> </td> 
                                <td class="text-center"><?php echo getExamName($marks['exam_id']);?> </td> 
                                <td class="text-center"><span class="badge badge-success">Submitted</span></td> 
                                
                            </tr>
                            <?php $i++;  endforeach; 
                            foreach($notSumitted as $notSubmit) : 
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i;?></td>  
                                <td><?php echo getSubjectTeacherName($notSubmit);?></td>  
                                <td class="text-center"><?php echo getSubjectName($notSubmit);?></td>  
                                <td></td> 
                                <td class="text-center"><span class="badge badge-danger">Not Submitted</span></td> 
                                
                                </tr>
                            <?php $i++; endforeach;?>
                        </tbody>
                    </table>
                    <?php if(count($notSumitted) == 0) : ?>
                    <br><br>
                    <a href="student-marks-details.php?class=<?php echo $_POST['select_class'];?>" class="btn btn-success"> Marks Calculation</a>
                    <?php endif;?>
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
        let att_id = $(this).val();
        let teacher_id = <?php echo $teacher_id; ?>;
        
        $.ajax({
            type: "POST",
            url:'ajax.php',
            data: {
                att_id:att_id
            },
            success:function(response){
                let data = response;
                $('#select_subject').html(data);
                // console.log(data);
            }
        });
    });
</script>

       
