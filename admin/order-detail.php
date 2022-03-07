
<?php require 'header.php'; ?>
<?php require 'connect.php'; ?>




<style>
.row{
  display: flex;
}
aside{
  width:25%;
}
main{
   width:75%;
}
</style>



<div class="row">
   <aside>
    <?php require 'sidebar.php'; ?>
   </aside>
  <main>

  

<?php

if(empty($_GET['id'])) exit("<p>注文番号がありません!");


$sql = "SELECT purchase_id ,product_id, name
, count ,price,count * price AS shokei
FROM `purchase_detail` AS d
LEFT JOIN purchase AS p ON purchase_id = p.id
LEFT JOIN product as s ON product_id = s.id
WHERE purchase_id = ?";


//サニタイズする
$id=htmlspecialchars($_GET['id'],ENT_QUOTES);

 $sql_purchase = $pdo->prepare( $sql );
 $sql_purchase->bindValue(1, $id, PDO::PARAM_INT);
  //セキュリティ的に推奨されるSQL文の実行方法
 $sql_purchase->execute();

?>



<h2>注文詳細</h2>
 <table>
   <tr>
     <th>商品番号</th><th>商品名</th><th>価格</th><th>個数</th><th>小計</th>
   </tr>



<?php
  foreach ($sql_purchase as $row_detail) {

?>

 <tr>
      <td><?=$row_detail['product_id']?></td>
      <td><?=$row_detail['name']?></td>
      <td><?=$row_detail['price']?></td>
      <td><?=$row_detail['count']?></td>
      <td><?=$row_detail['shokei']?></td>
  <?php
			  $subtotal=$row_detail['price']*$row_detail['count'];
			  $total+=$subtotal;
			?>
		</tr>


<?php } //foreach end ?>

<tr>
			 <td colspan="4">合計</td>
			 <td><?= $total ?></td>
</tr>

   </table>
	</main>
</div>
<?php require 'footer.php'; ?>