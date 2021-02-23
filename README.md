class-kansu
 app(機能部分)
  config.php
  func.php
 public（クライアントに見せる部分）
  index.php
   ドキュメントルートをpublicにして動作確認OK



   PDO::
   上記のようなPHPがもとよりもっているクラスのあるファイルでnamespaceを使用する際は
   \PDO::
   のようにバックスラッシュを後ろにつけることでエラー回避できる