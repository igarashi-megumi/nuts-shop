<?php require 'header.php'; ?>
<?php require 'connect.php';?>

<?php
$sql = $pdo->prepare( 
  "SELECT count(*)
  FROM `favorite`
  WHERE `product_id` = ?"
);

$sql->execute( [$_REQUEST['id']] ) ;
$count1 = $sql->fetch();
/* フェッチ関数は結果が1行しか無いときに
  ループせず"配列"に変換する
*/

$sql = $pdo->prepare( 
  "SELECT count(*)
  FROM `purchase_detail`
  WHERE `product_id` = ?"
);

$sql->execute( [$_REQUEST['id']] ) ;
$count2 = $sql->fetch();

if( !empty($count1["count(*)"]) || !empty($count2["count(*)"])){
  echo"こちらの商品は削除できません。";
}else{
  //無いのでけしていい
  $sql=$pdo->prepare('delete from product where id=?');
  if ($sql->execute([$_REQUEST['id']])) {
    echo '削除に成功しました。';
  } else {
    echo '削除に失敗しました。';
  }
}	
    /*
    string(1) "1" bool(false)
    string(1) "3" bool(false)
      あってもなくても同じ値が返ってくる
    */ 
    // exit; // 中断(まだ消したくないので)
    
// foreach( $sql as $k => $val);
?>

<?php require 'footer.php';?>