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
   Add New Routine
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
                        <!-- Select Class  -->
                        <label for="class_name">Select Class</label>
                        <?php 
                            $stm = $pdo->prepare("SELECT id,class_name FROM class");
                            $stm->execute();
                            $lists = $stm->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <select name="class_name" id="class_name" class="form-control">
                            <?php foreach($lists as $list): ?>
                            <option value="<?php echo $list['id']; ?>"><?php echo $list['class_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Subject name select -->
                    <div class="form-group">
                        <label for="subject_name">Select Subject</label>

                        <select name="subject_name" id="subject_name" class="form-control">

                        </select>
                    </div>

                    <!-- Time -->
                    <div class="form-group">
                        <label for="time_from">Time From</label>
                        <input type="time" name="time_from" id="time_from" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="time_to">Time To</label>
                        <input type="time" name="time_to" id="time_to" class="form-control">
                    </div>

                    <!-- Room no -->
                    <div class="form-group">
                        <label for="room_no">Room No</label>
                        <input type="text" name="room_no" id="room_no" class="form-control">
                    </div>
                    
                    <button type="submit" name="create_btn" class="btn btn-gradient-primary mr-2">Assign Subject</button> 
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

<script>
    $('#class_name').change(function(){
        let class_id = $(this).val();
        
        $.ajax({
            type: "POST",
            url:'ajax.php',
            data: {
                class_id:class_id
            },
            success:function(response){
                let data = response;
                $('#subject_name').html(data);
                console.log(response);
            }
        });
    });
</script>
        
