<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php //error_reporting(E_ALL | E_STRICT);
##-----------------------------------------------------------------------------------------------------------------##
#
#  PHPメールプログラム【Mail05】　ファイル添付版　要PHP5以上
#　改造や改変は自己責任で行ってください。
#
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
#
#  重要！！サイトでチェックボックスを使用する場合のみですが。。。
#  チェックボックスを使用する場合はinputタグに記述するname属性の値を必ず配列の形にしてください。
#  例　name="当サイトをしったきっかけ[]"  として下さい。
#  nameの値の最後に[と]を付ける。じゃないと複数の値を取得できません！
#
##-----------------------------------------------------------------------------------------------------------------##
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {//PHP5.1.0以上の場合のみタイムゾーンを定義
	date_default_timezone_set('Asia/Tokyo');//タイムゾーンの設定（日本以外の場合には適宜設定ください）
}

/*-------------------------------------------------------------------------------------------------------------------
* ★以下設定時の注意点　
* ・値（=の後）は数字以外の文字列（一部を除く）はダブルクオーテーション「"」、または「'」で囲んでいます。
* ・これをを外したり削除したりしないでください。後ろのセミコロン「;」も削除しないください。
* ・また先頭に「$」が付いた文字列は変更しないでください。数字の1または0で設定しているものは必ず半角数字で設定下さい。
* ・メールアドレスのname属性の値が「Email」ではない場合、以下必須設定箇所の「$Email」の値も変更下さい。
* ・name属性の値に半角スペースは使用できません。
*以上のことを間違えてしまうとプログラムが動作しなくなりますので注意下さい。
-------------------------------------------------------------------------------------------------------------------*/


//---------------------------　必須設定　必ず設定してください　-----------------------

//サイトのトップページのURL　※デフォルトでは送信完了後に「トップページへ戻る」ボタンが表示されますので
$site_top = "https://akahaiagent.jp/a/";

// 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください 例 $to = "aa@aa.aa,bb@bb.bb";)
$to = "hikatsu@h-full.co.jp,mita@h-full.co.jp";

//フォームのメールアドレス入力箇所のname属性の値（name="○○"　の○○部分）
$Email = "メールアドレス";

/*------------------------------------------------------------------------------------------------
以下スパム防止のための設定　
※有効にするにはこのファイルとフォームページが同一ドメイン内にある必要があります
------------------------------------------------------------------------------------------------*/

//スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=1, しない=0)
$Referer_check = 0;

//リファラチェックを「する」場合のドメイン ※以下例を参考に設置するサイトのドメインを指定して下さい。
$Referer_check_domain = "https://akahaiagent.jp/";

//---------------------------　必須設定　ここまで　------------------------------------


//---------------------- 任意設定　以下は必要に応じて設定してください ------------------------


// 管理者宛のメールで差出人を送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性の値を「$Email」で指定した値にしてください。
//メーラーなどで返信する場合に便利なので「する」がおすすめです。
$userMail = 1;

// Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください 例 $BccMail = "aa@aa.aa,bb@bb.bb";)
$BccMail = "";

// 管理者宛に送信されるメールのタイトル（件名）
$subject = "アカハイagent【経験者】";

// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 1;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// CV率を解析したい場合などはサンクスページを別途用意し、URLをこの下の項目で指定してください。
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 0;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）※httpから始まるURLで指定ください。
$thanksPage = "http://xxx.xxxxxxxxx/thanks.html";

// 必須入力項目を設定する(する=1, しない=0)
$requireCheck = 0;

/* 必須入力項目(入力フォームで指定したname属性の値を指定してください。（上記で1を設定した場合のみ）
値はシングルクォーテーションで囲み、複数の場合はカンマで区切ってください。フォーム側と順番を合わせると良いです。
配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。*/
$require = array('お名前','Email');


//----------------------------------------------------------------------
//  自動返信メール設定(START)
//----------------------------------------------------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 1;

//自動返信メールの送信者欄に表示される名前　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
$refrom_name = "";

// 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
$re_subject = "アカハイへのご登録ありがとうございます。";

//フォーム側の「名前」箇所のname属性の値　※自動返信メールの「○○様」の表示で使用します。
//指定しない、または存在しない場合は、○○様と表示されないだけです。あえて無効にしてもOK
$dsp_name = 'お名前';

//自動返信メールの冒頭の文言 ※日本語部分のみ変更可
$remail_text = <<< TEXT

この度はアカハイへのご登録、誠にありがとうございます。
担当者より、あらためてご連絡させていただきますので今しばらくお待ちください。

【ご登録内容】＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

TEXT;


//自動返信メールに署名（フッター）を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 1;

//上記で「1」を選択時に表示する署名（フッター）（FOOTER～FOOTER;の間に記述してください）
$mailSignature = <<< FOOTER

※このメールは送信専用のメールアドレスから配信されています。
ご返信いただいてもお答えできませんのでご了承ください。

FOOTER;


//----------------------------------------------------------------------
//  自動返信メール設定(END)
//----------------------------------------------------------------------

//メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
//※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

//全角英数字→半角変換を行うかどうか。(する=1, しない=0)
$hankaku = 0;

//全角英数字→半角変換を行う項目のname属性の値（name="○○"の「○○」部分）
//※複数の場合にはカンマで区切って下さい。（上記で「1」を指定した場合のみ有効）
//配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。
$hankaku_array = array('電話番号','金額');



//----------------------------------------------------------------------
//  添付ファイル処理用設定(BEGIN)
//----------------------------------------------------------------------
//ファイル添付機能を使用する場合は一時ファイルを保存する必要があるため確認画面の表示が必須になります。
$confirmDsp = 1;//確認画面を表示 ※変更不可

/* ----- 重要 ------*/
//ファイルアップ部分のnameの値は必ず配列の形　例　upfile[]　としてください。※添付ファイルが1つでも
//添付ファイルは複数も可能です。

//例1 添付ファイルが1つの場合　
//添付ファイル <input type="file" name="upfile[]" />

//例2 添付ファイルが複数の場合　
//添付ファイル1：<input type="file" name="upfile[]" /> 添付ファイル2：<input type="file" name="upfile[]" />



//添付ファイルのMAXファイルサイズ　※単位バイト　デフォルトは5MB（ただしサーバーのphp.iniの設定による）
$maxImgSize = 10024000;

//添付ファイル一時保存用ディレクトリ ※書き込み可能なパーミッション（777等※サーバによる）にしてください
$tmp_dir_name = './tmp/';

//添付許可ファイル（拡張子）
//※大文字、小文字は区別されません（同じ扱い）のでここには小文字だけでOKです（拡張子を大文字で送信してもマッチします）
$permission_file = array('jpg','jpeg','gif','png','pdf','txt','xls','xlsx','zip','lzh','doc');

//フォームのファイル添付箇所のname属性の値 <input type="file" name="upfile[]" />の「upfile」部
$upfile_key = 'upfile';

//サーバー上の一時ファイルを削除する(する=1, しない=0)　※バックアップ目的で保存させておきたい場合など
//添付ファイルは確認画面表示時にtmpディレクトリに一旦保存されますが、それを送信時に削除するかどうか。（残す場合サーバー容量に余裕がある場合のみ推奨）
//もちろん手動での削除も可能です。
$tempFileDel = 1;//デフォルトは削除する

//確認画面→戻る→確認画面のページ遷移では最初の一時ファイルはサーバ上に残りますが、1時間後以降の最初の送信時に自動で削除されます。


//メールソフトで添付ファイル名が文字化けする場合には「1」にしてみてください。（ThuderBirdで日本語ファイル名文字化け対策）
//「1」にすると添付ファイル名が0～の連番になります。
$rename = 0;//(0 or 1)


//サーバーのphp.iniの「mail.add_x_header」がONかOFFかチェックを行う(する=1, しない=0)　※PHP5.3以降
//「する」場合、mail.add_x_headerがONの場合確認画面でメッセージが表示されます。
//mail.add_x_headerがONの場合、添付ファイルが正常に添付できない可能性が非常に高いためのチェックです。
//mail.add_x_headerはデフォルトは「OFF」ですが、サーバーによっては稀に「ON」になっているためです。
//mail.add_x_headerがONの場合でも正常に添付できていればこちらは「0」として下さい。メッセージは非表示となります。
$iniAddX = 1;

//----------------------------------------------------------------------
//  添付ファイル処理用設定(END)
//----------------------------------------------------------------------


//------------------------------- 任意設定ここまで ---------------------------------------------


// 以下の変更は知識のある方のみ自己責任でお願いします。


//----------------------------------------------------------------------
//  関数実行、変数初期化
//----------------------------------------------------------------------
$encode = "UTF-8";//このファイルの文字コード定義（変更不可）

if(isset($_GET)) $_GET = sanitize($_GET);//NULLバイト除去//
if(isset($_POST)) $_POST = sanitize($_POST);//NULLバイト除去//
if(isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//
if($encode == 'SJIS') $_POST = sjisReplace($_POST,$encode);//Shift-JISの場合に誤変換文字の置換実行
$funcRefererCheck = refererCheck($Referer_check,$Referer_check_domain);//リファラチェック実行

//変数初期化
$sendmail = 0;
$empty_flag = 0;
$post_mail = '';
$errm ='';
$header ='';


//----------------------------------------------------------------------
//  添付ファイル処理(BEGIN)
//----------------------------------------------------------------------

if(isset($_FILES[$upfile_key])){
	$file_count = count($_FILES[$upfile_key]["tmp_name"]);
	for ($i=0;$i<$file_count;$i++) {

		if (@is_uploaded_file($_FILES[$upfile_key]["tmp_name"][$i])) {
			if ($_FILES[$upfile_key]["size"][$i] < $maxImgSize) {

				//許可拡張子チェック
				$upfile_name_check = '';
				$upfile_name_array[$i] = explode('.',$_FILES[$upfile_key]['name'][$i]);
				$upfile_name_array_extension[$i] = strtolower(end($upfile_name_array[$i]));
				foreach($permission_file as $permission_val){
				  if($upfile_name_array_extension[$i] == $permission_val){
					  $upfile_name_check = 'checkOK';
				  }
				}
				if($upfile_name_check != 'checkOK'){
				  $errm .= "<p class=\"error_messe\">許可されていない拡張子です。</p>\n";
				  $empty_flag = 1;
				}else{

					  $temp_file_name[$i] = $_FILES[$upfile_key]["name"][$i];
					  $temp_file_name_array[$i] =  explode('.',$temp_file_name[$i]);

					  if(count($temp_file_name_array[$i]) < 2){
						$errm .= "<p class=\"error_messe\">ファイルに拡張子がありません。</p>\n";
						$empty_flag = 1;
					  }else{
						$extension = end($temp_file_name_array[$i]);

						  if(function_exists('uniqid')){
							  if(!file_exists($tmp_dir_name) || !is_writable($tmp_dir_name)){
							  exit("（重大なエラー）添付ファイル一時保存用のディレクトリが無いかパーミッションが正しくありません。{$tmp_dir_name}ディレクトリが存在するか、または{$tmp_dir_name}ディレクトリのパーミッションを書き込み可能（777等※サーバによる）にしてください");
							  }
						  $upFileName[$i] = uniqid('temp_file_').mt_rand(10000,99999).'.'.$extension;
						  $upFilePath[$i] = $tmp_dir_name.$upFileName[$i];

						  }else{
							  exit('（重大なエラー）添付ﾌｧｲﾙ一時ﾌｧｲﾙ用のﾕﾆｰｸIDを生成するuniqid関数が存在しません。<br>PHPのﾊﾞｰｼﾞｮﾝが極端に低い（PHP4未満）ようです。<br>PHPをﾊﾞｰｼﾞｮﾝｱｯﾌﾟするか配布元に相談ください');
						  }
						  move_uploaded_file($_FILES[$upfile_key]['tmp_name'][$i],$upFilePath[$i]);
						  @chmod($upFilePath[$i], 0666);
					  }
				}
			}else{
				  $errm .= "<p class=\"error_messe\">ファイルサイズが大きすぎます。</p>\n";
				  $empty_flag = 1;
			}
		}
	}
}
//----------------------------------------------------------------------
//  添付ファイル処理(END)
//----------------------------------------------------------------------

if($requireCheck == 1) {
	$requireResArray = requireCheck($require);//必須チェック実行し返り値を受け取る
	$errm .= $requireResArray['errm'];
	if($requireResArray['empty_flag'] == 1) $empty_flag = $requireResArray['empty_flag'];
}
//メールアドレスチェック
if(empty($errm)){
	foreach($_POST as $key=>$val) {
		if($val == "confirm_submit") $sendmail = 1;
		if($key == $Email) $post_mail = h($val);
		if($key == $Email && $mail_check == 1 && !empty($val)){
			if(!checkMail($val)){
				$errm .= "<p class=\"error_messe\">【".$key."】はメールアドレスの形式が正しくありません。</p>\n";
				$empty_flag = 1;
			}
		}
	}
}

if(($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1){

	//差出人に届くメールをセット
	if($remail == 1) {
		$userBody = mailToUser($_POST,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode);
		$reheader = userHeader($refrom_name,$to,$encode);
		$re_subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS",$encode))."?=";
	}
	//管理者宛に届くメールをセット
	$adminBody = mailToAdmin($_POST,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp);
	$header = adminHeader($userMail,$post_mail,$BccMail,$to);
	//$subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS",$encode))."?=";

	//トラバーサルチェック
	if(isset($_POST['upfilePath'])){
		traversalCheck($tmp_dir_name);
	}
	if(ini_get('safe_mode')) {
		$result = mb_send_mail($to,$subject,$adminBody,$header);
	}else{
		$result = mb_send_mail($to,$subject,$adminBody,$header,'-f'. $to);
	}

	//サーバ上の一時ファイルを削除
	$dir = rtrim($tmp_dir_name,'/');
	deleteFile($dir,$tempFileDel);

  if($remail == 1) mail($post_mail,$re_subject,$userBody,$reheader);
}
else if($confirmDsp == 1){

/*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="優しさ・思いやりで結ぶエージェントサービスakahai　経験者歓迎！">
    <meta name="keywords" content="Webマーケティング,インターネットマーケティング,リスティング運用,広告運用,転職,正社員,派遣,アルバイト,人材派遣,求人情報,資格,経験者,高時給,高収入,安定,akahai,">
    <meta name="format-detection" content="telephone=no">
    <title>akahai | 経験者歓迎！キャリアアップしたいSEMスタッフ募集！</title>
    <link rel="stylesheet" href="common/css/sanitize.css">
    <link rel="stylesheet" href="common/css/main.css">
    <link rel="stylesheet" href="common/css/odometer-theme-default.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="common/js/scroll.js"></script>
    <script src="common/js/odometer.js"></script>
    <script src="common/js/function.js"></script>
  </head>
  <body id="wrap">
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KVLK9T"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KVLK9T');</script>
<!-- End Google Tag Manager -->
    <header>
      <div class="header-top-sp">
        <ul class="top1">
          <li>優しさ・思いやりで結ぶエージェントサービス</li>
          <li class="btmsp"><a href="http://h-full.co.jp/" target="_blank"><img src="common/img/KV_logo_btmsp.png"></a></li>
        </ul>
        <ul class="top2">
          <li>一般労働者派遣（厚生労働大臣許可　般 13-306097）</li>
          <li>有料職業紹介（厚生労働大臣許可　13-ユ-307324）</li>
        </ul>
      </div>
      <div class="headermain">
        <div class="header-1">
          <a href="http://h-full.co.jp/" target="_blank"><img src="common/img/KV_logo_btm.png"></a>
        </div>
        <div class="header-0318">
        <ul>
          <li>一般労働者派遣（厚生労働大臣許可　般 13-306097）</li>
          <li>有料職業紹介（厚生労働大臣許可　13-ユ-307324）</li>
        </ul>
        </div>
        <div class="header-1sp">
          <img src="common/img/KV_logo_sp.png">
        </div>
        <div class="header-2">
          <p><span class="tel">TEL.</span>03-6272-4539</p>
        </div>
        <div class="header-2sp">
          <p><a href="tel:0362724539"><span class="tel">TEL.</span>03-6272-4539</a></p>
        </div>
        <div class="header-3">
          <!-- <?php $url = $_SERVER['REQUEST_URI']; ?>
          <?php if(strstr($url,'cat=001')): ?>
            <p>参照元URLにcat=001が含まれる場合の内容</p>
          <?php elseif(strstr($url,'cat=002')): ?>
            <p>参照元URLにcat=002が含まれる場合の内容</p>
          <?php else: ?>
            参照元URLにcat=001もcat=002も含まれない場合
            <img src="common/img/KV_catch00.png">
          <?php endif; ?>-->
            <img src="common/img/KV_catch00.png">
        </div>
        <div class="header-4">
          <a href="#section03"><img src="common/img/KV_btm.png"></a>
        </div>
     </div>
   </header>

      <section id="section01">
        <h2><img src="common/img/section1_1_h2.png" alt="「リスティング」って何？どんなお仕事なの？"></h2>
        <div class="section01-main">
          <div class="section01-1">
            <img src="common/img/section1_2_1.png" class="a">
            <img src="common/img/section1_2_2.png" class="b">
            <img src="common/img/section1_2_3.png" class="c">
            <img src="common/img/section1_2_4.png" class="d">
            <img src="common/img/section1_2_5.png" class="e">
            <img src="common/img/section1_2_6.png" class="f">
            <img src="common/img/section1_2_bg.png" class="g">
          </div>
          <div class="section01-1sp">
            <img src="common/img/section1_2_sp.png">
          </div>
        </div>
        <div class="section01-2">
          <img src="common/img/section1_3_1.png">
          <p>そのため、戦略・スケジュールも立てやすく、<br>リスティング運用をしながら<img src="common/img/section1_3_2.png">することができます</p>
        </div>
        <div class="section01-2sp">
          <img src="common/img/section1_3_sp.png">
        </div>
        <div class="section01-3">
          <img src="common/img/section1_4.png">
        </div>
        <div class="section01-4">
          <a href="#section05"><img src="common/img/section_btm.png" alt="転職・派遣サポートへの登録はこちら！"></a>
        </div>
      </section>

      <section id="section02">
        <h2><img src="common/img/section2_1_h2.png" alt="スキルに応じた給料と選べる働き方"></h2>
        <div class="section02-1">
          <img src="common/img/section2_2.png">
        </div>
        <div class="section02-1sp">
          <img class="zoom1" src="common/img/section2_2.png" data-zoom-image="common/img/section2_2.png">
          <p>表をタッチすると拡大して見ることができます</p>
        </div>
        <div class="section02-2main">
          <div class="section02-2">
            <h3><img src="common/img/section2_3_1.png"></h3>
            <p>現在リスティング広告はインハウス化が進んでおり、<br>広告代理店に任せるのではなく<br>自社で正社員を雇い運用するニーズが増えています。</p>
            <p>その為、広告主はリスティング広告を運用できる人材を<br>非常に求めている状況にあります。</p>
            <p>今までの売上目標達成に身を粉にしていた働き方から、<br>あなたの今までの経験・知識を最大限発揮し、<br>職場環境とプライベートの充実をはかりながら<br>仕事をする働き方にチェンジしてみませんか？</p>
          </div>
        </div>
        <div class="section02-2sp">
          <img src="common/img/section2_3_sp.png">
        </div>
        <div class="section02-3">
          <h3>働き方だって、自由にセレクト！</h3>
          <ul>
            <li><img src="common/img/section2_6_1.png"><br>勤務時間や出席日数を選んで<br>自分のプライベートな時間も<br>しっかりと確保したい方に。</li>
            <li><img src="common/img/section2_6_2.png"><br>派遣社員として働きながら、<br>正社員・契約社員を<br>目指す方にも。<br>（紹介予定派遣制度有）</li>
            <li class="section02-5-3"><img src="common/img/section2_6_3.png"><br>習得した技術を活かして<br>長く働きたい方に。</li>
          </ul>
        </div>
        <div class="section02-4">
          <a href="#section05"><img src="common/img/section_btm.png" alt="転職・派遣サポートへの登録はこちら！"></a>
        </div>
      </section>

      <section id="section03">
        <h2><img src="common/img/sec3_title.png" alt="実際、どのくらい稼げるの・・・？お給料シミュレーション"></h2>
        <div class="inner">
          <ul>
            <li class="question-01 func-question">
              <h2 class="oneline">インターネットが好きで、日常的によく利用している</h2>
              <div class="answer">
                <a class="func-a-01-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-01-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-02 func-question">
              <h2 class="oneline">Excelの操作が得意だ</h2>
              <div class="answer">
                <a class="func-a-02-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-02-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-03 func-question">
              <h2 class="oneline">Web業界経験者だ</h2>
              <div class="answer">
                <a class="func-a-03-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-03-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-04 func-question">
              <h2 class="oneline">リスティング広告の運用に携わったことがある</h2>
              <div class="answer">
                <a class="func-a-04-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-04-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-05 func-question">
              <h2 class="oneline">掲載結果のレポートを作成したことがある</h2>
              <div class="answer">
                <a class="func-a-05-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-05-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-06 func-question">
              <h2 class="oneline">入札単価の調整をしたことがある</h2>
              <div class="answer">
                <a class="func-a-06-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-06-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-07 func-question">
              <h2 class="towline">Yahoo!リスティング広告、<br>Google AdWordsへの入稿ができる</h2>
              <div class="answer">
                <a class="func-a-07-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-07-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-08 func-question">
              <h2 class="towline">広告文・キーワードの作成やグルーピングなど、<br>自分で掲載内容案を作成することができる</h2>
              <div class="answer">
                <a class="func-a-08-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-08-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-09 func-question">
              <h2 class="towline">広告の掲載結果をもとに、<br>アカウントの最適化プランを考えることができる</h2>
              <div class="answer">
                <a class="func-a-09-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-09-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-10 func-question">
              <h2 class="oneline">リスティング運用経験年数が2年以上である</h2>
              <div class="answer">
                <a class="func-a-10-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-10-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-11 func-question">
              <h2 class="towline">アカウント開設から、日々の運用まで<br>ひと通りの作業ができる</h2>
              <div class="answer">
                <a class="func-a-11-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-11-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-12 func-question">
              <h2 class="towline">クライアントへの報告・プレゼン資料の<br>作成や、訪問が1人で行える</h2>
              <div class="answer">
                <a class="func-a-12-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-12-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-13 func-question">
              <h2 class="towline">自身で予算を預かって、月額予算100万円以上の<br>アカウントを運用したことがある</h2>
              <div class="answer">
                <a class="func-a-13-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-13-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-14 func-question">
              <h2 class="towline">未経験者に対して、リスティング広告の概要から<br>運用方法までをひと通り説明できる</h2>
              <div class="answer">
                <a class="func-a-14-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-14-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="question-15 func-question">
              <h2 class="towline">リーダー職に就いていたなど、<br>チームのマネジメント経験がある</h2>
              <div class="answer">
                <a class="func-a-15-t btn-left" href="#"><span><img src="common/img/sec3_btn_answer_t.png" alt="Yes"></span></a>
                <a class="func-a-15-f btn-right" href="#"><span><img src="common/img/sec3_btn_answer_f.png" alt="no"></span></a>
              </div>
            </li>
            <li class="salary-result func-result">
              <p>あなたのお給料は<br><span class="odometer">000000</span><span class="unit">円</span>です！</p>
              <a href="#section05"><img src="common/img/section_btm.png" alt="転職・派遣サポートへの登録はこちら！"></a>
              <p class="caution">このお給料シミュレーションはあくまでシミュレーションとなり、必ず頂けるお給料ではございません。</p>
            </li>
          </ul>
        </div>
      </section>

      <section id="section04">
        <h2><img src="common/img/section4_1_h2.png" alt="akahaiでのキャリアアップビジョン"></h2>
        <div class="section04-1">
          <div class="sec04-banner1">
            <img src="common/img/section4_2_1.png">
          </div>
          <div class="sec04-banner2">
            <img src="common/img/section4_2_2.png">
          </div>
          <div class="sec04-banner3">
            <img src="common/img/section4_2_3.png">
          </div>
        </div>
        <div class="section04-2">
            <p><span class="f"><span class="g">給料を上げたい</span>方も、<span class="g">プライベートを充実させたい</span>方も<br>要望を叶えることが出来る。<br>
              <span class="h">それが</span><span class="i">akahai</span><span class="h">の強み</span>です。</span></p>
        </div>
        <div class="section04-2sp">
            <img src="common/img/section4_3_sp.png">
        </div>
        <div class="section04-3">
          <a href="#section05"><img src="common/img/section_btm.png" alt="転職・派遣サポートへの登録はこちら！"></a>
        </div>
      </section>

      <section id="section05">
        <h2><img src="common/img/form_1_h2.png" alt="転職・派遣サポートへ早速登録！"></h2>
          <div class="section05-1">

<!-- ▲ Headerやその他コンテンツなど　※自由に編集可 ▲-->

<!-- ▼************ 送信内容表示部　※編集は自己責任で ************ ▼-->
<div id="formWrap">
<?php if($empty_flag == 1){ ?>
<div align="center">
<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
<?php echo $errm; ?><br /><br /><div class="btn"><button type="button" name="button" onClick="history.back()" class="btn-back">入力画面に戻る</button></div>
</div>
<?php }else{ ?>
<p align="center">以下の内容で間違いがなければ、「送信する」ボタンを押してください。</p>
<?php iniGetAddMailXHeader($iniAddX);//php.ini設定チェック?>
<form action="<?php echo h($_SERVER['SCRIPT_NAME']); ?>?thanks=1" method="POST">
<?php echo confirmOutput($_POST);//入力内容を表示?>
<div class="btn"><input type="hidden" name="mail_set" value="confirm_submit">
<input type="hidden" name="httpReferer" value="<?php echo h($_SERVER['HTTP_REFERER']) ;?>">
<?php
if(isset($_FILES[$upfile_key]["tmp_name"])){
	$file_count = count($_FILES[$upfile_key]["tmp_name"]);
	for ($i=0;$i<$file_count;$i++) {
		if(!empty($_FILES[$upfile_key]["tmp_name"][$i])){
?>
<input type="hidden" name="upfilePath[]" value="<?php echo h($upFilePath[$i]);?>">
<input type="hidden" name="upfileType[]" value="<?php echo h($_FILES[$upfile_key]['type'][$i]);?>">
<input type="hidden" name="upfileOriginName[]" value="<?php echo h($_FILES[$upfile_key]['name'][$i]);?>">
<?php
		}
	}
}
?>

<button type="button" name="button" onClick="history.back()" class="btn-back">入力画面に戻る</button>
<button type="submit">送信する</button>

</div>
</form>
<?php copyright();} ?>
</div><!-- /formWrap -->
<!-- ▲ *********** 送信内容確認部　※編集は自己責任で ************ ▲-->

<!-- ▼ Footerその他コンテンツなど　※編集可 ▼-->
          </div>
      </section>

<footer>
  <div class="footer-1">
    <a href="#wrap"><img src="common/img/footer_point.png"></a>
  </div>
  <div class="footer-2">
    <span id="ss_gmo_img_wrapper_100-50_image_ja">
      <a href="https://jp.globalsign.com/" target="_blank" rel="nofollow">
      <img alt="SSL　GMOグローバルサインのサイトシール" border="0" id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_100-50_ja.gif">
    </a>
    </span>
<script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_100-50_ja.js" defer="defer"></script>
  </div>
  <div class="footer-3">
    <p>&copy; Copyright 2016 akahai agent</p>
  </div>
</footer>

<script src="common/js/jquery.elevatezoom.js"></script>
<script type="text/javascript">
  $(".zoom1").elevateZoom({
zoomType : "inner",
cursor: "crosshair"
  });
</script>
<script type="text/javascript">
  (function () {
    var tagjs = document.createElement("script");
    var s = document.getElementsByTagName("script")[0];
    tagjs.async = true;
    tagjs.src = "//s.yjtag.jp/tag.js#site=8cgNHWS";
    s.parentNode.insertBefore(tagjs, s);
  }());
</script>
<noscript>
  <iframe src="//b.yjtag.jp/iframe?c=8cgNHWS" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>
</body>
</html>
<?php
/* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
}

if(($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) {

/* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>akahai | 経験者歓迎！キャリアアップしたいSEMスタッフ募集！</title>
<link rel="stylesheet" href="common/css/sanitize.css">
<link rel="stylesheet" href="common/css/main.css">
<link rel="stylesheet" href="common/css/odometer-theme-default.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="common/js/scroll.js"></script>
<script src="common/js/odometer.js"></script>
<script src="common/js/function.js"></script>
</head>
<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KVLK9T"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KVLK9T');</script>
<!-- End Google Tag Manager -->
  <div class="complete">

<div align="center">
<?php if($empty_flag == 1){ ?>
<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
<div style="color:red"><?php echo $errm; ?></div>
<br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
</div>
</div>
</body>
</html>
<?php }else{ ?>
ご登録ありがとうございました。<br>
後日、弊社担当者よりご連絡をさせていただきます。
<div class="btn">
  <a href="<?php echo $site_top ;?>">トップページへ</a>
</div>
</div>
</div>
<?php copyright(); ?>
<!--  CV率を計測する場合ここにAnalyticsコードを貼り付け -->
<script type="text/javascript">
  (function () {
    var tagjs = document.createElement("script");
    var s = document.getElementsByTagName("script")[0];
    tagjs.async = true;
    tagjs.src = "//s.yjtag.jp/tag.js#site=8cgNHWS";
    s.parentNode.insertBefore(tagjs, s);
  }());
</script>
<noscript>
  <iframe src="//b.yjtag.jp/iframe?c=8cgNHWS" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>
</body>
</html>
<?php
/* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
  }
}
//確認画面無しの場合の表示、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
else if(($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) {
	if($empty_flag == 1){ ?>
<div align="center"><h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4><div style="color:red"><?php echo $errm; ?></div><br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()"></div>
<?php
	}else{ header("Location: ".$thanksPage); }
}

// 以下の変更は知識のある方のみ自己責任でお願いします。

//----------------------------------------------------------------------
//  関数定義(START)
//----------------------------------------------------------------------
function checkMail($str){
	$mailaddress_array = explode('@',$str);
	if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	}else{
		return false;
	}
}
function h($string) {
	global $encode;
	return htmlspecialchars($string, ENT_QUOTES,$encode);
}
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}
//Shift-JISの場合に誤変換文字の置換関数
function sjisReplace($arr,$encode){
	foreach($arr as $key => $val){
		$key = str_replace('＼','ー',$key);
		$resArray[$key] = $val;
	}
	return $resArray;
}
//送信メールにPOSTデータをセットする関数
function postToMail($arr){
	global $hankaku,$hankaku_array;
	$resArray = '';
	foreach($arr as $key => $val){
		$out = '';
		if(is_array($val)){
			foreach($val as $key02 => $item){
				//連結項目の処理
				if(is_array($item)){
					$out .= connect2val($item);
				}else{
					$out .= $item . ', ';
				}
			}
			$out = rtrim($out,', ');

		}else{ $out = $val; }//チェックボックス（配列）追記ここまで
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }

		//全角→半角変換
		if($hankaku == 1){
			$out = zenkaku2hankaku($key,$out,$hankaku_array);
		}

		if($out != "confirm_submit" && $key != "httpReferer" && $key != "upfilePath" && $key != "upfileType") {

			if($key == "upfileOriginName" && $out !=''){
				$key = '添付ファイル';
			}elseif($key == "upfileOriginName" && $out ==''){
				continue;
			}

			$resArray .= "【 ".$key." 】 ".$out."\n";
		}
	}
	return $resArray;
}
//確認画面の入力内容出力用関数
function confirmOutput($arr){
	global $upFilePath,$upfile_key,$encode,$hankaku,$hankaku_array;
	$html = '';
	foreach($arr as $key => $val) {
		$out = '';
		if(is_array($val)){
			foreach($val as $key02 => $item){
				//連結項目の処理
				if(is_array($item)){
					$out .= connect2val($item);
				}else{
					$out .= $item . ', ';
				}
			}
			$out = rtrim($out,', ');

		}else{ $out = $val; }//チェックボックス（配列）追記ここまで
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
		$out = nl2br(h($out));//※追記 改行コードを<br>タグに変換
		$key = h($key);

		//全角→半角変換
		if($hankaku == 1){
			$out = zenkaku2hankaku($key,$out,$hankaku_array);
		}

		$html .= "<dl><dt>".$key."</dt><dd>".mb_convert_kana($out,"K", $encode);
		$html .= '<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",mb_convert_kana($out,"K", $encode)).'" />';
		$html .= "</dd></dl>\n";

	}

	//添付ファイル表示処理
	if(isset($_FILES[$upfile_key]["tmp_name"])){
		$file_count = count($_FILES[$upfile_key]["tmp_name"]);
		$j = 1;
    $html .= "<dl><dt>履歴書や職務経歴書など</dt><dd>\n";
		for($i=0;$i<$file_count;$i++,$j++) {
			//添付があったらファイル名表示
			if(!empty($upFilePath[$i])){
			  $html .= "{$_FILES[$upfile_key]['name'][$i]}<br>\n";
			}
		}
    $html .= "</dd></dl>\n";
	}

	return $html;
}
//全角→半角変換
function zenkaku2hankaku($key,$out,$hankaku_array){
	global $encode;
	if(is_array($hankaku_array) && function_exists('mb_convert_kana')){
		foreach($hankaku_array as $hankaku_array_val){
			if($key == $hankaku_array_val){
				$out = mb_convert_kana($out,'a',$encode);
			}
		}
	}
	return $out;
}
//配列連結の処理
function connect2val($arr){
	$out = '';
	foreach($arr as $key => $val){
		if($key === 0 || $val == ''){//配列が未記入（0）、または内容が空のの場合には連結文字を付加しない（型まで調べる必要あり）
			$key = '';
		}elseif(strpos($key,"円") !== false && $val != '' && preg_match("/^[0-9]+$/",$val)){
			$val = number_format($val);//金額の場合には3桁ごとにカンマを追加
		}
		$out .= $val . $key;
	}
	return $out;
}
//管理者宛送信メールヘッダ
function adminHeader($userMail,$post_mail,$BccMail,$to){
	$header = '';

	//メールで日本語使用するための設定
	mb_language("Ja") ;
	mb_internal_encoding("utf-8");

	if($userMail == 1 && !empty($post_mail)) {
		$header="From: $post_mail\n";
		if($BccMail != '') {
		  $header.="Bcc: $BccMail\n";
		}
		$header.="Reply-To: ".$post_mail."\n";
	}else {
		if($BccMail != '') {
		  $header="Bcc: $BccMail\n";
		}
		$header.="Reply-To: ".$to."\n";
	}

	//----------------------------------------------------------------------
	//  添付ファイル処理(START)
	//----------------------------------------------------------------------
	if(isset($_POST['upfilePath'])){
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"__PHPFACTORY__\"\n";
	}else{
		$header.="Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	}

	return $header;
}
//管理者宛送信メールボディ
function mailToAdmin($arr,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp){
	global $rename;
	$adminBody = '';
	//----------------------------------------------------------------------
	//  添付ファイル処理(START)
	//----------------------------------------------------------------------
	if(isset($_POST['upfilePath'])){
		$adminBody .= "--__PHPFACTORY__\n";
		$adminBody .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n";
		//$adminBody .= "\n";
	}
	//----------------------------------------------------------------------
	//  添付ファイル処理(END)
	//----------------------------------------------------------------------

	$adminBody .="「".$subject."」からメールが届きました\n\n";
	$adminBody .="＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$adminBody .= postToMail($arr);//POSTデータを関数からセット
	$adminBody .="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
	$adminBody .="送信された日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	$adminBody .="送信者のIPアドレス：".@$_SERVER["REMOTE_ADDR"]."\n";
	$adminBody .="送信者のホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
	if($confirmDsp != 1){
		$adminBody.="問い合わせのページURL：".@h($_SERVER['HTTP_REFERER'])."\n";
	}else{
		$adminBody.="問い合わせのページURL：".@$arr['httpReferer']."\n";
	}
	if($mailFooterDsp == 1) $adminBody.= $mailSignature."\n";

//----------------------------------------------------------------------
//  添付ファイル処理(START)
//----------------------------------------------------------------------

if(isset($_POST['upfilePath'])){

	$default_internal_encode = mb_internal_encoding();
	if($default_internal_encode != $encode){
		mb_internal_encoding($encode);
	}

	$file_count = count($_POST['upfilePath']);

	for ($i=0;$i<$file_count;$i++) {

		if(isset($_POST['upfilePath'][$i])){

		$adminBody .= "--__PHPFACTORY__\n";
		$filePath = h(@$_POST['upfilePath'][$i]);//ファイルパスを指定
		$fileName = h(mb_encode_mimeheader(@$_POST['upfileOriginName'][$i]));
		$imgType = h(@$_POST['upfileType'][$i]);

		//ファイル名が文字化けする場合には連番ファイル名とする
		if($rename == 1){
			$fileNameArray = explode(".",$fileName);
			$fileName = $i.'.'.end($fileNameArray);
		}


		# 添付ファイルへの処理をします。
		$handle = @fopen($filePath, 'r');
		$attachFile = @fread($handle, filesize($filePath));
		@fclose($handle);
		$attachEncode = base64_encode($attachFile);

		$adminBody .= "Content-Type: {$imgType}; name=\"$filePath\"\n";
		$adminBody .= "Content-Transfer-Encoding: base64\n";
		$adminBody .= "Content-Disposition: attachment; filename=\"$fileName\"\n";
		$adminBody .= "\n";
		$adminBody .= chunk_split($attachEncode) . "\n";
		}
	}
		$adminBody .= "--__PHPFACTORY__--\n";
}
//----------------------------------------------------------------------
//  添付ファイル処理(END)
//----------------------------------------------------------------------

	//return mb_convert_encoding($adminBody,"JIS",$encode);
	return $adminBody;
}

//ユーザ宛送信メールヘッダ
function userHeader($refrom_name,$to,$encode){
	$reheader = "From: ";
	if(!empty($refrom_name)){
		$default_internal_encode = mb_internal_encoding();
		if($default_internal_encode != $encode){
			mb_internal_encoding($encode);
		}
		$reheader .= mb_encode_mimeheader($refrom_name)." <".$to.">\nReply-To: ".$to;
	}else{
		$reheader .= "$to\nReply-To: ".$to;
	}
	$reheader .= "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	return $reheader;
}
//ユーザ宛送信メールボディ
function mailToUser($arr,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode){
	$userBody = '';
	if(isset($arr[$dsp_name])) $userBody = h($arr[$dsp_name]). " 様\n";
	$userBody.= $remail_text;
	$userBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$userBody.= postToMail($arr);//POSTデータを関数からセット
	$userBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$userBody.="送信日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	if($mailFooterDsp == 1) $userBody.= $mailSignature;
	return mb_convert_encoding($userBody,"JIS",$encode);
}
//必須チェック関数
function requireCheck($require){
	$res['errm'] = '';
	$res['empty_flag'] = 0;
	foreach($require as $requireVal){
		$existsFalg = '';
		foreach($_POST as $key => $val) {
			if($key == $requireVal) {

				//連結指定の項目（配列）のための必須チェック
				if(is_array($val)){
					$connectEmpty = 0;
					foreach($val as $kk => $vv){
						if(is_array($vv)){
							foreach($vv as $kk02 => $vv02){
								if($vv02 == ''){
									$connectEmpty++;
								}
							}
						}

					}
					if($connectEmpty > 0){
						$res['errm'] .= "<p class=\"error_messe\">【".h($key)."】は必須項目です。</p>\n";
						$res['empty_flag'] = 1;
					}
				}
				//デフォルト必須チェック
				elseif($val == ''){
					$res['errm'] .= "<p class=\"error_messe\">【".h($key)."】は必須項目です。</p>\n";
					$res['empty_flag'] = 1;
				}

				$existsFalg = 1;
				break;
			}

		}
		if($existsFalg != 1){
				$res['errm'] .= "<p class=\"error_messe\">【".$requireVal."】が未選択です。</p>\n";
				$res['empty_flag'] = 1;
		}
	}

	return $res;
}
//リファラチェック
function refererCheck($Referer_check,$Referer_check_domain){
	if($Referer_check == 1 && !empty($Referer_check_domain)){
		if(strpos(h($_SERVER['HTTP_REFERER']),$Referer_check_domain) === false){
			return exit('<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>');
		}
	}
}
function copyright(){
	echo '';
}
//ファイル添付用一時ファイルの削除
function deleteFile($dir,$tempFileDel){
	global $permission_file;

	if($tempFileDel == 1){
		if(isset($_POST['upfilePath'])){
			foreach($_POST['upfilePath'] as $key => $val){

				foreach($permission_file as $permission_file_val){
					if(strpos(strtolower($val),$permission_file_val) !== false && file_exists($val)){
						if(strpos($val,'htaccess') !== false) exit();
						unlink($val);
						break;
					}
				}

			}
		}

		//ゴミファイルの削除（1時間経過したもののみ）※確認画面→戻る→確認画面の場合、先の一時ファイルが残るため
		if(file_exists($dir) && !empty($dir)){
		$handle = opendir($dir);
		  while($temp_filename = readdir($handle)){
			if(strpos($temp_filename,'temp_file_') !== false ){
				if( strtotime(date("Y-m-d H:i:s",filemtime($dir."/".$temp_filename))) < strtotime(date("Y-m-d H:i:s",strtotime("-1 hour"))) ){
					@unlink("$dir/$temp_filename");
				}
			}
		  }
		}
	}
}
//php.iniのmail.add_x_headerのチェック
function iniGetAddMailXHeader($iniAddX){
	if($iniAddX == 1){
		if(@ini_get('mail.add_x_header') == 1) echo '<p style="color:red">php.iniの「mail.add_x_header」がONになっています。添付がうまくいかない可能性が高いです。htaccessファイルかphp.iniファイルで設定を変更してOFFに設定下さい。サーバーにより設定方法は異なります。詳しくはサーバーマニュアル等、またはサーバー会社にお問い合わせ下さい。正常に添付できていればOKです。このメーッセージはmail.php内のオプションで非表示可能です</p>';
	}
}

//トラバーサル対策
function traversalCheck($tmp_dir_name){
	if(isset($_POST['upfilePath']) && is_array($_POST['upfilePath'])){
		foreach($_POST['upfilePath'] as $val){
			if(strpos($val,$tmp_dir_name) === false || strpos($val,'temp_file_') === false) exit('Warning!! you are wrong..1');//ルール違反は強制終了
			if(substr_count($tmp_dir_name,'/') != substr_count($val,'/') ) exit('Warning!! you are wrong..2');//ルール違反は強制終了
			if(strpos($val,'htaccess') !== false) exit('Warning!! you are wrong..3');
			if(!file_exists($val)) exit('Warning!! you are wrong..4');
			if(strpos(str_replace($tmp_dir_name,'',$val),'..') !== false)  exit('Warning!! you are wrong..5');
		}
	}
}


//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
?>
