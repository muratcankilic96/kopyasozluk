<?php
	ob_start();
	$entry_empty = "";
	if (isset($_GET["send"])) {
		if(empty($_POST["Content"])) 
		{
			$entry_empty = "entry en az bir harf içersin lütfen.";
		}
		else
		{
			$findmax = $db->topics()->max("topic_id");
			$txt = htmlspecialchars($_POST["Content"]);
			$txt = mb_strtolower($txt, 'utf8');
			$txt = str_replace("\n", "<br>", $txt);
				$txt = preg_replace('#\*(.*?)\*#', '<strong>$1</strong>', $txt);
				$txt = preg_replace('#\~(.*?)\~#', '<u>$1</u>', $txt);
				$txt = preg_replace('#\_(.*?)\_#', '<em>$1</em>', $txt);
				$txt = preg_replace('#(b|B)(k|K)(z|Z):\((.+)\)#', 'bkz: (<a href="mainpage.php?tn=$1">$1</a>)', $txt);
				$txt = preg_replace("/¨(.*?)¨/", '<a href="mainpage.php?tn=$1">$1</a>', $txt);
				$txt = preg_replace("/\:`(.*?)`\:/", '<a title="$1" href="mainpage.php?tn=$1">*</a>', $txt);
			if($_SESSION["authority"] == 0) {
				$hidden = 1;
			}
			else
			{
				$hidden = 0;
			}
			$array = array(
			"topic_id" 	 => $findmax + 1,
			"name"  => mb_strtolower(htmlspecialchars($_GET["tn"]), 'utf8'),
			"last_active" => new DateTime("now", new DateTimeZone('Europe/Istanbul')),
			"channel" => 0
			);
			$users = $db->topics()->insert($array);
			$findmax_entry = $db->entries()->max("entry_id");
			$array = array(
			
			"usr_id" 	 => $_SESSION["id"],
			"topic_id" 	 => $findmax + 1,
			"entry_id"   => $findmax_entry + 1,
			"text" 	     => $txt,
			"post_date" => new DateTime("now", new DateTimeZone('Europe/Istanbul')),
			"isHidden"  => $hidden
			);
			$users = $db->entries()->insert($array);

			if(!headers_sent()) {
				header('Location: /mainpage.php?e=' . ($findmax_entry + 1));
				exit();
			}
		}
	}

?>
<form action="<?php echo (htmlspecialchars($_SERVER["REQUEST_URI"] . "&send=true"));?>" class="editform" method="post"><input name="__RequestVerificationToken" type="hidden" />  <fieldset class="vertical">
    <input data-val="true" data-val-required="The Title field is required." id="Title" name="Title" type="hidden" value="" />
    <input id="Id" name="Id" type="hidden" value="33210" />
    <input id="ReturnUrl" name="ReturnUrl" type="hidden" value="" />
    <input data-val="true" data-val-date="The field InputStartTime must be a date." id="InputStartTime" name="InputStartTime" type="hidden" value="12.7.2018 14:11:53" />
    
<span class="field-validation-valid" data-valmsg-for="Content" data-valmsg-replace="true"></span>
<?php
	include "buttons.php";
	?>
<textarea class="edittextbox with-helpers track-changes" cols="80" data-val="true" data-val-required="entry girme eylemi en az bir tuş basımından ibaret olmalıdır" id="editbox" name="Content" placeholder="&quot;<?php echo $_GET["tn"] ?>&quot; başlığını şu sözlerle açın" rows="10">
</textarea>


    <div class="actions">
        <span id="draft-progress-area"></span>
      
<div class="dropdown edit-form-options">
  
  <div class="dropdown-menu">
<div class="checkbox"><input data-val="true" data-val-required="The sabaha bırak field is required." id="AddAsHidden" name="AddAsHidden" type="checkbox" value="true" /><input name="AddAsHidden" type="hidden" value="false" />
  <label for="AddAsHidden">sabaha bırak</label>
</div>
<span class="field-validation-valid" data-valmsg-for="AddAsHidden" data-valmsg-replace="true"></span>              </div>
</div> &nbsp;&nbsp;
      <button type="submit" class="primary">gönder</button>
	   <?php echo ("<font color=\"red\">$entry_empty</font>") ?>
    </div>
  </fieldset>
</form>