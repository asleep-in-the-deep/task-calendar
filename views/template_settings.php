<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Календарь задач | Установка</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/calendar.png">
    <link href="emojihook.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            color: #51565d;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 20%;
            position: relative;
            left: 50%;
            transform: translate(-50%, 0);
        }
        h3 {
            margin-top: 10px;
            margin-bottom: 0px;
        }
        button {
            display: inline-block;
            width: 40%;
            margin: 10px 0;
            padding: 10px;
            background: #8BC34A;
            color: #fefefe;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            transition: border-radius linear 0.2s, width linear 0.2s;
        }
        select {
            display: inline-block;
            font-family: Montserrat;
            font-size: 14px;
            padding: 6px;
            color: #51565d;
            border: 1px solid lightgray;
            box-shadow: 0 2px 4px rgba(0,0,0,.3);
            outline: none;
            cursor: pointer;
        }
    </style>
    <script>
        $(document).ready(function() {
            if ($("#emoji").val() !== "native") $("#emoji").addClass("emoji")
            $("#emoji").change(function() {
                if ($("#emoji").val() === "native") {
                    $("#emoji").removeClass("emoji")
                } else {
                    $("#emoji").addClass("emoji")
                }
            })
        })
    </script>
</head>
<body>
<form method="POST">
    <div><h3>Настройки Эмодзи</h3></div>
    <div><p>Эмодзи </p><select id="emoji" name="emoji">
        <option value="native" class="native-emoji"<?= $config["emoji"]=="native"?" selected":"" ?>>Нативные (🐥 🦊 🍓 🦋 🐬 🐸 🌊 🔮 🐷 🐻 ⏱)</option>
        <option value="android" class="emoji"<?= $config["emoji"]=="android"?" selected":"" ?>>Ненативные (🐥 🦊 🍓 🦋 🐬 🐸 🌊 🔮 🐷 🐻 ⏱)</option>
    </select></div>
    <div><button>Обновить</button></div>
</form>
</body>
</html>
