<div class="clearfix dropdown">
	<h2 title="<?php 
					if(!isset($_GET['s']) && !isset($_GET['c'])) {
						$today = new DateTime("now", new DateTimeZone('Europe/Istanbul'));
						$today = $today->format('Y-m-d');
						$count = $db->topics()->select("*")->where("last_active LIKE '$today%'")->order("last_active DESC")->count();
						$today_text = "bugün";
					} else if(!isset($_GET['c'])) {
						$got = htmlspecialchars($_GET['s']);
						$got = str_replace("*", "%", $got);
						$count = $db->topics()->select("*")->where("name LIKE '" .$got. "'")->order("last_active DESC")->count();
						$today_text = "arama \"$_GET[s]\"";					
					} else {
						$got = htmlspecialchars($_GET['c']);
						$count = $db->topics()->select("*")->where("channel = $got")->order("last_active DESC")->count();
						if($got === '1') $today_text = "kanal #bilim";
						if($got === '2') $today_text = "kanal #müzik";
						if($got === '3') $today_text = "kanal #edebiyat";
						if($got === '4') $today_text = "kanal #coding";
						if($got === '5') $today_text = "kanal #spor";
						if($got === '6') $today_text = "kanal #siyaset";
					}
					echo ($count . " başlık"); 
				echo '">' . $today_text  ?></h2>
			</div>
<?php
				
if(!isset($_GET['s'])  && !isset($_GET['c'])) {	
$today = new DateTime();
$today = $today->format('Y-m-d');
$topics = $db->topics()->select("*")->where("last_active LIKE '$today%'")->order("last_active DESC");
	foreach ($topics as $t => $topic) {
		if($_SESSION["authority"] != 2) 
		{
			$entries = $db->entries()->select("*")->where("topic_id = $topic[topic_id] AND post_date LIKE '$today%' AND (isHidden = 0 OR usr_id = $_SESSION[id])");
		}
		else
		{
			$entries = $db->entries()->select("*")->where("topic_id = $topic[topic_id] AND post_date LIKE '$today%'");			
		}
		$count = $entries->count();
		if($count != 0) {
			echo "<form id=\"form$topic[topic_id]\" method=\"post\" action=\"mainpage.php?t=$topic[topic_id]\"><li><a href=\"javascript:;\" 
			onclick=\"document.getElementById('form$topic[topic_id]').submit();\">$topic[name] <small>$count</small></a></li></form>
			<input type=\"hidden\" name=\"hidden$topic[topic_id]\" value=\"0\"</input>";
		}
	}
	if(empty($topics[0])) {
		echo "<li><a>Bugün kimse başlık açmamış ki!</a></li>";
	}
} else if(!isset($_GET['c'])) {
$got = htmlspecialchars($_GET['s']);
$got = str_replace("*", "%", $got);
$topics = $db->topics()->select("*")->where("name LIKE '" .$got. "'")->order("last_active DESC");
	foreach ($topics as $t => $topic) {
		if($_SESSION["authority"] != 2) 
		{
			$entries = $db->entries()->select("*")->where("topic_id = $topic[topic_id] AND (isHidden = 0 OR usr_id = $_SESSION[id])");
		}
		else
		{
			$entries = $db->entries()->select("*")->where("topic_id = $topic[topic_id]");			
		}
		$count = $entries->count();
		if($count != 0) {
			echo "<form id=\"form$topic[topic_id]\" method=\"post\" action=\"mainpage.php?t=$topic[topic_id]\"><li><a href=\"javascript:;\" 
			onclick=\"document.getElementById('form$topic[topic_id]').submit();\">$topic[name] <small>$count</small></a></li></form>
			<input type=\"hidden\" name=\"hidden$topic[topic_id]\" value=\"0\"</input>";
		}
	}
	if(empty($topics[0])) {
		echo "<li><a>Hiçbir şey yok!</a></li>";
	}

} else {

$got = htmlspecialchars($_GET['c']);
$topics = $db->topics()->select("*")->where("channel = " .$got)->order("last_active DESC");
	foreach ($topics as $t => $topic) {
		if($_SESSION["authority"] != 2) 
		{
			$entries = $db->entries()->select("*")->where("topic_id = $topic[topic_id] AND (isHidden = 0 OR usr_id = $_SESSION[id])");
		}
		else
		{
			$entries = $db->entries()->select("*")->where("topic_id = $topic[topic_id]");			
		}
		$count = $entries->count();
		if($count != 0) {
			echo "<form id=\"form$topic[topic_id]\" method=\"post\" action=\"mainpage.php?t=$topic[topic_id]\"><li><a href=\"javascript:;\" 
			onclick=\"document.getElementById('form$topic[topic_id]').submit();\">$topic[name] <small>$count</small></a></li></form>
			<input type=\"hidden\" name=\"hidden$topic[topic_id]\" value=\"0\"</input>";
		}
	}
	if(empty($topics[0])) {
		echo "<li><a>Bu kanal bomboş!</a></li>";
	}

}
?>