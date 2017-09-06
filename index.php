<html>
<form method="POST">
    <label>Amount <input name="amount"/></label>
    <label>From <select name="from_account">
            <option>current</option>
            <option>premium</option>
        </select>
    </label>
    <label>From <select name="to_account">
            <option>current</option>
            <option>premium</option>
        </select>
    </label>
    <input type="submit" value="Transfer">
</form>
</html>

<?php
ini_set('display_errors', 1);
require_once 'vendor/autoload.php';

if (!$_POST) {
    exit;
}

$bank = new Bank();
try {
    $bank->transfer($_POST['amount'], $_POST['from_account'], $_POST['to_account']);
} catch (Exception $e) {
    echo sprintf('<div id="errors">%s</div>', $e->getMessage());
}
