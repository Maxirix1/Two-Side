<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=y8x4yCdX"></script>
    <script>
        let lastSpokenText = "";
        let isSpeaking = false;
        let currentPopupId = null;

        function loadData() {
            $.ajax({
                url: 'load.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#historyTable').html(data.historyHtml);
                    $('#roomTable').html(data.roomHtml);
                    $('#popupRoom').html(data.popupRoom);
                    $('#waitroom').html(data.waitR);
                    $('#cross').html(data.crossData);

                    if (data.popupData && data.popupData.length > 0) {
                        popupData(data.popupData);
                    } else {
                        if (currentPopupId !== null) {
                            $('#popupTable').empty();
                            currentPopupId = null;
                        }
                    }

                    updateStation(data.stationData);
                    updateRoom(data.roomData);
                },
                error: function (xhr, status, error) {
                    console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
                }
            });
        }

        function popupData(popupData) {
            if (Array.isArray(popupData) && popupData.length > 0) {
                const data = popupData[0];

                if (currentPopupId !== data.id) {
                    currentPopupId = data.id;

                    const visitQNo = data.visit_q_no;
                    const prefix = visitQNo.charAt(0);
                    const numberPart = visitQNo.slice(1);
                    const numbers = numberPart.split('').map(num => num); // ['2', '5', '6']

                    const textSpeak = `ขอเชิญหมายเลข ${prefix}${numbers.join(', ')}  คุณ  ${data.name} ${data.surname} ${data.station} ค่ะ`;

                    console.log("ข้อความที่จะพูด:", textSpeak);

                    // อัปเดตข้อมูลใน popupTable
                    $('#popupTable').html(`
                <div class="contentPopup" id="popup">
                    <div class="Name">
                        <h3 style="color: rgb(9, 87, 41);">${data.station}</h3>
                        <h3 class="text-4xl font-semibold mt-2">${data.name} ${data.surname}</h3>
                    </div>
                    <div class="station-box-number-queue">
                        <h1 class="text-white text-3xl font-bold"><span class="text-4xl">${prefix}</span><br>${numbers.join('')}</h1>
                    </div>
                </div>
            `);

                    if (typeof responsiveVoice !== 'undefined') {
                        if (!isSpeaking) {
                            isSpeaking = true;
                            responsiveVoice.speak(textSpeak, "Thai Female", {
                                onend: function () {
                                    isSpeaking = false;
                                }
                            });
                            lastSpokenText = textSpeak;
                        }
                    } else {
                        console.error('ResponsiveVoice.js ไม่พร้อมใช้งาน');
                    }

                    setTimeout(function () {
                        $.ajax({
                            url: 'updateStatusHome.php',
                            type: 'POST',
                            data: {
                                status_call: '2',
                                id: data.id
                            },
                            success: function (response) {
                                console.log('อัปเดตสถานะสำเร็จ:', response);
                            },
                            error: function (xhr, status, error) {
                                console.error('Error updating status:', error);
                            }
                        });
                    }, 7000);
                }
            }
        }

        function updateStation(stationData) {
            document.querySelectorAll('.station-box').forEach(box => {
                box.querySelector('h3').innerHTML = '';
                box.querySelector('h1').innerHTML = '';
                box.querySelector('span').innerHTML = '';
            });

            stationData.forEach(data => {
                const stationNum = data.station.match(/\d+/);
                if (stationNum && stationNum[0]) {
                    const box = document.getElementById(`station-${stationNum[0]}`);
                    if (box) {
                        box.querySelector('h3').innerHTML = `${data.name} ${data.surname}`;
                        box.querySelector('h1').innerHTML = `${data.prefix}`;
                        box.querySelector('span').innerHTML = `${data.number}`;
                    }
                }
            });
        }

        function updateRoom(roomData) {
            document.querySelectorAll('.room-box').forEach(roomR => {
                roomR.querySelector('h3').innerHTML = '';
                roomR.querySelector('h1').innerHTML = '';
                roomR.querySelector('span').innerHTML = '';
            });

            roomData.forEach(data => {
                const roomNum = data.station.match(/\d+/);
                if (roomNum && roomNum[0]) {
                    const roomR = document.getElementById(`room-${roomNum[0]}`);
                    if (roomR) {
                        roomR.querySelector('h3').innerHTML = `${data.name} ${data.surname}`;
                        roomR.querySelector('h1').innerHTML = `${data.prefix}`;
                        roomR.querySelector('span').innerHTML = `${data.number}`;
                    }
                }
            });
        }

        $(document).ready(function () {
            loadData();
            setInterval(loadData, 1000); // ดึงข้อมูลทุกๆ 1 วินาที
        });



    </script>
</head>

<body class="bg-[#dff4f7]">
    <header class="flex items-center justify-between m-2 mx-2 p-2 px-6 rounded-xl mb-0">
        <div class="logo">
            <img src="./assets/logo_hospitol.png" alt="">
            <h1 class="hospitalText">โรงพยาบาล</h1>
        </div>
        <h1 class="departmentText">แผนก ตรวจทันตกรรม</h1>
    </header>

    <div class="mainContent">
        <div class="contentFlex">
            <section class="m-2 mt-2 bg-[#fff] rounded-xl p-4 pr-0 flex justify-center w-full">
                <div class="w-full">
                    <h1 class="text-3xl my-2 font-semibold">แผนกทันตกรรม</h1>
                    <table>
                        <thead class="Thead">
                            <tr class="rowThead">
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


                        <tbody id="historyTable">
                        </tbody>

                    </table>
                </div>

                <div id="popupTable"></div>

                <aside class="p-6 m-2 rounded flex flex-col gap-2 pt-4"
                    style=" background: rgb(23,139,63); background: linear-gradient(90deg, rgba(23,139,63,1) 10%, rgba(9,117,28,1) 100%);">
                    <h1 style="color: #fff; margin:5px;">
                        กำลังเข้ารับบริการ
                    </h1>

                    <!-- ----------------------------------------------BOX 1----------------------------------------- -->

                    <div class="station-box" id="station-1">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">โต๊ะซักประวัติ 1</p>
                            <h3 class="text-3xl font-bold"></h3>
                        </div>
                        <div class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div>

                    <!-- ----------------------------------------------BOX 1----------------------------------------- -->
                    <!-- ----------------------------------------------BOX 2----------------------------------------- -->

                    <!-- <div class="station-box"
                        id="station-2">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">โต๊ะซักประวัติ 2</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div
                            class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div> -->

                    <!-- ----------------------------------------------BOX 2----------------------------------------- -->
                    <!-- ----------------------------------------------BOX 3----------------------------------------- -->

                    <!-- <div class="station-box"
                        id="station-3">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">โต๊ะซักประวัติ 3</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div
                            class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div> -->

                    <!-- ----------------------------------------------BOX 3----------------------------------------- -->
                    <!-- ----------------------------------------------BOX 4----------------------------------------- -->

                    <!-- <div class="station-box"
                        id="station-4">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">โต๊ะซักประวัติ 4</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div
                            class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div> -->

                    <!-- ----------------------------------------------BOX 4----------------------------------------- -->
                    <!-- <div class="station-box"
                        id="station-4">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">โต๊ะซักประวัติ 5</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div
                            class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div>
                    <div class="station-box"
                        id="station-4">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">โต๊ะซักประวัติ 6</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div
                            class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div>
                    <div class="station-box"
                        id="station-4">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">โต๊ะซักประวัติ 7</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div
                            class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-sem   ibold"></span>
                        </div>
                    </div> -->
                    <div id="rowQ"></div>

                </aside>
            </section>
            <section class="m-2 mt-2 bg-[#fff] rounded-xl p-4 pr-0 flex justify-center w-full">
                <div class="w-full">
                    <h1 class="text-3xl my-2 font-semibold">ห้องตรวจทันตกรรม</h1>
                    <table>
                        <thead class="Thead">
                            <tr class="rowThead">
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


                        <tbody id="roomTable">
                        </tbody>

                    </table>
                </div>

                <!-- <div id="popup"></div> -->

                <aside class="p-6 m-2 rounded flex flex-col gap-2 pt-4"
                    style=" background: rgb(23,139,63); background: linear-gradient(90deg, rgba(23,139,63,1) 10%, rgba(9,117,28,1) 100%);">
                    <h1 style="color: #fff; margin:5px;">
                        กำลังเข้ารับบริการ
                    </h1>

                    <!-- ----------------------------------------------BOX 1----------------------------------------- -->

                    <div class="room-box" id="room-1">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">ห้องเบอร์ 1</p>
                            <h3 class="text-3xl font-bold"></h3>
                        </div>
                        <div class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div>

                    <!-- ----------------------------------------------BOX 1----------------------------------------- -->
                    <!-- ----------------------------------------------BOX 2----------------------------------------- -->

                    <div class="room-box" id="room-2">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">ห้องเบอร์ 2</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div>

                    <!-- ----------------------------------------------BOX 2----------------------------------------- -->
                    <!-- ----------------------------------------------BOX 3----------------------------------------- -->

                    <div class="room-box" id="room-3">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">ห้องเบอร์ 3</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div>

                    <!-- ----------------------------------------------BOX 3----------------------------------------- -->
                    <!-- ----------------------------------------------BOX 4----------------------------------------- -->

                    <div class="room-box" id="room-4">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">ห้องเบอร์ 4</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div>

                    <!-- ----------------------------------------------BOX 4----------------------------------------- -->
                    <div class="room-box" id="room-5">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">ห้องเบอร์ 5</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div>

                    <div class="room-box" id="room-6">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">ห้องเบอร์ 6</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div>

                    <div class="room-box" id="room-7">
                        <div>
                            <p class="text-2xl text-green-700 font-bold">ห้องเบอร์ 7</p>
                            <h3 class="text-3xl font-bold mt-2"></h3>
                        </div>
                        <div class="station-box-number">
                            <h1 class="text-white text-3xl font-bold"></h1>
                            <span class="text-3xl text-white font-semibold"></span>
                        </div>
                    </div>
                    <div id="rowQ"></div>

                </aside>
            </section>
        </div>

    </div>

    <footer class="bg-[#0a4a0d] py-2">
        <div class="footerBox flex">
            <div class="font-[500] flex" id="cross"></div>
        </div>
    </footer>
</body>

</html>