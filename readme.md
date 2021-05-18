# 補足

## データベースについて
XAMPPやMAMPなどローカル環境上のphpMyAdminでデータベースを作る場合、import_table.txtをすべてコピーして、SQLを実行してください。以下のデータがインポートされます。

データベース: resv_boat

テーブル: menu
|  id  |  menu_name  |  max_pax  |
| ---- | ---- | ---- |
|  1  |  行き先1  |  25  |
|  2  |  行き先2  |  20  |
|  3  |  行き先3  |  15  |

テーブル: daily
|  id  |  date  |  menu_id  |  captain  |
| ---- | ---- | ---- | ---- |
|  1  |  2021-05-17  |  1  |  Aさん  |
|  2  |  2021-05-19  |  2  |  Bさん  |
|  3  |  2021-05-22  |  3  |  太郎さん  |

テーブル: reservation
|  id  |  date  |  guest_pax  |  staff_pax  |
| ---- | ---- | ---- | ---- |
|  1  |  2021-05-17  |  8  |  2  |
|  2  |  2021-05-17  |  8  |  2  |
|  3  |  2021-05-19  |  1  |  1  |
|  4  |  2021-05-17  |  3  |  2  |
|  5  |  2021-05-19  |  11  |  1  |
|  6  |  2021-05-22  |  1  |  1  |
|  7  |  2021-05-22  |  4  |  1  |

## 在庫管理について
今回は実装してませんが、他のユーザーが同時に予約する場合を考慮してAjaxなどで非同期処理をすれば、データベースから残席数をリアルタイムに取得しプルダウンなど画面に表示できます。ただ、予約ボタンを押す前に在庫を増減させる処理はあまり一般的ではありません。  もしあるユーザーがプルダウンで5人選択し、予約ボタンを押さずに画面を閉じたら、予約していないはずの5人の在庫が確保されたままになります。そのため、一定時間を過ぎたらそれをリセットするなど別に処理を追加して複雑になります。  システムの仕様はその規模や顧客の要望、予算によりますので、一概にこれがいいと言うのはありませんが、今回はAjaxなどで非同期処理を書くまでしなくてもいいかなと思います。
