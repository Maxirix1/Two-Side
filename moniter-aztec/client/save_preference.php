<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['letters'])) {
    // บันทึกตัวอักษรที่ผู้ใช้ตั้งค่าไว้
    $letters = explode(',', str_replace(' ', '', $_POST['letters'])); // แปลงเป็น array
    $_SESSION['preferredLetters'] = $letters; // เก็บใน session
    echo "<div><h1>บันทึกการตั้งค่าเรียบร้อย! </h1><a href='home.php' class='btn-donate'>หน้าแรก</a></div>";
} else {
    echo "กรุณาระบุตัวอักษรที่ต้องการจัดลำดับ";
}
?>

<html>
    <body>
    </body>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: "Prompt", sans-serif;
        text-decoration: none;
        text-align: center;
    }
    a {
        color: #041e3b;
        background-color: ;
        text-align: center;
    }
    div {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        margin-top: 40px;
        gap: 20px;
    }
    .btn-donate {
                --clr-font-main: hsla(0 0% 20% / 100);
                --btn-bg-1: hsla(194 100% 69% / 1);
                --btn-bg-2: hsla(217 100% 56% / 1);
                --btn-bg-color: hsla(360 100% 100% / 1);
                --radii: 0.5em;
                cursor: pointer;
                padding: 0.3em 1.4em;
                min-width: 120px;
                min-height: 44px;
                font-size: var(--size, 1rem);
                font-weight: 500;
                transition: 0.8s;
                background-size: 280% auto;
                background-image: linear-gradient(325deg,
                        var(--btn-bg-2) 0%,
                        var(--btn-bg-1) 55%,
                        var(--btn-bg-2) 90%);
                border: none;
                border-radius: var(--radii);
                color: var(--btn-bg-color);
                box-shadow:
                    0px 0px 20px rgba(71, 184, 255, 0.5),
                    0px 5px 5px -1px rgba(58, 125, 233, 0.25),
                    inset 4px 4px 8px rgba(175, 230, 255, 0.5),
                    inset -4px -4px 8px rgba(19, 95, 216, 0.35);
            }

            .btn-donate:hover {
                background-position: right top;
            }

            .btn-donate:is(:focus, :focus-visible, :active) {
                outline: none;
                box-shadow:
                    0 0 0 3px var(--btn-bg-color),
                    0 0 0 6px var(--btn-bg-2);
            }

            @media (prefers-reduced-motion: reduce) {
                .btn-donate {
                    transition: linear;
                }
            }
</style>

</html>