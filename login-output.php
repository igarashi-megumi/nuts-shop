<?php session_start();?>
<?php require "header.php";?>
<?php require "menu.php";?>

<?php
unset($_SESSION['customer']);?>

<?php require 'connect.php';?>

<?php
$sql=$pdo->prepare('select * from customer where login=?');
$sql->execute([$_REQUEST['login']]);
//,$_REQUEST['password']

foreach ($sql as $row) {
  //$rowは行データ loginで選択しいたので1行しかない
  if (password_verify($_REQUEST['password'],$row['password'])) {
                                                 //↑DBのフィールド名
   //tureならセッションに入れる
   $_SESSION['customer']=[
     'id'=>$row['id'],
     'name'=>$row['name'],
     'address'=>$row['address'],
     'email'=>$row['email'],
     'login'=>$row['login'],
     ];
    } //if end
  }// foreach end
    
 if (isset($_SESSION['customer'])) {
   echo 'いらっしゃいませ、',
        $_SESSION['customer']['name'],'さん。
        <meta http-equiv="refresh" content="1;URL=index.php">';

} else {
    echo 'ログイン名またはパスワードが違います。';
}
?>

<?php require "footer.php";?>