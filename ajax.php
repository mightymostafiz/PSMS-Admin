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

?>