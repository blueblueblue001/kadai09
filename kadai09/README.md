# kadai09
# kadai09
#PHP 03の課題です
＃作品テーマ
事業企画の「地球とダイバーの命の可能性をひらく」アプリの初期ヴァージョンです

ダイバーはログを毎回つけます。
世界中のダイバーのログデータや写真データから、珊瑚礁の変化、水温の変化、透明度の変化などのビッグデータが形成され、
観測衛生データなどと統合して、地球の生命や環境を研究し、課題を解決していくようなアプリを想定しています。

＃工夫したこと
image画像のアップロード、表示機能を実装しました。
- index.php フォームで画像をアップロード
-XAMPP DB　Tableにカラム追加　photo  varchar(255).   utf8_unicode_ci  NULL はい  NULL
-index.phpと同じ階層に uploads というディレクトリ作成、everyoneと_mySqlに読み書き権限を付与、自分が所有者、セキュリティロック解除
-index.phpのCSSデザインを入れ、濃紺を基調としたシンプルなデザインを表現しました。

＃苦労したこと
画像が読み込まれない状態が続き、ChatGPTで２日間溶かしました。
Slackでチューターさんにアドバイをいただき、formにenctypeを追加することで、アップロードが可能となりました。
<form id="logForm" method="POST" action="insert.php" enctype="multipart/form-data">