<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_text =  $_POST['text'];

    $data = ['text' => htmlspecialchars($new_text)];
    file_put_contents('setting.json', json_encode($data));

    echo "บันทึกข้อมูลสำเร็จ";
}
?>