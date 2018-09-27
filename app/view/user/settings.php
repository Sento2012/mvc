<?=isset($data['error']) ? $data['error'] : ''; ?>
<form method="POST">
    Баланс: <?= $data['user']['user_balance']; ?><br>
    <input type="hidden" name="csrf" value="<?=\core\MVC::getCSRF(); ?>">
    <input type="text" name="amount" class="form-control"><br>
    <input type="submit" value="Списать">
</form>

