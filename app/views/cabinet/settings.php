<h1>Настройки</h1>

<div id="settings-form">
    <form action='/me/update' method="POST">
        <label class="form-label" for="name">Имя:</label>
        <input class="form-input" type="text" id="name" name="name" value="<?= $_SESSION['user_name'] ?>" required>

        <label class="form-label" for="email">Email:</label>
        <input class="form-input" type="email" id="email" name="email" value="<?= $_SESSION['user_email'] ?>" required>

        <label class="form-label" for="password1">Ваш пароль:</label>
        <input class="form-input" type="password" id="password1" name="old_password" required>
        
        <label class="form-label" for="password2">Новый пароль:</label>
        <input class="form-input" type="password" id="password2" name="new_password">

        <button class="cinema-btn" type="submit">Сохранить</button>
        <?php if (isset($error)) echo $error ?>
    </form>
</div>