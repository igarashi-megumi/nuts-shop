<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'connect.php'; ?>

<?php
if (isset($_SESSION['customer'] ,$_REQUEST['id'])) {
 
  $sql =	$pdo->query(
    "SELECT count(*) 
     FROM favorite 
	   WHERE customer_id = {$_SESSION['customer']['id']}
	   AND product_id = $_REQUEST[id]");
	$count = $sql->fetch();
		// var_dump( $count );
if( $count["count(*)"] === 0 ){

	$sql=$pdo->prepare('INSERT into favorite values(?,?)');
	$sql->execute([$_SESSION['customer']['id'], $_REQUEST['id']]);
			
	echo 'お気に入りに商品を追加しました。
	<hr>';
	require 'favorite.php';

} else {
	echo 'この商品は登録済みです｡';
}

} else {
	echo 'お気に入りに商品を追加するには、ログインしてください。';
}
?>
<?php require 'footer.php'; ?>