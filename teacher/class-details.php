<?php require_once('header.php'); 



$class_id = $_GET['id'];
$teacher_id = $_SESSION['teacher_loggedin'][0]['id'];


$stm=$pdo->prepare("SELECT * FROM class WHERE id=?");
$stm->execute(array($class_id));
$details = $stm->fetchAll(PDO::FETCH_ASSOC);
$class_details = $details[0];

?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-kodi"></i>                 
    </span>
        <?php echo getClassName($class_id,'class_name');?> Details 
  </h3> 
</div>
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">   
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Class Name</td>
                            <td><?php echo $class_details['class_name']; ?></td>
                        </tr>
                        <tr>
                            <td>Subjects</td>
                            <td>
                            <?php 
                                // subject list decode
                                $subjectList = json_decode($class_details['subjects']);
                                foreach($subjectList as $newSubject) {
                                    echo getSubjectName($newSubject)." <br>";
                                }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Start Date</td>
                            <td><?php echo $class_details['start_date']; ?></td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td><?php echo $class_details['end_date']; ?></td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>




<?php require_once('footer.php'); ?>