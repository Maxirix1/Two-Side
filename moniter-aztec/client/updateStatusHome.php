<?php 
include '../server/configdb.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['status_call']) && isset($_POST['id'])) {
        $status_call = $_POST['status_call'];
        $id = $_POST['id'];
        date_default_timezone_set('Asia/Bangkok');
        $currentDate = date('dmY');
        // $dateTH = date('d') . date('m') . (date('Y') + 543);
        $dateTH = '22112567';

        $sql = "UPDATE visit_info SET status_call = :status_call WHERE id = :id AND visit_date = :dateTH";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':dateTH', $dateTH);
        $stmt->bindParam(':status_call' , $status_call);
        $stmt->bindParam(':id' , $id);

        if($stmt->execute()) {
            echo "Status Update Success!";
        }else {
            echo "Error";
        }
    }
} 
?>