<?php 
require_once('header.php'); 

?>


<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-arrange-bring-forward"></i>                 
    </span>
   All Subject
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
                        <th class="text-center">Subject Name</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $stm = $pdo->prepare("SELECT * FROM subjects ORDER BY id DESC");
                            $stm->execute();
                            $subList = $stm->fetchAll(PDO::FETCH_ASSOC);
                            $i=1;
                            foreach($subList as $sub):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i; $i++; ?></td>
                            <td class="text-center"><?php echo $sub['name'] ; ?></td>
                            <td class="text-center"><?php echo $sub['code'] ; ?></td>
                            <td class="text-center"><?php echo $sub['type'] ; ?></td>

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
        
