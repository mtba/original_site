<?php
/**************************************************

	ベアラートークンの取得

**************************************************/

	// 設定項目
	$api_key = 'pt1yTCa4eU1p1XcZds60DQmSd' ;		// APIキー
	$api_secret = 'oy8cuBuLJzMMrVv5bqKfajvgzuLImVnEQHR8qkW75Jzu416scE' ;		// APIシークレット

	// クレデンシャルを作成
	$credential = base64_encode( $api_key . ':' . $api_secret ) ;

	// リクエストURL
	$request_url = 'https://api.twitter.com/oauth2/token' ;

	// リクエスト用のコンテキストを作成する
	$context = array(
		'http' => array(
			'method' => 'POST' , // リクエストメソッド
			'header' => array(			  // ヘッダー
				'Authorization: Basic ' . $credential ,
				'Content-Type: application/x-www-form-urlencoded;charset=UTF-8' ,
			) ,
			'content' => http_build_query(	// ボディ
				array(
					'grant_type' => 'client_credentials' ,
				)
			) ,
		) ,
	) ;

	// cURLを使ってリクエスト
	$curl = curl_init() ;
	curl_setopt( $curl , CURLOPT_URL , $request_url ) ;
	curl_setopt( $curl , CURLOPT_HEADER, 1 ) ;
	curl_setopt( $curl , CURLOPT_CUSTOMREQUEST , $context['http']['method'] ) ;			// メソッド
	curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false ) ;								// 証明書の検証を行わない
	curl_setopt( $curl , CURLOPT_RETURNTRANSFER , true ) ;								// curl_execの結果を文字列で返す
	curl_setopt( $curl , CURLOPT_HTTPHEADER , $context['http']['header'] ) ;			// ヘッダー
	curl_setopt( $curl , CURLOPT_POSTFIELDS , $context['http']['content'] ) ;			// リクエストボディ
	curl_setopt( $curl , CURLOPT_TIMEOUT , 5 ) ;										// タイムアウトの秒数
	$res1 = curl_exec( $curl ) ;
	$res2 = curl_getinfo( $curl ) ;
	curl_close( $curl ) ;

	// 取得したデータ
	$json = substr( $res1, $res2['header_size'] ) ;				// 取得したデータ(JSONなど)
	$header = substr( $res1, 0, $res2['header_size'] ) ;		// レスポンスヘッダー (検証に利用したい場合にどうぞ)

	// [cURL]ではなく、[file_get_contents()]を使うには下記の通りです…
	// $response = @file_get_contents( $request_url , false , stream_context_create( $context ) ) ;

	// JSONをオブジェクトに変換
	$obj = json_decode( $json ) ;

	// HTML用
	$html = '' ;

	// 実行結果を出力
	$html .= '<h2>実行結果</h2>' ;

	// エラー判定
	if( !$obj || !isset( $obj->access_token ) )
	{
		$html .= '<p>トークンを取得することができませんでした…。設定を見直して下さい。</p>' ;
	}
	else
	{
		// 各データ
		$bearer_token = $obj->access_token ;

		// 出力する
		$html .=  '<dl>' ;
		$html .=  	'<dt>ベアラートークン</dt>' ;
		$html .=  		'<dd>' . $bearer_token . '</dd>' ;
		$html .=  '</dl>' ;
	}

	// 検証用にレスポンスヘッダーを出力 [本番環境では不要]
	$html .= '<h2>取得したデータ</h2>' ;
	$html .= '<p>下記のデータを取得できました。</p>' ;
	$html .= 	'<h3>ボディ</h3>' ;
	$html .= 	'<p><textarea rows="8">' . $json . '</textarea></p>' ;
	$html .= 	'<h3>レスポンスヘッダー</h3>' ;
	$html .= 	'<p><textarea rows="8">' . $header . '</textarea></p>' ;

?>

<?php
	// ブラウザに[$html]を出力 (HTMLのヘッダーとフッターを付けましょう)
	// echo $html ;
?>

<?php
$request_url = 'https://api.twitter.com/1.1/trends/place.json' ;		// エンドポイント

$place_id = array('1110809','1116753','1117034','1117099','1117155','1117227','1117502','1117545','1117605','1117817','1117881','1118072','1118108','1118129','1118285','1118370','1118550','234589','15015370','15015372','23424856','90036018');

$random = mt_rand(0, 21);

// パラメータ
$params = array(
  'id' => $place_id[$random] ,		// WOEID
  'exclude' => 'hashtags' ,		// ハッシュタグの除外
) ;

// パラメータがある場合
if( $params )
{
  $request_url .= '?' . http_build_query( $params ) ;
}

// リクエスト用のコンテキスト
$context = array(
  'http' => array(
    'method' => 'GET' , // リクエストメソッド
    'header' => array(			  // ヘッダー
      'Authorization: Bearer ' . $bearer_token ,
    ) ,
  ) ,
) ;

// cURLを使ってリクエスト
$curl = curl_init() ;
curl_setopt( $curl , CURLOPT_URL , $request_url ) ;
curl_setopt( $curl , CURLOPT_HEADER, 1 ) ;
curl_setopt( $curl , CURLOPT_CUSTOMREQUEST , $context['http']['method'] ) ;			// メソッド
curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false ) ;								// 証明書の検証を行わない
curl_setopt( $curl , CURLOPT_RETURNTRANSFER , true ) ;								// curl_execの結果を文字列で返す
curl_setopt( $curl , CURLOPT_HTTPHEADER , $context['http']['header'] ) ;			// ヘッダー
curl_setopt( $curl , CURLOPT_TIMEOUT , 5 ) ;										// タイムアウトの秒数
$res1 = curl_exec( $curl ) ;
$res2 = curl_getinfo( $curl ) ;
curl_close( $curl ) ;

// 取得したデータ
$json = substr( $res1, $res2['header_size'] ) ;				// 取得したデータ(JSONなど)
$header = substr( $res1, 0, $res2['header_size'] ) ;		// レスポンスヘッダー (検証に利用したい場合にどうぞ)

// [cURL]ではなく、[file_get_contents()]を使うには下記の通りです…
// $json = @file_get_contents( $request_url , false , stream_context_create( $context ) ) ;

// JSONをオブジェクトに変換
$obj = json_decode( $json ) ;

// エラー判定
if( !$json || !$obj )
{
  $html .= '<h2>エラー内容</h2>' ;
  $html .= '<p>データを取得することができませんでした…。設定を見直して下さい。</p>' ;
}
echo $json;

?>
