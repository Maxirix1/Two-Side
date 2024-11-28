<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>SETTING</title>
</head>

<body>
    <h2 class="text-3xl font-bold text-start bg-blue-500 px-10 py-2 text-white">Setting</h2>

    <div style="display: flex; margin-top: 20px;">
        <form action="save_preference.php" method="POST" class="px-60">
            <label for="letters">ลำดับการแสดง:</label>
                <input type="text" class="border-2" id="letters" name="letters" placeholder="เช่น N, AD, G" required>
                <button type="submit" class="btn-donate">SAVE</button>

            <script src="https://cdn.tailwindcss.com"></script>

            <style>
                @import url("https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

                * {
                    box-sizing: border-box;
                    margin: 0;
                    padding: 0;
                    font-family: "Prompt", sans-serif;
                }

                input {
                    padding: 0.6em 1.4em;
                    border-radius: 10px;
                }

                /* From Uiverse.io by Allyhere */
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
        </form>
        <form id="setting-text">
            <label for="text">ชื่อโรงพยาบาล :</label>
            <input type="text" class="border-2" id="text" name="text" placeholder="ชื่อ โรงพยาบาล">
            <!-- <input type="text" id="text" name="text"> -->
            <button type="submit" class="btn-donate">SAVE</button>
        </form>

    </div>

    <script>
        $('#setting-text').ready(function () {
            $('#setting-text').submit(function (e) {
                e.preventDefault();

                var newText = $('#text').val();

                $.ajax({
                    url: 'save_text.php',
                    type: 'POST',
                    data: { text: newText },
                    success: function (response) {
                        Swal.fire({
                            title: "Success!",
                            text: "เปลี่ยนแปลงสำเร็จ",
                            icon: "correct"
                        });
                        $('#text').val('');
                    },

                    error: function () {
                        Swal.fire({
                            title: "Error!",
                            text: "เปลี่ยนแปลงไม่สำเร็จ",
                            icon: "error"
                        });
                    }
                })
            })
        })
    </script>
</body>

</html>