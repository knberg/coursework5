<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/128/2217/2217611.png">
    <title><? echo $title ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/public/css/home.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
        <a class="navbar-brand" href="/">TICKET BOOKING</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Билеты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/kids">Детям</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contacts">Контакты</a>
                </li>

                <? if (checkUserRole('admin')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/admin">Панель администратора</a>
                </li>
                <? endif ?>

                <? if (checkAuthorization()): ?>

                <li class="nav-item">
                    <a class="nav-link" href="/me">Личный кабинет</a>
                </li>

                <? else: ?>

                <li class="nav-item">
                    <button class="cinema-btn" onclick="openModal()">Войти</button>
                </li>

                <? endif ?>
            </ul>
        </div>
    </nav>

    <main>
    
    <?php include VIEW_PATH . $content . '.php' ?>

    </main>

    <footer>
        <div class="container">
            <div class="footer-columns">
                <div class="footer-column">
                    <h4>Клиентам</h4>
                    <div class="footer-links">
                        <a href="#">Правила посещения</a>
                        <a href="#">Бронирование билетов</a>
                        <a href="#">Возврат билетов</a>
                    </div>
                </div>
                <div class="footer-column">
                    <h4>Бизнесу</h4>
                    <div class="footer-links">
                        <a href="#">Ограничения</a>
                        <a href="#">Схемы залов</a>
                        <a href="#">Личный кабинет</a>
                    </div>
                </div>
                <div class="footer-column">
                    <h4>Личный кабинет</h4>
                    <div class="footer-links">
                        <a href="#">Программа лояльности</a>
                        <a href="#">Партнёрская программа</a>
                        <a href="#">Акции</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyright">&copy; 2023 Курсовая. Все права защищены.</div>

    <?php include VIEW_PATH . 'home/auth_form.php' ?>

    <script src="/public/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>