<?php
session_start();
require_once '../server/configdb.php';

$date = date('d');
$month = date('m');
$year = date('Y') + 543;

$date = $day . $month . $year;

try {
    // $department = 'ห้องตรวจโรคทั่วไป';
    $sql = "SELECT * FROM visit_info WHERE visit_date = '31102567' AND status = 'รอ'  ORDER BY CONVERT(INT, waitting_q) ASC ";
    $stmt = $conn->prepare($sql);
    // $stmt->bindParam("department", $department);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql_ready = "SELECT * FROM visit_info WHERE visit_date = '31102567' AND status = 'กำลัง' AND department = 'นรีเวช'";
    $stmt_ready = $conn->prepare($sql_ready);
    $stmt_ready->execute();
    $popup = $stmt_ready->fetch(PDO::FETCH_ASSOC);

    $sql_room = "SELECT * FROM visit_info WHERE visit_date = '31102567' AND department = 'ห้องตรวจ' AND status = 'รอ' ORDER BY CONVERT(INT, waitting_q) ASC";
    $stmt_room = $conn->prepare($sql_room);
    $stmt_room->execute();
    $room = $stmt_room->fetchAll(PDO::FETCH_ASSOC);

    $sql_roomR = "SELECT * FROM visit_info WHERE visit_date = '31102567' AND department = 'ห้องตรวจ' AND status = 'กำลัง'";
    $stmt_roomR = $conn->prepare($sql_roomR);
    $stmt_roomR->execute();
    $roomR = $stmt_roomR->fetch(PDO::FETCH_ASSOC);

    $sql_q = "SELECT * FROM visit_info WHERE status = 'ข้าม' AND visit_date = '31102567' AND department = 'นรีเวช'";
    $stmt = $conn->prepare($sql_q);
    $stmt->execute();
    $row_q = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo '<div class="alert alert-danger" role="alert">เกิดข้อผิดพลาด: ขออภัยในความไม่สะดวก' . $e->getMessage() . '</div>';
}
function getColorClass($waitting_q)
{
    if ($waitting_q >= 0 && $waitting_q <= 3) {
        return 'text-red-600';
    } elseif ($waitting_q >= 4 && $waitting_q <= 6) {
        return 'text-amber-400';
    } else {
        return 'text-green-400';
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AZTEC | Moniter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./style/style.css">
</head>

<body class="bg-[#dff4f7]">
    <header class="flex items-center justify-between bg-[#fff] m-6 p-2 px-6 rounded-xl">
        <div class="flex items-center justify-center gap-4">
            <img src="./assets/logo_hospitol.png" alt="" class="w-16">
            <h1 class="text-5xl font-bold">โรงพยาบาล</h1>
        </div>
        <h1 class="text-5xl font-bold">แผนกอายุรกรรม</h1>
    </header>

    <div class="flex">
        <div class="flex gap-4 w-full items-start justify-end">
            <section class="m-2 mt-2 bg-[#fff] rounded-xl p-4 pr-0 flex">
                <div>
                    <h1 class="text-4xl my-2 font-semibold">โต๊ะซักประวัติ</h1>
                    <table class="table-auto w-full rounded-lg">
                        <thead class="bg-gray-200">
                            <tr class="text-gray-500 text-start">
                                <th class="px-4 py-2">
                                    <div class="inline-flex items-start justify-start gap-2">
                                        <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 5h6m-6 4h6M10 3v4h4V3h-4Z" />
                                        </svg>
                                        หมายเลข
                                    </div>
                                </th>
                                <th class="px-4 py-2 pl-16 text-start">
                                    <div class="inline-flex items-start justify-start gap-2 text-start">
                                        <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-width="2"
                                                d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        ชื่อ-นามสกุล
                                    </div>
                                </th>
                                <th class="pr-4 py-2">
                                    <div class="inline-flex items-start justify-start gap-2 text-start">
                                        <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        เวลาที่รอ
                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($rows) {
                                foreach ($rows as $row) {
                                    $color = getColorClass($row['waitting_q']);

                                    echo '
                                        <tr class="text-start border-t font-semibold text-2xl">
                                            <td class="px-4 py-4 text-center font-bold text-[#042e5c]">' . htmlspecialchars($row['visit_q_no']) . '</td>
                                            <td class="px-4 py-4">' . htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['surname']) . '</td>
                                            <td class="px-4 py-4 text-center font-bold ' . $color . '">' . htmlspecialchars($row['waitting_q']) . ' คิว</td>
                                        </tr>';
                                }
                            } else {
                                echo '<tr>    <td colspan="3" class="text-center px-4 py-2">ไม่มีข้อมูล</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <aside class="p-6 m-2 rounded flex flex-col gap-6 pt-16"
                    style="width: 360px; background: rgb(23,139,63); background: linear-gradient(90deg, rgba(23,139,63,1) 10%, rgba(9,117,28,1) 100%);">
                    <h1 class="text-4xl font-semibold text-white">
                        กำลังเข้ารับบริการ
                    </h1>

                    <?php

                    if ($popup) {

                        preg_match('/([A-Z]+)(\d+)/', $popup['visit_q_no'], $matchs);
                        $prefix = isset($matchs[1]) ? $matchs[1] : '';
                        $number = isset($matchs[2]) ? $matchs[2] : '';

                        echo '<div class="contentPopup text-start bg-white rounded-3xl p-6 flex items-center justify-between" id="popup">
                                <div class="flex flex-col text-start">
                                    <h3 class="text-4xl text-green-700 font-semibold">' . htmlspecialchars($popup['station']) . '</h3>
                                    <h3 class="text-4xl font-semibold mt-2">' . htmlspecialchars($popup['name']) . ' ' . htmlspecialchars($popup['surname']) . '</h3>
                                </div>

                                <div class="bg-orange-500 p-4 w-[100px] h-[100px] text-center items-center flex justify-center rounded-2xl">
                                    <h1 class="text-white text-3xl font-bold"><span class="text-4xl">' . htmlspecialchars($prefix) . '</span><br>' . htmlspecialchars($number) . '</h1>
                                </div>
</div>';
                    }

                    if ($row_q) {
                        $counter = 1;
                        foreach ($row_q as $rowq) {
                            preg_match('/([A-Z]+)(\d+)/', $rowq['visit_q_no'], $matchs);
                            $prefix = isset($matchs[1]) ? $matchs[1] : '';
                            $number = isset($matchs[2]) ? $matchs[2] : '';

                            echo '<div class="text-start bg-white rounded-xl p-4 flex items-center justify-between">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">โต๊ะซักประวัติ ' . $counter . '</p>
                            <h3 class="text-2xl font-bold mt-2">' . htmlspecialchars($rowq['name']) . ' ' . htmlspecialchars($rowq['surname']) . '</h3>
                        </div>
                        <div class="bg-orange-500 p-4 w-[100px] h-[100px] text-center items-center flex justify-center rounded-lg">
                            <h1 class="text-white text-3xl font-bold"><span class="text-3xl">' . htmlspecialchars($prefix) . '</span><br>' . htmlspecialchars($number) . '</h1>
                        </div>
                    </div>';
                            $counter++;
                        }
                    }
                    ?>

                </aside>
            </section>
        </div>
        <div class="flex gap-4 w-full items-start justify-start">
            <section class="m-2 mt-2 bg-[#fff] rounded-xl p-4 pr-0 flex">
                <div>
                    <h1 class="text-4xl my-2 font-semibold">ห้องตรวจ</h1>
                    <table class="table-auto w-full rounded-lg">
                        <thead class="bg-gray-200">
                            <tr class="text-gray-500 text-start">
                                <th class="px-4 py-2">
                                    <div class="inline-flex items-start justify-start gap-2">
                                        <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 5h6m-6 4h6M10 3v4h4V3h-4Z" />
                                        </svg>
                                        หมายเลข
                                    </div>
                                </th>
                                <th class="px-4 py-2 pl-16 text-start">
                                    <div class="inline-flex items-start justify-start gap-2 text-start">
                                        <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-width="2"
                                                d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        ชื่อ-นามสกุล
                                    </div>
                                </th>
                                <th class="pr-4 py-2">
                                    <div class="inline-flex items-start justify-start gap-2 text-start">
                                        <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        เวลาที่รอ
                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            if ($room) {
                                foreach ($room as $row) {
                                    $color = getColorClass($row['waitting_q']);

                                    // ตรวจสอบว่า status เท่ากับ 'กำลัง' และเรียก showPopup
                            

                                    echo '
            <tr class="text-start border-t font-semibold text-2xl">
                <td class="px-4 py-4 text-center font-bold text-[#042e5c]">' . htmlspecialchars($row['visit_q_no']) . '</td>
                <td class="px-4 py-4">' . htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['surname']) . '</td>
                <td class="px-4 py-4 text-center font-bold ' . $color . '">' . htmlspecialchars($row['waitting_q']) . ' คิว</td>
            </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3" class="text-center px-4 py-2">ไม่มีข้อมูล</td></tr>';
                            }
                            ?>


                        </tbody>
                    </table>
                </div>
                <aside class="p-6 m-2 rounded flex flex-col gap-6 pt-16"
                    style="width: 360px; background: rgb(23,139,63); background: linear-gradient(90deg, rgba(23,139,63,1) 10%, rgba(9,117,28,1) 100%);">
                    <h1 class="text-4xl font-semibold text-white">
                        กำลังเข้ารับบริการ
                    </h1>


                    <?php

                    if ($roomR) {

                            preg_match('/([A-Z]+)(\d+)/', $roomR['visit_q_no'], $matchs);
                            $prefix = isset($matchs[1]) ? $matchs[1] : '';
                            $number = isset($matchs[2]) ? $matchs[2] : '';

                            echo '<div class="contentPopup text-start bg-white rounded-3xl p-6 flex items-center justify-between" id="popuproom">
            <div class="flex flex-col text-start">
                <h3 class="text-4xl text-green-700 font-semibold">' . htmlspecialchars($roomR['station']) . '</h3>
                <h3 class="text-4xl font-semibold mt-2">' . htmlspecialchars($roomR['name']) . ' ' . htmlspecialchars($roomR['surname']) . '</h3>
            </div>

            <div class="bg-orange-500 p-4 w-[100px] h-[100px] text-center items-center flex justify-center rounded-2xl">
                <h1 class="text-white text-3xl font-bold"><span class="text-4xl">' . htmlspecialchars($prefix) . '</span><br>' . htmlspecialchars($number) . '</h1>
            </div>
</div>';
                    }
                    ?>
                </aside>
            </section>
        </div>
    </div>

    <footer class="bg-[#0a4a0d]">
        <h2 class="text-3xl font-semibold">(ข้อความวิ่งแจ้งเตือนคิวเรียกซ้ำ) A020 โต๊ะซักประวัติ</h2>
    </footer>
</body>

</html>