<?php
	ob_start();
	$d = new DateTime("now", new DateTimeZone('Europe/Istanbul'));
	$date = $d->format('Y-m-d H:i:s');
	$entry_empty = "";
	if (isset($_GET["e"])) {
		$e = $_GET["e"];
		$entry = $db->entries("entry_id = $e")->fetch();
		$edit_text = $entry["text"];
		$edit_text = str_replace("<br>", "\n", $edit_text);
		$edit_text = str_replace("<strong>", "*", $edit_text);
		$edit_text = str_replace("</strong>", "*", $edit_text);
		$edit_text = str_replace("<u>", "~", $edit_text);
		$edit_text = str_replace("</u>", "~", $edit_text);
		$edit_text = str_replace("<em>", "_", $edit_text);
		$edit_text = str_replace("</em>", "_", $edit_text);
		$edit_text = preg_replace("#bkz: \(<a href=\"mainpage\.php\?(.+)\">(.+)<\/a>\)#", "bkz:($2)", $edit_text);
		$edit_text = preg_replace("#<a href=\"mainpage\.php\?(.+)\">(.+)<\/a>#", "¨$2¨", $edit_text);
		$edit_text = preg_replace("#<a title=\"(.+)\" href=\"mainpage\.php\?tn=(.+)\">\*<\/a>#", ":`$2`:", $edit_text);
	}
	
	if(!empty($_POST["action"])) 
	{
		if($_POST["action"] === "delete") {
			$_SESSION["delete"]++;
			$entry_empty = "eğer bu tuşa ikinci kez basarsanız entry silinir.";
			if($_SESSION["delete"] == 2) {
				$db->entries("entry_id = ?", "$e")->delete();
				if(!headers_sent()) {
					header("Location: /mainpage.php?t=" . $entry["topic_id"]);
					exit();
			}
			}
		}
		if($_POST["action"] === "back") {
			if(!headers_sent()) {
				header("Location: /mainpage.php?e=" . $e);
				exit();
			}
		}
		if($_POST["action"] === "send") {
			$txt = $_POST["Content"];
			if(empty($txt))
			{
				$entry_empty = "entry en az bir harf içersin lütfen.";
			}
			else if($txt === $edit_text) 
			{	
				
				$entry_empty = "aynı şey yazılmaz, yazılacaksa da geri dönülür.";
				} else {
				$txt = htmlspecialchars($_POST["Content"]);
				$txt = addslashes($txt);
				$txt = mb_strtolower($txt, 'utf8');
				$txt = str_replace("\n", "<br>", $txt);
				$txt = preg_replace('#\*(.*?)\*#', '<strong>$1</strong>', $txt);
				$txt = preg_replace('#\~(.*?)\~#', '<u>$1</u>', $txt);
				$txt = preg_replace('#\_(.*?)\_#', '<em>$1</em>', $txt);
				$txt = preg_replace('#(b|B)(k|K)(z|Z):\((.*?)\)#', 'bkz: (<a href="mainpage.php?tn=$4">$4</a>)', $txt);
				$txt = preg_replace("/¨(.*?)¨/", '<a href="mainpage.php?tn=$1">$1</a>', $txt);
				$txt = preg_replace("/\:`(.*?)`\:/", '<a title="$1" href="mainpage.php?tn=$1">*</a>', $txt);
				echo $txt;
				mysql_real_escape_string($txt);
				$sql = "UPDATE entries SET			
				edit_date = '" . $date ."', text = '". $txt .
				"' WHERE entry_id = " .$e;
				$query = $pdo->prepare($sql);
				$query->execute();
				
				if(!headers_sent()) {
					header("Location: /mainpage.php?e=" . $e);
					exit();
				}
			}
		}
	
	}
?>

<form action="<?php echo (htmlspecialchars($_SERVER["REQUEST_URI"]));?>" class="editform" method="post"><input name="__RequestVerificationToken" type="hidden" />  <fieldset class="vertical">
    <input data-val="true" data-val-required="The Title field is required." id="Title" name="Title" type="hidden" value="" />
    <input id="Id" name="Id" type="hidden" value="33210" />
    <input id="ReturnUrl" name="ReturnUrl" type="hidden" value="" />
    <input data-val="true" data-val-date="The field InputStartTime must be a date." id="InputStartTime" name="InputStartTime" type="hidden" value="12.7.2018 14:11:53" />
    
	<span class="field-validation-valid" data-valmsg-for="Content" data-valmsg-replace="true"></span>
	<div class="edittextbox">
		<?php
		include "buttons.php";
		?>
	<textarea class="edittextbox with-helpers track-changes" cols="80" data-val="true" data-val-required="entry girme eylemi en az bir tuş basımından ibaret olmalıdır" id="editbox" name="Content" placeholder="&quot;<?php echo $topic["name"] ?>&quot; hakkında bir şeyler girin" rows="10"><?php echo $edit_text ?></textarea>
	
	
    <div class="actions">
        <span id="draft-progress-area"></span>
		
		<div class="dropdown edit-form-options">
			
			<div class="dropdown-menu">
				<div class="checkbox"><input data-val="true" data-val-required="The sabaha bırak field is required." id="AddAsHidden" name="AddAsHidden" type="checkbox" value="true" /><input name="AddAsHidden" type="hidden" value="false" />
					
				</div>
			<span class="field-validation-valid" data-valmsg-for="AddAsHidden" data-valmsg-replace="true"></span>              </div>
		</div> &nbsp;&nbsp;
		<button type="submit" class="primary" name="action" value="send">gönder</button>
		<button type="submit" class="secondary" name="action" value="delete">imha</button>
		<button type="submit" class="secondary" name="action" value="back">geri dön</button>
		<?php echo ("<font color=\"red\">$entry_empty</font>") ?>
	</div>
</fieldset>
</form>   