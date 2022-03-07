<?php session_start(); ?>
<?php require 'connect.php'; ?>


<?php
 
 if ( empty($_SESSION['customer'])){
  echo '<p>購入履歴を表示するには、ログインしてください。</p>';
  exit; //メッセージを出して処理を中断
  
} else if( empty( $_POST['purchase_id']) ){
  echo '<p>注文idがありません</p>';
  exit; //メッセージを出して処理を中断

 //customer_id は SESSIONから受け取る
 //purchase_id は POSTで受け取る

} else {

           //納品書の上半分で使うフィールド名を列挙
  $sql="SELECT p.id , name, address, customer_id , date 
        FROM purchase AS p 
        LEFT JOIN customer AS c 
        ON c.id=customer_id 
        WHERE p.id=? 
        AND customer_id=?";


  $sql_purchase = $pdo->prepare( $sql );
  $sql_purchase->execute([
       $_POST['purchase_id'],
       $_SESSION['customer']['id']]);

   $nohin_top = $sql_purchase->fetch();
    //echo '<pre>'; print_r( $nohin_top);
    
       //count は予約後,ahoke には小計が入る
  $sql="SELECT purchase_id, name , count , price
        , `count` * price as shoke 
        FROM purchase_detail as d
        LEFT JOIN product as p
        ON id=product_id
        WHERE purchase_id=?
        ORDER BY product_id";


  $sql_detail=$pdo->prepare($sql);
  $sql_detail->execute([$_POST['purchase_id']]);

   $tr = '';  //変数$trを空文字で初期化
   $total = 0 ;
   foreach( $sql_detail as $row){
     //$trに伝票の明細のいち業を連結代入
   $tr .= "<tr>
      <td>$row[purchase_id]</td>
      <td>$row[name]</td>
      <td>$row[price]</td>
      <td>$row[count]</td>
      <td>$row[shoke]</td>
    </tr>";
    $total += $row['shoke'];
  

   } // foreach end ?>




<style>
 table.bottom , .bottom td, .bottom th {
	border: 1px solid #595959;
	border-collapse: collapse;
  /*上のセルと下のセルを重ねる(2重線を1本にする)*/
}
td, th {
	padding: 3px;	
  width: 30px;
  height: 25px;}
th {
	background: #f0e6cc;
}
.even {
	background: #fbf8f0;
}
.odd {
	background: #fefcf9;
}
.top ,.bottom {
  width:600px;
  margin:auto;
}
table.bottom {   
  margin-top:70px;
}


</style>




<table class="top">

		<tr>
			<td> <h1>納品書</h1> </td>
      <td>伝票番号  <?=$nohin_top['id']?> </td>
		</tr>

		<tr>
			<td rowspan="3"></td>
			<td>受注年月日  <?=date('Y年m月d日',strtotime( $nohin_top['date']) )?> </td>
		</tr>

		<tr>
			<td></td>
		</tr>

		<tr>
			<td>お客様名 <?=$nohin_top['name']?> </td>
		</tr>

		<tr>
			<td>お客様コード <?=$nohin_top['customer_id']?> </td>
      <td>お届け先住所 <?=$nohin_top['address']?> </td>
		</tr>

</table>


<table class="bottom">

  <tr>
    <th>商品コード</th>
    <th>商品名</th>
    <th>単価</th>
    <th>数量</th>
    <th>小計</th>
  </tr>
    
    <?= $tr ?> 


 <tr>
 	  <td colspan="4">合計</td>
  	<td><?= $total ?></td>
 </tr> 
    <!-- 変数$trには完成した明細の複数行が入っているので,ここで出す-->

</table>

<?php } //if end ?>