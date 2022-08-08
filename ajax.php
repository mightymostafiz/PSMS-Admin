<?php 
require_once('config.php');

if(isset($_POST['class_id'])){
    $class_id = $_POST['class_id'];

    $stm = $pdo->prepare("SELECT subjects FROM class WHERE id=?");
    $stm->execute(array($class_id));
    $subject_ids = $stm->fetchAll(PDO::FETCH_ASSOC);
    $subject_ids = $subject_ids[0]['subjects'];

    $subjectList = json_decode($subject_ids);
    // $get_subject_list = [];
    // foreach($subjectList as $newSubject) {
    //     $get_subject_list[][$newSubject] = getSubjectName($newSubject);
    // }

    $get_subject_options = '';
    foreach($subjectList as $newSubject) {
        $get_subject_options .= '<option value="'.$newSubject.'">'.getSubjectName($newSubject).'</option>';
    }

    echo $get_subject_options;

}

// Studnets attendance ajax

if(isset($_POST['att_id'])){
    $class_id = $_POST['att_id']; 

    $stm=$pdo->prepare("SELECT subjects.name as subject_name,subjects.code as subject_code,subjects.id as subject_id  FROM class_routine  
    INNER JOIN subjects ON class_routine.subject_id=subjects.id 
    WHERE class_routine.class_name=?
    ");
    $stm->execute(array($class_id));
    $subject_list = $stm->fetchAll(PDO::FETCH_ASSOC);

    $get_subject_options = '';
    foreach($subject_list as $new_subject){
        $get_subject_options .= '<option value="'.$new_subject['subject_id'].'">'.$new_subject['subject_name'].'-'.$new_subject['subject_code'].'</option>';
         
    }  
    echo $get_subject_options ;
 
}

?>


