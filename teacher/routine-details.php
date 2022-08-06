<?php require_once('header.php'); 



$class_id = $_GET['id'];
$teacher_id = $_SESSION['teacher_loggedin'][0]['id'];


$stm=$pdo->prepare("SELECT class_routine.class_name as class_id,class_routine.day,class_routine.subject_id,class_routine.teacher_id,class_routine.time_from,class_routine.time_to,class_routine.room_no,subjects.name as subject_name,subjects.code as subject_code,subjects.type as subject_type,class.class_name,teachers.name as teacher_name FROM class_routine 
INNER JOIN class ON class_routine.class_name=class.id
INNER JOIN subjects ON class_routine.subject_id=subjects.id
INNER JOIN teachers ON class_routine.teacher_id=teachers.id
WHERE class_routine.class_name=? AND class_routine.teacher_id=?
");
$stm->execute(array($class_id,$teacher_id));
$routine_list = $stm->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-kodi"></i>                 
    </span>
        <?php echo getClassName($class_id,'class_name');?> Routine
  </h3> 
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">   
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:20px;"><b>#</b></th> 
                            <th class="text-center"><b>Subject Name</b></th>  
                            <th class="text-center"><b>Teacher Name</b></th>  
                            <th class="text-center"><b>Day</b></th>  
                            <th class="text-center"><b>Time Form</b></th> 
                            <th class="text-center"><b>Time To</b></th> 
                            <th class="text-center"><b>Room No</b></th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                        foreach($routine_list as $list) :
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i;$i++;?></td>
                            <td class="text-center"><?php echo $list['subject_name']."-".$list['subject_code'];?></td>
                            <td class="text-center"><?php echo $list['teacher_name'];?></td>
                            <td class="text-center"><?php echo $list['day'];?></td>
                            <td class="text-center"><?php echo $list['time_from'];?></td>
                            <td class="text-center"><?php echo $list['time_to'];?></td>
                            <td class="text-center"><?php echo $list['room_no'];?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>




<?php require_once('footer.php'); ?>