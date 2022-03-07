<?php require  'header.php';?>


<style>
.container{
  display: flex;
}
aside{
  width:25%;
}
main{
   width:75%;
}


  </style>



<div class="container">
  <aside>
    <?php require 'sidebar.php'; ?>
  </aside>
  <main>

    <div class="th0">商品番号</div>
    <div class="th1">商品名</div>
    <div class="th1">商品価格</div>


<?php require 'connect.php';?>


<?php

if (isset($_REQUEST['command'])) {
	switch ($_REQUEST['command']) {
	case 'update':
		if (empty($_REQUEST['name']) || 
			!preg_match('/[0-9]+/', $_REQUEST['price'])) break;
		$sql=$pdo->prepare(
			'update product set name=?, price=? where id=?');
		$sql->execute(
			[htmlspecialchars($_REQUEST['name']), $_REQUEST['price'], 
			$_REQUEST['id']]);


	}
}     
 ?>     
 
 <?php
 foreach ($pdo->query('select * from product') as $row) {
 ?>
 
   <form class="ib" action="edit3.php" method="post">
   <input type="hidden" name="command" value="update">
   <input type="hidden" name="id" value="<?=$row['id']?>">
   <div class="td0">
   <?=$row['id']?>
   </div>
   <div class="td1">
   <input type="text" name="name" value="<?=$row['name']?>">
   </div>
   <div class="td1">
   <input type="text" name="price" value="<?=$row['price']?>">
   </div>
   <div class="td2">
   <input type="submit" value="更新">
   </div>
   </form>

<?php } ?>


  </main>
</div>

<?php require 'footer.php';?>