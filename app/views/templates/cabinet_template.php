<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/128/2217/2217611.png">
    <link rel="stylesheet" type="text/css" href="/public/css/cabinet.css">
    <title><? echo $title ?></title>
</head>
<body>
    <input type="checkbox" id="toggle-btn">
    <div id="sidebar">
        <a href="/"><div class="logo">TICKET BOOKING</div></a>
        <div id="profile">
            <img id="avatar" src="https://marketing.junior-it.ru/img/lessons/0a1d85b4078c7277215d814dde686b78.jpg" alt="Avatar">
            <div id="user-info">
                <div class="user-name"><? echo $_SESSION['user_name'] ?></div>
                <div class="user-email"><? echo $_SESSION['user_email'] ?></div>
            </div>
        </div>
        <div id="menu">
            <a href="/me/orders">Мои билеты</a>
            <a href="/me/settings">Настройки</a>
            <a href="/logout">Выход</a>
        </div>
    </div>

    <div id="main">
        <label id="toggle-btn-label" for="toggle-btn">&#9776;</label>

        <?php include VIEW_PATH . $content . '.php' ?>

    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('main');

        document.getElementById('toggle-btn').addEventListener('change', function() {
            sidebar.style.display = this.checked ? 'none' : 'block';
            main.style.marginLeft = this.checked ? '0' : '300px';
        });
    </script>
</body>
</html>
