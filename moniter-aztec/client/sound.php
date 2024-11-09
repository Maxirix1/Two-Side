<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResponsiveVoice.js Example</title>
    <script src="https://code.responsivevoice.org/responsivevoice.js"></script>
</head>
<body>
    <h1>ResponsiveVoice.js ตัวอย่างการใช้งาน</h1>
    <textarea id="text-to-speak" rows="4" cols="50">คุณ ภูวดลกัสปะ เชิญที่โต๊ะซักประวัติ 1 ค่ะ</textarea><br>
    <button onclick="speak()">พูด</button>

    <script>
        function speak() {
            var text = document.getElementById("text-to-speak").value;
            responsiveVoice.speak(text, "Thai Female");
        }
    </script>
</body>
</html>
