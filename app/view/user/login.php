<form method="POST">
    <div class="form-group">
        <label>Логин</label>
        <input type="text" class="form-control" name="user_name">
    </div>
    <div class="form-group">
        <label>Пароль</label>
        <input type="password" class="form-control" name="user_pass">
    </div>
    <div class="form-group">
        <input type="submit" value="Войти" class="form-control">
    </div>
</form>
<a href="<?php echo WEB_ROOT; ?>user/registration">Регистрация</a>