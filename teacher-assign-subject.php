<?php 
require_once('header.php'); 

?>


<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple"></i>                 
    </span>
   Assign Subject &nbsp; &nbsp; <a class="btn btn-sm btn-info" href="teacher-new-assign.php">New Assign</a>
  </h3> 
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body"> 
                <table class="table table-bordered" id="teacher_table">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Teacher Name</th>
                        <th class="text-center">Subject Name</th>
                        <th class="text-center">Subject Code</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $stm = $pdo->prepare("SELECT assign_teachers.id,assign_teachers.teacher_id,assign_teachers.subject_id,teachers.name as teacher_name,subjects.name as subject_name,code FROM assign_teachers 
                    INNER JOIN teachers ON assign_teachers.teacher_id = teachers.id
                    INNER JOIN subjects ON assign_teachers.subject_id = subjects.id 
                    ");
                    $stm->execute();
                    $assignList = $stm->fetchAll(PDO::FETCH_ASSOC); 
                    $i=1;
                    foreach($assignList as $list) :
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i;$i++;?></td>
                        <td class="text-center"><?php echo $list['teacher_name'];?></td>
                        <td class="text-center"><?php echo $list['subject_name'];?></td>
                        <td class="text-center"><?php echo $list['code'];?></td>
                        <td class="text-center">
                            <a href="" class="btn btn-sm btn-warning"><i class="mdi mdi-table-edit "></i></a>&nbsp;
                            <a href="" class="btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
                </table>
            </div>
        </div>   
    </div>
</div>

<?php require_once('footer.php'); ?>
        
