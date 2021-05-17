<?php
  require('_function.php');

  // DBから日にち毎の予約データをすべて取得
  $resvData = getResv();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ボート即時予約 一覧</title>
    <link rel="stylesheet" href="https://unpkg.com/modern-css-reset/dist/reset.min.css" />
    <link rel="stylesheet" href="style.css">
  </head>
  <body class="top_page">
    <h1>ボート即時予約</h1>
    <div class="fb table heading">
      <p>日にち</p>
      <p>メニュー</p>
      <p>船長</p>
      <p>客</p>
      <p>スタッフ</p>
      <p>定員</p>
      <p>空席</p>
    </div>
    <?php
    if(!empty($resvData)){
      foreach($resvData['data'] as $key => $val){

        // 日にちのデータを1件取得
        $dailyData = getDaily($val['date']);

        // メニューのデータを1件取得
        $menuData = getMenu($dailyData['menu_id']);
    ?>
    <div class="fb table">
      <p><?=$val['date']?></p>
      <p><?=$menuData['menu_name']?></p>
      <p><?=$dailyData['captain']?></p>
      <p><?=$val['sum(guest_pax)']?></p>
      <p><?=$val['sum(staff_pax)']?></p>
      <p><?=$menuData['max_pax']?></p>
      <?php
        $btn_display = 0;
        $totalPax = $val['sum(guest_pax)'] + $val['sum(staff_pax)'];
        if($totalPax >= $menuData['max_pax']){
          echo '<p class="red">満席</p>';
          $btn_display = 1;
        }
        else {
          $left = $menuData['max_pax'] - $totalPax;
          echo "<p>残り".$left."</p>";
        }
      ?>
      <a href="resv.php?date=<?=$val['date']?>" class="link <?php if($btn_display === 1) echo "display_none"; ?>"><p class="link_btn">予約する</p></a>
    </div>
    <?php
      }
    }
    ?>
  </body>
</html>
