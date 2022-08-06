<?php 
require_once('header.php'); 

if(isset($_POST['create_btn'])){
    $class_name = $_POST['class_name'];
    $subject_name = $_POST['subject_name'];
    $time_from = $_POST['time_from'];
    $time_to = $_POST['time_to'];
    $room_no = $_POST['room_no'];
    $day = $_POST['day'];
    // get teacher name form subjects table
    $teacher_id = getSubjectTeacher($subject_name);;

    if(empty($class_name)){
        $error = "Class name is required!!";
    }
    else if(empty($subject_name)){
        $error = "Subject name is required!!";
    }
    else if(empty($time_from)){
        $error = "Time from is required!!";
    }
    else if(empty($time_to)){
        $error = "Time to is required!!";
    }
    else{
        $insert = $pdo->prepare("INSERT INTO class_routine(class_name,subject_id,teacher_id,time_from,time_to,room_no) VALUES(?,?,?,?,?,?)");
        $insert->execute(array($class_name,$subject_name,$teacher_id,$time_from,$time_to,$room_no));

        $success = "Routine Create Success!";
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
                    <div class="alert alert-danger text-center"><?php echo $error;?></div>
                <?php endif;?>
                <?php if(isset($success)) :?>
                    <div class="alert alert-success text-center"><?php echo $success;?></div>
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
                            <option value="">Select class</option>
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

                    <!-- Select Day -->
                    <div class="form-group">
                        <label for="day">Select Day:</label> 
                        <select name="day" id="day" class="form-control">
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
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
                    
                    <button type="submit" name="create_btn" class="btn btn-gradient-primary mr-2">Create Routine</button> 
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
        
