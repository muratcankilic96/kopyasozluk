
<?php 
	include "notorm-master/NotORM.php";
	require('db.php');
	ob_start();
	session_start();
	$_SESSION["delete"] = 0;?>
<html lang="tr">
	<head>
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
		<meta charset="utf-8">
		<title>Kopya Sözlük - Kutsal Arak Kaynağı</title>
		<link title="Kopya Sözlük" rel="search" type="application/opensearchdescription+xml" href="/odesc.xml">
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic,700italic,600&subset=latin,latin-ext">
		
		
		<?php
			$nick_not_found = "";
			$email_not_found = "";
			$gender_not_found = "";
			$pass_not_found = "";
			$bd_not_found = "";
			$repeat_not_found = "";
			$not_checked = "";
			$success = "";
			$works = true;
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$name = htmlspecialchars($_POST['Name']);
				if(htmlspecialchars(empty($name))) {
					$nick_not_found = "nasıl nick bu ya?";
					$works = false;
				} 
				else 
				{
					$f = $db->Users("name = ?", "$name")->fetch();
					if($f["name"] === $name) 
					{
						$nick_not_found = "başkasının nick'ini mi araklamaya çalıştın sen?";
						$works = false;	
					}
				}
				$email = htmlspecialchars($_POST['Email']);
				if(htmlspecialchars(empty($_POST["Email"]))) {
					$email_not_found = "email'ini düzgün yazıver.";
					$works = false;
				}
				else 
				{
					$f = $db->Users("email = ?", "$email")->fetch();
					if($f["email"] === $email) 
					{
						$email_not_found = "böyle bir email varmış.";
						$works = false;	
					}
				}
				if(!isset($_POST["RequestConfirmer"])) {
					$not_checked = "emin değilsin işte uzatma.";
					$works = false;
				}
				if(empty($_POST["Gender"])) {
					$gender_not_found = "nesin sen? helikopter mi?";
					$works = false;
				}
				$stud_day   = explode("_",$_POST['BirthdateDay']);
				$stud_day   = $stud_day[0];
				$stud_month = explode("_",$_POST['BirthdateMonth']);
				$stud_month = $stud_month[0];
				$stud_year  = explode("_",$_POST['BirthdateYear']);
				$stud_year  = $stud_year[0];
				
				if(empty($stud_day) && empty($stud_month) && empty($stud_year)) {
					$bd_not_found = "sen doğmamışsın.";
					$works = false;
				}
				if(htmlspecialchars(empty($_POST["Password"]))) {
					$pass_not_found = "şifresiz mi gireceksin?";
					$works = false;
					} else if(strlen($_POST["Password"]) < 8) {
					$pass_not_found = "şifren çok kısa.";
					$repeat_not_found = "uzun uzun yaz.";
					}
					if(empty($_POST["PasswordConfirm"])) {
					$repeat_not_found = "şurayı da dolduruver.";
					$works = false;
				}
				if(htmlspecialchars($_POST["PasswordConfirm"]) != htmlspecialchars($_POST["Password"])) {
					$pass_not_found = "şifrelere bir baksana.";
					$repeat_not_found = "aynı mı bunlar sence?";
					$works = false;
				}
				
				if($works) {
				$findmax = $db->Users()->max("usr_id");
				$name = htmlspecialchars($_POST["Name"]);
				$name = mb_strtolower($name, 'utf8');
				$gender = (int) $_POST["Gender"];
				if ((int)$stud_month < 10) $stud_month = "0" . $stud_month;
				if ((int)$stud_day < 10) $stud_day = "0" . $stud_day;
				$date = $stud_year . "-" . $stud_month . "-" . $stud_day;
				$dateformat = date('Y-m-d', strtotime($date));
				$array = array(
					"usr_id" 	 => $findmax + 1,
					"name" 	 	 => $name,
					"gender" 	 => $gender - 1,
					"email" 	 => htmlspecialchars($_POST["Email"]),
					"password"   => htmlspecialchars($_POST["Password"]),
					"birth_date" => $dateformat,
					"authority"  => 0
				);
					$users = $db->users()->insert($array);
					$success = "kullanıcı kaydı başarılı efendimiz!";
				}
			}
		?>
		
		
		
		
		
		<link href="css/clone.css" rel="stylesheet" />
		
		
		<script>
			dataLayer = [{
				'elogin': '0',
				'eloginid':'0',
				'eauthor': '',
				'esubdom': 'eksisozluk',
				'etitle': '',
				'ecat1': 'tarih',
				'econtentid': '',
				'epagetype': 'main',
				'epublishdate': '',
				'epublishtime': '',
				'econtenttype': '',
				'efiltre': '',
			}];
		</script>
		
		
		<!-- Google Optimize !-->
		<style>
			.async-hide {
			opacity: 0 !important;
			}
		</style>
		<script>
			(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
				h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
				(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
			})(window,document.documentElement,'async-hide','dataLayer',4000,
		{'GTM-WXV2Z47':true});</script>
		<!-- Google Optimize !-->
		                <?php
			include "setheader.php";
				?>
		
		<!-- Google Tag Manager -->
		<script>
			(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-WXV2Z47');</script>
			<!-- End Google Tag Manager -->
			<script src="https://nativespot.com/apijs/v1.js" async></script>
			<script type="text/javascript">
				var NativeAdPub = window.NativeAdPub || [];
			</script><script async='async' type="text/javascript" src="https://static.criteo.net/js/ld/publishertag.js"></script>
			<script>
				window.Criteo = window.Criteo || {};
				window.Criteo.events = window.Criteo.events || [];
			</script>
			
			<script src="//ekstat.com/js/jquery-combo.js?v=mwhaxvsdEEumANXGcnrvvLGclg4GytC8oCGGcllT1wg1"></script>
			<script src="//ekstat.com/js/ek$i-combo.js?v=1OhRL53rpHz2o2T-nS7oFnfnjI9I-3K9iWGg8z9QLLs1"></script>
			
			
			
			
			<meta property="fb:app_id" content="151735074873255">
			<meta property="og:site_name" content="Kopya Sözlük">
			<meta property="og:locale" content="tr_TR">
			<meta property="og:type" content="article">
			<meta property="og:image" content="klon.png">
			
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="apple-touch-icon" sizes="180x180" href="//ekstat.com/img/klon.png">
			<link rel="icon" type="image/png" href="//ekstat.com/img/klon.png" sizes="32x32">
			<link rel="icon" type="image/png" href="//ekstat.com/img/klon.png" sizes="16x16">
			<link rel="manifest" href="/manifest.json">
			<link rel="mask-icon" href="//ekstat.com/img/safari-pinned-tab.svg" color="#7896da">
			<meta name="apple-mobile-web-app-title" content="kopya sözlük">
			<meta name="application-name" content="kopya sözlük">
			<meta name="theme-color" content="#ffffff">
			
			<meta name="alexaVerifyID" content="cXblkXxlVEqWAUY8vW30RVU7kBc">
			
			<meta name="globalsign-domain-verification" content="nWbNb4EViY7qYbSe_wfnNYHv-lD1Ml7PSyio8Lz2zZ">
			<script type="text/javascript">
				var googletag = googletag || {};
				googletag.cmd = googletag.cmd || [];
				(function() {
					var gads = document.createElement("script");
					gads.async = true;
					gads.type = "text/javascript";
					var useSSL = "https:" == document.location.protocol;
					gads.src = (useSSL ? "https:" : "http:") + "//www.googletagservices.com/tag/js/gpt.js";
					var node =document.getElementsByTagName("script")[0];
					node.parentNode.insertBefore(gads, node);
				})();
			</script>
			
			
			<meta name="homepage" content="True" />
			<meta name="user-rank" content="0" />
			<meta name="is-user-country-tr" content="1" />
			
	</head>
	<body class="light-theme theme-disabled" itemscope itemtype="http://schema.org/WebPage">
		
		
		<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
						<symbol id="eksico-filter" viewBox="0 0 512 512">
				<path d="m226 133l284 0 0 19-284 0z m-224 0l57 0 0 19-57 0z m140-57c37 0 67 29 67 66 0 37-30 66-67 66-36 0-66-29-66-66 0-37 30-66 66-66m0-19c-47 0-85 38-85 85 0 47 38 85 85 85 47 0 86-38 86-85 0-47-39-85-86-85z m-140 303l284 0 0 19-284 0z m451 0l57 0 0 19-57 0z m-83-57c36 0 66 30 66 66 0 37-30 67-66 67-37 0-67-30-67-67 0-36 30-66 67-66m0-19c-47 0-86 38-86 85 0 47 39 86 86 86 47 0 85-39 85-86 0-47-38-85-85-85z" />
			</symbol>
			<symbol id="eksico-search" viewBox="0 0 512 512">
				<path d="m507 507c-2 3-6 5-10 5-4 0-8-2-11-5l-143-142c-74 63-182 66-259 7-78-59-104-164-63-252 41-88 138-136 233-115 95 21 162 106 162 203 0 50-18 98-51 135l142 143c6 6 6 15 0 21z m-123-299c0-97-79-176-176-176-97 0-176 79-176 176 0 97 79 176 176 176 97 0 176-79 176-176z" />
			</symbol>
			
			<symbol id="eksico-thumbs-o-up" viewBox="0 0 512 512">
				<path d="m110 384c0-5-2-9-6-13-3-3-8-5-13-5-5 0-9 2-12 5-4 4-6 8-6 13 0 5 2 9 6 13 3 3 7 5 12 5 5 0 10-2 13-5 4-4 6-8 6-13z m329-165c0-9-4-18-11-25-8-7-16-11-26-11l-100 0c0-11 4-26 13-46 10-19 14-34 14-46 0-18-3-32-9-41-6-9-18-13-37-13-5 5-8 13-10 24-3 11-6 23-9 36-4 12-9 23-17 31-4 4-12 13-22 26-1 1-3 4-7 9-3 4-6 8-9 11-2 3-5 7-10 12-4 5-8 10-11 13-3 3-7 7-11 10-4 4-8 6-11 8-4 2-8 2-11 2l-9 0 0 183 9 0c3 0 6 1 9 1 4 1 7 1 10 2 3 1 6 2 11 3 4 2 8 3 10 3 2 1 5 2 10 4 4 2 7 3 8 3 40 14 73 21 98 21l34 0c37 0 55-16 55-48 0-5 0-10-1-16 6-3 10-8 13-15 4-7 5-14 5-21 0-7-1-13-5-20 10-9 15-20 15-34 0-4-1-10-2-15-2-6-5-11-8-14 7 0 12-5 16-13 4-9 6-17 6-24z m36 0c0 17-4 33-14 47 2 6 3 13 3 19 0 15-4 29-11 42 1 4 1 8 1 12 0 19-6 36-17 51 0 26-8 47-24 62-17 16-38 23-65 23l-37 0c-18 0-36-2-54-6-18-4-39-11-62-19-22-7-35-11-40-11l-82 0c-10 0-19-4-26-11-7-7-10-16-10-26l0-183c0-10 3-18 10-25 7-8 16-11 26-11l78 0c7-5 20-19 40-44 11-15 21-27 30-37 5-5 8-13 10-24 2-12 5-24 9-37 4-12 10-22 18-30 7-7 16-11 25-11 16 0 31 3 44 9 12 6 22 16 29 29 6 13 10 31 10 53 0 18-5 36-14 55l50 0c20 0 37 8 52 22 14 14 21 32 21 51z" />
			</symbol>
			
			<symbol id="eksico-thumbs-o-down" viewBox="0 0 512 512">
				<path d="m110 128c0-5-2-9-6-13-3-3-8-5-13-5-5 0-9 2-12 5-4 4-6 8-6 13 0 5 2 9 6 13 3 3 7 5 12 5 5 0 10-2 13-5 4-4 6-8 6-13z m329 165c0-7-2-15-6-24-4-8-9-13-16-13 3-3 6-8 8-14 1-5 2-11 2-15 0-14-5-25-15-34 4-7 5-13 5-20 0-7-1-14-5-21-3-7-7-12-13-15 1-6 1-11 1-16 0-16-4-28-14-36-9-8-22-12-39-12l-36 0c-25 0-58 7-98 21-1 0-4 1-8 3-5 2-8 3-10 4-2 0-6 1-10 3-5 1-8 2-11 3-3 1-6 1-10 2-3 0-6 1-9 1l-9 0 0 183 9 0c3 0 7 0 11 2 3 2 7 4 11 8 4 3 8 7 11 10 3 3 7 8 11 13 5 5 8 9 10 12 3 3 6 7 9 11 4 5 6 8 7 9 10 13 18 22 22 26 8 8 13 19 17 31 3 13 6 25 9 36 2 11 5 19 10 24 19 0 31-4 37-13 6-9 9-23 9-41 0-12-4-27-14-46-9-20-13-35-13-46l100 0c10 0 18-4 26-11 7-7 11-16 11-25z m36 0c0 19-7 37-21 51-15 14-32 22-52 22l-50 0c9 19 14 37 14 55 0 22-4 40-10 53-7 13-17 23-29 29-13 6-28 9-44 9-9 0-18-4-25-11-7-6-12-14-16-23-4-9-6-18-7-26-1-8-3-16-5-24-2-8-5-14-9-18-9-10-19-22-30-37-20-25-33-39-40-44l-78 0c-10 0-19-3-26-11-7-7-10-15-10-25l0-183c0-10 3-19 10-26 7-7 16-11 26-11l82 0c5 0 18-4 40-11 24-9 45-15 64-19 18-4 37-6 57-6l32 0c26 0 48 7 64 22 17 15 25 36 25 62l0 1c11 15 17 32 17 51 0 4 0 8-1 12 7 13 11 27 11 42 0 6-1 13-3 19 10 14 14 30 14 47z" />
			</symbol>
			
			<script>
				var pp_gemius_identifier = 'bJub8NwkyDhwR5K9_vQ5U7PpLTCyoIOWs9yGN3kl4cz.d7';
			</script>
			<div class="ad-double-click ad-1x1 ad-banner ad-doubleclickwebinterstital ads" data-info="{&quot;NetworkIdentifier&quot;:&quot;/1024435/Eksisozluk_Web_Interstital&quot;,&quot;Slot&quot;:&quot;div-gpt-ad-1458669134912-0&quot;,&quot;NetworkCode&quot;:&quot;1024435&quot;,&quot;Target&quot;:&quot;Eksisozluk_Web_Interstital&quot;,&quot;IsLazyLoad&quot;:false,&quot;Size&quot;:[1,1],&quot;Name&quot;:&quot;DoubleClickWebInterstital&quot;,&quot;DisplayTypes&quot;:4}"></div>
			
			
			
			<?php
				include "header.php";
			?>
		
			
			<ul class="topic-list partial" data-timestamp="0000000000000">
				<?php
					include "topics.php";
					
				?>
				
			</nav>
		</div>
        <div id="main">
            <div class="under-top-ad">
                <div class="web-top-ad-not-loaded ad-double-click ad-970x250 ad-banner ad-doubleclickwebthemebanner ads" data-info="{&quot;NetworkIdentifier&quot;:&quot;/1024435/EksiSozluk_Web_Tema_Banner_970x250&quot;,&quot;Slot&quot;:&quot;div-gpt-ad-1458688923087-0&quot;,&quot;NetworkCode&quot;:&quot;1024435&quot;,&quot;Target&quot;:&quot;EksiSozluk_Web_Tema_Banner_970x250&quot;,&quot;IsLazyLoad&quot;:false,&quot;Size&quot;:[970,250],&quot;Name&quot;:&quot;DoubleClickWebThemeBanner&quot;,&quot;DisplayTypes&quot;:4}"></div>
                
                
                
			</div>
			
            <div id="content" class="instapaper_body" role="main">
                <section id="content-body">
                    
					<?php echo $success ?>
					<div class="form-container" id="register-form-container">
						<h1>yeni kullanıcı kaydı</h1>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" class="registration-form" id="register-form" method="post"><input name="__RequestVerificationToken" type="hidden" />      <input id="nickControlEndpointUrl" type="hidden" value="/registration/canregisternick" />
							<fieldset class="vertical">
								<div>
									<label for="Nick">kullanıcı adı</label>
									<input id="Nick" name="Name" type="text" value="" />
									<?php echo ("<font color=\"red\">$nick_not_found</font>") ?>
								</div>
								<div>
									<label for="Email">e-mail</label>
									<input id="Email" name="Email" type="email" value="" />
									<?php echo ("<font color=\"red\">$email_not_found</font>") ?>
								</div>
								<div class="date-row">
									<label for="Birthdate">doğum tarihi</label>
									<select class="birthdate-day" id="Birthdate_Day" name="BirthdateDay"><option></option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
									</select>
									<select class="birthdate-month" id="Birthdate_Month" name="BirthdateMonth"><option></option>
										<option value="1">ocak</option>
										<option value="2">şubat</option>
										<option value="3">mart</option>
										<option value="4">nisan</option>
										<option value="5">mayıs</option>
										<option value="6">haziran</option>
										<option value="7">temmuz</option>
										<option value="8">ağustos</option>
										<option value="9">eylül</option>
										<option value="10">ekim</option>
										<option value="11">kasım</option>
										<option value="12">aralık</option>
									</select>
									<select class="birthdate-year" id="Birthdate_Year" name="BirthdateYear"><option></option>
										<option value="2001">2001</option>
										<option value="2000">2000</option>
										<option value="1999">1999</option>
										<option value="1998">1998</option>
										<option value="1997">1997</option>
										<option value="1996">1996</option>
										<option value="1995">1995</option>
										<option value="1994">1994</option>
										<option value="1993">1993</option>
										<option value="1992">1992</option>
										<option value="1991">1991</option>
										<option value="1990">1990</option>
										<option value="1989">1989</option>
										<option value="1988">1988</option>
										<option value="1987">1987</option>
										<option value="1986">1986</option>
										<option value="1985">1985</option>
										<option value="1984">1984</option>
										<option value="1983">1983</option>
										<option value="1982">1982</option>
										<option value="1981">1981</option>
										<option value="1980">1980</option>
										<option value="1979">1979</option>
										<option value="1978">1978</option>
										<option value="1977">1977</option>
										<option value="1976">1976</option>
										<option value="1975">1975</option>
										<option value="1974">1974</option>
										<option value="1973">1973</option>
										<option value="1972">1972</option>
										<option value="1971">1971</option>
										<option value="1970">1970</option>
										<option value="1969">1969</option>
										<option value="1968">1968</option>
										<option value="1967">1967</option>
										<option value="1966">1966</option>
										<option value="1965">1965</option>
										<option value="1964">1964</option>
										<option value="1963">1963</option>
										<option value="1962">1962</option>
										<option value="1961">1961</option>
										<option value="1960">1960</option>
										<option value="1959">1959</option>
										<option value="1958">1958</option>
										<option value="1957">1957</option>
										<option value="1956">1956</option>
										<option value="1955">1955</option>
										<option value="1954">1954</option>
										<option value="1953">1953</option>
										<option value="1952">1952</option>
										<option value="1951">1951</option>
										<option value="1950">1950</option>
										<option value="1949">1949</option>
										<option value="1948">1948</option>
										<option value="1947">1947</option>
										<option value="1946">1946</option>
										<option value="1945">1945</option>
										<option value="1944">1944</option>
										<option value="1943">1943</option>
										<option value="1942">1942</option>
										<option value="1941">1941</option>
										<option value="1940">1940</option>
										<option value="1939">1939</option>
										<option value="1938">1938</option>
										<option value="1937">1937</option>
										<option value="1936">1936</option>
										<option value="1935">1935</option>
										<option value="1934">1934</option>
										<option value="1933">1933</option>
										<option value="1932">1932</option>
										<option value="1931">1931</option>
										<option value="1930">1930</option>
										<option value="1929">1929</option>
										<option value="1928">1928</option>
										<option value="1927">1927</option>
										<option value="1926">1926</option>
										<option value="1925">1925</option>
										<option value="1924">1924</option>
										<option value="1923">1923</option>
										<option value="1922">1922</option>
										<option value="1921">1921</option>
										<option value="1920">1920</option>
										<option value="1919">1919</option>
										<option value="1918">1918</option>
										<option value="1917">1917</option>
										<option value="1916">1916</option>
										<option value="1915">1915</option>
										<option value="1914">1914</option>
										<option value="1913">1913</option>
										<option value="1912">1912</option>
										<option value="1911">1911</option>
										<option value="1910">1910</option>
										<option value="1909">1909</option>
										<option value="1908">1908</option>
										<option value="1907">1907</option>
										<option value="1906">1906</option>
										<option value="1905">1905</option>
										<option value="1904">1904</option>
										<option value="1903">1903</option>
										<option value="1902">1902</option>
										<option value="1901">1901</option>
										<option value="1900">1900</option>
									</select>
									<br><br>
									<?php echo ("<font color=\"red\">$bd_not_found</font>") ?>
									
								</div>
								<div>
									<label for="Gender">cinsiyet</label>
									<div class="single-select-toggle">
										<input type="hidden" id="Gender"/>
										<div class="btn-group" name="btn-gender">
											<input type="radio" name="Gender" data-value="1" value="1" class="btn ">erkek<br>
											<input type="radio" name="Gender"  data-value="2" value="2" class="btn ">kadın<br>
											<input type="radio" name="Gender" data-value="3" value="3" class="btn ">söylemem<br>
											<?php echo ("<font color=\"red\">$gender_not_found</font>") ?>
										</div>
									</div>
									
								</div>
								
								<div style="margin-top:30px">
									<div class="row">
										<div style="float: left; width: 30px; padding-top: 5px;">
											<p>
												<svg class="eksico">
													<use xlink:href="#eksico-tip"></use>
												</svg>
												</p>
												</div>
												<div style="float: left; width: 280px;">
												<p>
												şifrenizin <strong>
												diğer sitelerde kullandığınız şifrelerden farklı
												olmasını
												</strong> öneriyoruz. gerçi hashing bile yok.
												</p>
												</div>
												</div>
												</div>
												<div class="row">
												<div class="col-label">
												<label for="Password">şifre</label>
												</div>
												<div class="col-input">
												<div id="pw-strength-meter">
												<span class="meter-indicator"></span>
												</div>
												<input id="Password" name="Password" type="password" />
												
												<div class="validation-conditions-container">
												<div class="cond-error">şifre en az 8 karakter içermelidir.</div>
												
												</div>
												<?php echo ("<font color=\"red\">$pass_not_found</font>") ?>
												</div>
												</div>
												<div class="row">
												<div class="col-label">
												<label for="PasswordConfirm">şifre (tekrar)</label>
												</div>
												<div class="col-input">
												<input id="PasswordConfirm" name="PasswordConfirm" type="password" />
												<?php echo ("<font color=\"red\">$repeat_not_found</font>") ?>
												</div>
												</div>
												
												<div>
												<label class="checkbox">
												<input id="RequestConfirmed" name="RequestConfirmer" type="checkbox" value="true" />
												kayıt olmak istediğimden eminim
												</label>
												<?php echo ("<font color=\"red\">$not_checked</font>") ?>
												
												</div>
												<div class="actions">
												<button type="submit" class="btn btn-primary btn-lg btn-block">kaydı ateşle</button>
												</div>
												</fieldset>
												</form></div>
												
												<?php include "footer.php" ?>												