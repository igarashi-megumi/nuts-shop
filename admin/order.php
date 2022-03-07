<?php session_start(); ?>
<?php require  'header.php';?>
<?php require 'connect.php'; ?>


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




<?php
	
	$sql = "SELECT purchase_id, name, g.goke, date
	        FROM `purchase` AS p
	        LEFT JOIN `customer` AS c ON c.id = p.customer_id
	        LEFT JOIN ( 
	      	SELECT purchase_id ,sum(count * price) goke
	      	FROM `purchase_detail` as d
	      	LEFT JOIN `product` AS t ON t.id = d.product_id
	      	GROUP BY purchase_id
	      	ORDER BY purchase_id) 
					AS g ON p.id = g.purchase_id
	        ORDER BY date DESC
	        LIMIT 50";

	$sql_purchase = $pdo->prepare( $sql );
	$sql_purchase->execute();

?>



<h2>注文一覧</h2>
<table>
	<tr>
	 <th>注文番号</th><th>顧客名</th><th>合計金額</th><th>日付</th>
	</tr>
	




<?php
	foreach ($sql_purchase as $row_detail) {
?>

<tr>
 <td>
 <form action = "order-detail.php" method = "get">
	<a href="order-detail.php?id=
	     <?=$row_detail['purchase_id']?>"> 
	     <?=$row_detail['purchase_id']?> </a>
	</form>
 </td>
   
	    <td> <?=$row_detail['name']?> </td>
	  	<td><?=number_format($row_detail['goke'])?> </td>
			<td><?=$row_detail['date']?> </td>
</tr>

<?php }  //foreach end ?>
		
		</table>
	</main>
</div>
<?php require 'footer.php'; ?>
