## インストール方法

## インストール後の実施事項

画像のダミーデータは
public/imagesフォルダ内に
sample1.jpg - sample6.jpgとして保存しています。

php artisan storage:link でstorageフォルダにリンク後、

storage/app/public/productsフォルダ内に保存すると表示されます。
(productsフォルダがない場合は作成してください。)

ショップの画像も表示する場合は、
storage/app/public/shopsフォルダを作成し、
画像を保存してください。

## .envに関して

stripe, mailtrapの利用のための環境変数を設定してください。

## メールに関して

メール処理にキューを使っており、以下コマンドでキュー処理を実行ください。

php artisan queue:work 
