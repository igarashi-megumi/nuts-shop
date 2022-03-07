<?php require "header.php";?>
<?php require "menu.php";?>

<?php require 'connect.php';?>

<?php
 $sql=$pdo->prepare('SELECT *
                     FROM `product`
                     where id=?');
 //var_dump()
 $sql->execute([$_REQUEST['id']]);

 foreach ($sql as $row) {  //配列ではない,特殊なオブジェクト,表の格好=2次元配列
                           //表から行を取り出してる
  //sqlは1行しか無いが、2次元の格好をしている
  //ループは1回しかしない 
  //3 ひまわりの種 210
?>


 <P>

 <?php
  //ここでファイルの存在を調べる あれば表示 分岐

  if( file_exists("image/$row[id].jpg")){

?>
  <img src="image/<?=$row['id']?>.jpg">
  
<?php //ここでDBから取り出したシリアライズがあるかどうか調べる
      //あればアンシリアライズして,配列を回して画像を表示する
  }

   if( !empty($row['images'])){
      $product_imgs = unserialize($row['images']);
      foreach( $product_imgs as $product_img){
?>

    <img src="../admin/<?=$product_img?>" alt=""
      style="width:200px;height:auto">   
     
<?php
    } //画像のループend
 } //親のforeach end

?>

</p>
 <form action = "cart-insert.php" method="post">
 <p>商品番号:<?=$row['id']?></p>
 <p>商品名:<?=$row['name']?></p>
 <P>価格:<?=$row['price']?></p>
 <p>個数:<select name="count">
 
 <?php
 for($i=1; $i<=10; $i++){
?>
<option value="<?=$i?>"><?=$i?></option>
<?php } //for end ?> 
 </select></p>
<!-- 隠しフィールド -->
 <input type="hidden" name="id" value="<?=$row['id']?>">
 <input type="hidden" name="name" value="<?=$row['name']?>">
 <input type="hidden" name="price" value="<?=$row['price']?>">

<p><input type="submit" value="カートに追加"></p>
 </form>
 <p>

<?php
// ログインしてたら
 if (isset($_SESSION['customer']['id'])) {
  //この商品がfaoriteテーブルにあるか調べる
  $sql =	$pdo->query(
   "SELECT count(*) 
    FROM favorite 
    WHERE customer_id = {$_SESSION['customer']['id']}
    AND product_id = $_REQUEST[id]"); //()で囲めば['id']'はついていなくていい
  $count = $sql->fetch();
  // var_dump( $count );
 if( $count["count(*)"] === 0 ){ 
?>

<p><a href="favorite-insert.php?id=<?=$row['id']?>">☆お気に入りに追加</a></p>

<?php } else { ?>

<p><a href="favorite-insert.php?id=<?=$row['id']?>">🌟お気に入りを解除</a></p>

<?php } // if end
   } // if ログインしてない
  }
?>

<?php require "footer.php";?>