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


		<table>
		<tr><th>商品番号</th><th>商品名</th><th>商品価格</th></tr>
		<?php
		// $pdo=new PDO('mysql:host=localhost;dbname=shop;charset=utf8', 
			// 'staff', 'password');
			require_once 'connect.php';
			$query = 'SELECT * 
								FROM product 
								WHERE name like ?';

		$sql=$pdo->prepare( $query );

		if( !empty($_REQUEST['keyword'])){
			$sql->execute(['%'.$_REQUEST['keyword'].'%']);
			
			foreach ($sql as $row) {
				echo '<tr>';
				echo '<td>', $row['id'], '</td>';
				echo '<td>', $row['name'], '</td>';
				echo '<td>', $row['price'], '</td>';
				echo '</tr>';
				echo "\n";
			} 
		} // end if
			?>
		</table>

 </main>  
</div>	
<?php require 'footer.php'; ?>