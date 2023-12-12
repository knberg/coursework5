<div id="overlay">
    <div id="modal">
        <div id="tabs">
            <button class="tab-btn" onclick="openTab('login-form')">Вход</button>
            <button class="tab-btn" onclick="openTab('registration-form')">Регистрация</button>
        </div>

        <div id="login-form" class="tab-content">
            <form onsubmit="handleLogin(event)">
            <label class="form-label" for="login-email">Email:</label>
            <input type="email" id="login-email" name="email" class="form-input" required>

            <label class="form-label" for="login-password">Пароль:</label>
            <input type="password" id="login-password" name="password" class="form-input" required>

            <button type="submit" class="cinema-btn">Войти</button>
            </form>
        </div>

        <div id="registration-form" class="tab-content">
            <form onsubmit="handleRegister(event)">
            <label class="form-label" for="reg-name">Имя:</label>
            <input type="text" id="reg-name" name="name" class="form-input" required>

            <label class="form-label" for="reg-email">Email:</label>
            <input type="email" id="reg-email" name="email" class="form-input" required>

            <label class="form-label" for="reg-password">Пароль:</label>
            <input type="password" id="reg-password" name="password" class="form-input" required>

            <label class="form-label" for="reg-confirm-password">Повторите пароль:</label>
            <input type="password" id="reg-confirm-password" name="confirm_password" class="form-input" required>

            <button type="submit" class="cinema-btn">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</div>