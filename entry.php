<style>
	.edit-entry:link {
		font-size: 70%;
		text-decoration:none;
	
	}
</style>

<ul id="entry-item-list" class="home-page-entry-list" style="margin-bottom:50px;"><?php
	define("DIVISION", 10);
	function set_entries() { 
	include "db.php"; 
			$log = $_SESSION["id"];
			$entries = [];
	if(isset($_GET['t'])) 
		{
			$getvar = $_GET['t'];
			if($_SESSION["authority"] != 2) {
				$entries = $db->entries()->select("*")->where("(topic_id = $getvar AND isHidden = 0) OR (topic_id = $getvar AND usr_id = $log AND isHidden = 1)");
				} else {
				$entries = $db->entries()->select("*")->where("topic_id = $getvar");
			}
		}
		else if(isset($_GET['tn'])) 
		{
			$getvar = $_GET['tn'];
			$topic_id = $db->topics("name = ?", $getvar)->fetch();
			if($_SESSION["authority"] != 2) {
				$entries  = $db->entries()->select("*")->where("(topic_id = $topic_id[topic_id] AND isHidden = 0) OR (topic_id = $topic_id[topic_id] AND usr_id = $log AND isHidden = 1)");
				} else {
				$entries  = $db->entries()->select("*")->where("topic_id = $topic_id[topic_id]");
			}
		}
		else if(isset($_GET['e'])) 
		{
			$getvar = $_GET['e'];
			if($_SESSION["authority"] != 2) {
				$entries  = $db->entries()->select("*")->where("(entry_id = $getvar AND isHidden = 0) OR (entry_id = $getvar AND usr_id = $log AND isHidden = 1)");
				} else {
				$entries  = $db->entries()->select("*")->where("entry_id = $getvar");
			}
		}
	return $entries;
	}
	$entries = set_entries();
	
	if(isset($_GET['tn'])) {
		if(empty($_GET['tn'])) {
			$message = "boş burası, boş!";
		}
	}

	if(empty($entries[0])) 
	{
		if(isset($_GET['t'])) 
		{
			$message = "böyle bir başlık numarası yokmuş ki!";
		} 
		else if(isset($_GET['tn'])) 
		{
		if(!empty($_GET['tn'])) {
			$message = "böyle bir başlık yokmuş ki!<br>ama olabilir de.";
		}
		}
		else if(isset($_GET['e'])) 
		{
			$message = "böyle bir giri yokmuş ki!";
		}
		else
		{
			$message = "sol frame'den bir başlık seçin.";
		}
		echo "<li data-id=\"0\" data-author=\"username\" data-author-id=\"1\" data-flags=\"share report vote\">
		<div class=\"content\">
		$message
		</div>
		<footer>
		<div class=\"feedback\"></div><div class=\"info\">
		</div>
		</footer>
		<div class=\"comment-summary\">
		<div class=\"comment-pages\">
		</div>
		</div>"	 ; 
	} 
	else 
	{
	if(isset($_GET['p'])) 
	{
		$entries->limit(DIVISION, ((int)$_GET['p'] - 1) * DIVISION);
	}
	else 
	{
		$entries->limit(DIVISION);
	}
		$counter = (isset($_GET['p']) ? ($_GET['p'] - 1)* DIVISION : 0 );
		foreach($entries as $e => $entry) 
		{
			$counter++;
		    $edit_date = "";
			$identifier = $entry["usr_id"];
			$user_of_entry = $db->users('usr_id = ?', $identifier)->fetch();
			$date = new DateTime($entry["post_date"]);
			$date_edit = new DateTime($entry["edit_date"]);
			$edit_format = $date_edit->format('d.m.Y H:i');
			$proper_format = $date->format('d.m.Y H:i');
			if($edit_format != "01.01.1970 00:00") {
				$edit_date = " ~ " . $edit_format;
			}
			if(($_SESSION["username"] === $user_of_entry["name"]) or $_SESSION["authority"] == 2) {
				echo "<li data-id=\"$entry[entry_id]\" data-author=\"$user_of_entry[name]\" data-author-id=\"1\" data-flags=\"share report vote\">
				<div class=\"content\">";
				
				if(!isset($_GET["e"])) {
					echo "<font color=\"darkred\">$counter</font>.";
				}
				
				echo " $entry[text]
				</div>
				<footer>
				<div class=\"feedback\"><a href=\"";
				
				echo htmlspecialchars($_SERVER["REQUEST_URI"]) . "&action=like&actionon=$entry[entry_id]";
				
				echo "\">şuku</a><a href='";
				
				echo htmlspecialchars($_SERVER["REQUEST_URI"]) . "&action=dislike&actionon=$entry[entry_id]";
				
				echo "'>eksi</a></div><div class=\"info\">
				<a class=\"entry-date permalink\" href=\"/mainpage.php?e=$entry[entry_id]\">$proper_format$edit_date</a>
				
				<a class=\"entry-author\" href=\"/user.php?u=$identifier\">$user_of_entry[name]</a><a class=\"edit-entry\" href=\"/edit.php?e=$entry[entry_id]\">(düzenle)</a>
				</div>
				</footer>
				<div class=\"comment-summary\">
				<div class=\"comment-pages\">
				</div>
				</div>"	 ; 
			} else {
				echo "<li data-id=\"$entry[entry_id]\" data-author=\"$user_of_entry[name]\" data-author-id=\"1\" data-flags=\"share report vote\">
				<div class=\"content\">";
				if(!isset($_GET["e"])) {
					echo "<font color=\"darkred\">$counter</font>.";
				}
				echo " $entry[text]
				</div>
				<footer><div class=\"feedback\">";
				if($_SESSION["username"] !== "") 
				{
					echo "<a href=\"";
					
					echo htmlspecialchars($_SERVER["REQUEST_URI"]) . "&action=like&actionon=$entry[entry_id]";
					
					echo "\">şuku</a><a href='";
					
					echo htmlspecialchars($_SERVER["REQUEST_URI"]) . "&action=dislike&actionon=$entry[entry_id]";
					
					echo "'>eksi</a>";
				}
				echo "</div><div class=\"info\">
				<a class=\"entry-date permalink\" href=\"/mainpage.php?e=$entry[entry_id]\">$proper_format$edit_date</a>
				
				<a class=\"entry-author\" href=\"/user.php?u=$identifier\">$user_of_entry[name]</a>
				</div>
				</footer>
				<div class=\"comment-summary\">
				<div class=\"comment-pages\">
				</div>
				</div>"	 ; 
			}
		}
	}

echo "</li>";
	if(!empty($entries[0])) {
	$entries_full = set_entries();
	if($entries->count() != $entries_full->count()) 
	{
		if(isset($_GET['p'])) {
			if($_GET['p'] >= 2) {
				echo "<a href='". $_SERVER["REQUEST_URI"] ."&p=" . ($_GET['p'] - 1) . "'><- önceki sayfa</a>";
			}
		}
		echo "<span style='margin-left:65%'></span>";
		if(isset($_GET['p'])) {
			if($entries_full->count() > ($_GET['p'] * DIVISION)) {
			    if($_GET['p'] == 1) echo "<span style='margin-left:15%'></span>";
				echo "<a href='". $_SERVER["REQUEST_URI"] ."&p=" . ($_GET['p'] + 1) . "'>sonraki sayfa -></a>";
			}
		}
		else
		{
			echo "<span style='margin-left:15%'></span>";
			echo "<a href='" . $_SERVER["REQUEST_URI"] . "&p=2'>sonraki sayfa -></a>";
		}

	}
	}
?>
</ul>