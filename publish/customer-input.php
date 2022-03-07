<?php session_start();?>
<?php require "header.php";?>
<?php require "menu.php";?>

<?php //空文字を代入
$name='';
$address='';
$email='';
$login='';
$password='';

if (isset($_SESSION['customer'])) {
    $name=$_SESSION['customer']['name'];
    $address=$_SESSION['customer']['address'];
    $email=$_SESSION['customer']['email'];
    $login=$_SESSION['customer']['login'];

echo '変更したい項目を変更して入力してください。';
?>

<form action="customer-output.php" method="post">
  
 <table>
 <tr><td>お名前(*)</td><td>
 <input type="text" name="name" value="<?=$name?>"required>
</td></tr>

<tr><td>ご住所(*)</td><td>
    <input type="text" name="address" value="<?=$address?>"required>
</td></tr>

<tr><td>メールアドレス(*)</td><td>
    <input type="email" name="email" value="<?=$email?>"required>
</td></tr>


<tr><td>ログイン名(*)</td><td>
<input type="text" name="login" value="<?=$login?>"required>
</td></tr>

<tr><td>パスワード(*)</td><td>
<input type="password" name="password" value="<?=$password?>"required>
</td></tr>

</table>

<input type="submit" value="変更">
</form>

<?php
 } else {
  echo '会員情報を変更するには、ログインしてください。';

} ?>

<?php require "footer.php";?>