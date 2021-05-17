<?php
  require('_function.php');

  // DBから1日の予約合計人数を取得
  $paxData = getPax($_GET['date']);

  // 日にちのデータ取得
  $dailyData = getDaily($_GET['date']);

  // メニューのデータ取得
  $menuData = getMenu($dailyData['menu_id']);

  // 残席数を計算
  $left = $menuData['max_pax'] - ($paxData['sum(guest_pax)'] + $paxData['sum(staff_pax)']);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ボート即時予約 入力画面</title>
    <link rel="stylesheet" href="https://unpkg.com/modern-css-reset/dist/reset.min.css" />
    <link rel="stylesheet" href="style.css">
  </head>
  <body class="resv_page">
    <form action="index.php" method="post">
      <h1><?=$_GET['date']?> <?=$menuData['menu_name']?></h1>
      <p>残り<?=$left?></p>
      <div class="fb table heading">
        <p>客</p>
        <p>スタッフ</p>
        <p></p>
      </div>
      <div class="fb table MB30">
        <p>
          <select name="guest_num" id="guest_num" class="select_box"></select>名
        </p>
        <p>
          <select name="staff_num" id="staff_num" class="select_box"></select>名
        </p>
      </div>
      <p><input type="submit" value="予約"></p>
      <input type="hidden" name="left" value="<?=$left?>" class="left">
    </form>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(function(){
        let left_total = $('.left').val();

        // 客・スタッフに残席数分のoptionタグを追加
        for(let i=0; i<=left_total; i++) {
          $('#guest_num').append($('<option>').html(i).val(i));
          $('#staff_num').append($('<option>').html(i).val(i));
        }

        // どちらかのoptionタグが選択されたら、定員を超えないようにもう一つのselectタグのoption数の上限を変更
        $('.select_box').on('change', function() {
          let this_id = $(this).attr('id');

          // 一旦すべて削除
          let that_id;
          if(this_id === 'guest_num')       that_id = 'staff_num';
          else if (this_id === 'staff_num') that_id = 'guest_num';

          let this_val = $('#' + this_id).val();
          let that_val = $('#' + that_id).val();
          let total_val = this_val + that_val;

          if($('#' + that_id).val() == 0) {
            $('.select_box#' + that_id + ' option').remove();

            let left_cal = left_total - $(this).val();
          
            // optionタグを追加
            for(let i=0; i<=left_cal; i++) {
              $('#' + that_id).append($('<option>').html(i).val(i));
            }
          }
            
          if(total_val > left_total)
            alert('定員を越えています。選択し直してください。');
        });
      });
    </script>
  </body>
</html>
