<?php 
require_once('header.php'); 

?>


<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-kodi "></i>                 
    </span>
    Assigned Class Routine
  </h3> 
</div>
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body"> 
                
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th class="text-center">Class Name</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $teacher_id = $_SESSION['teacher_loggedin'][0]['id'];
                            $stm = $pdo->prepare("SELECT DISTINCT class_name FROM class_routine WHERE teacher_id=? ORDER BY class_name ASC");
                            $stm->execute(array($teacher_id));
                            $classList = $stm->fetchAll(PDO::FETCH_ASSOC);

                            $i=1;
                            foreach($classList as $list):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i; $i++; ?></td>
                            <td class="text-center"><?php echo getClassName($list['class_name'],'class_name') ;?></td>
                            <td class="text-center">
                            <a href="routine-details.php? id=<?php echo $list['class_name'] ;?>" class="btn btn-sm btn-success"><i class="mdi mdi-eye"></i>View Class Routine</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>   
    </div>
</div>

<?php require_once('footer.php'); ?>
        
