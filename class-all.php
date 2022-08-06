<?php 
require_once('header.php'); 

?>


<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-library menu-icon"></i>                 
    </span>
   All Class
  </h3> 
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body"> 
                <table class="table table-bordered" id="teacher_table">
                    <thead>
                      <tr>
                        <th class="text-center" style="width:15px;">#</th>
                        <th class="text-center">Class Name</th>
                        <th class="text-center">Start</th>
                        <th class="text-center">End</th>
                        <th class="text-center">Subjects</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $stm = $pdo->prepare("SELECT * FROM class ORDER BY id DESC");
                            $stm->execute();
                            $classList = $stm->fetchAll(PDO::FETCH_ASSOC);
                            $i=1;
                            foreach($classList as $class):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i; $i++; ?></td>
                            <td class="text-center"><?php echo $class['class_name'] ; ?></td>
                            <td class="text-center"><?php echo date('d-m-Y', strtotime($class['start_date']))  ;?></td>
                            <td class="text-center"><?php echo date('d-m-Y', strtotime($class['end_date']))  ;?></td>
                            <td class="text-center"><?php 
                            // subject list decode
                            $subjectList = json_decode($class['subjects']);
                            foreach($subjectList as $newSubject) {
                                echo getSubjectName($newSubject)." <br>";
                            }
                            ?>
                            </td>

                            <td class="text-center">
                            <a href="" class="btn btn-sm btn-warning"><i class="mdi mdi-brush"></i></a>&nbsp
                            <a href="" class="btn btn-sm btn-success"><i class="mdi mdi-eye"></i></a>&nbsp
                            <a href="" class="btn btn-sm btn-danger"><i class="mdi mdi-delete "></i></a>
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
        
