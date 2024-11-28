<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = json_decode(file_get_contents('setting.json'), true);
    $text = $data['text'] ?? "ข้อความเริ่มต้น";  // ใช้ข้อความเริ่มต้นหากไม่มีการตั้งค่า
    echo $text;
}
?>