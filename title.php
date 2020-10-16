<h1 id="title" data-title="klon" data-id="2"
data-preserved="">
  <a itemprop="url">
	<?php 
		if(isset($_GET['t'])) {
			$getvar = $_GET['t'];
			$topic = $db->topics('topic_id = ?', "$getvar")->fetch();
			echo $topic["name"];
		} 
		else if(isset($_GET['tn'])) 
		{
			$getvar = $_GET['tn'];
			$topic = $db->topics('name = ?', "$getvar")->fetch();
			if(empty($topic["name"])) {
				echo "$_GET[tn]";
			} else {
				echo $topic["name"];
			}
		}
		else if(isset($_GET['e'])) 
		{
			$getvar = $_GET['e'];
			$entry  = $db->entries('entry_id = ?', "$getvar")->fetch();
			$topic  = $db->topics('topic_id = ?', "$entry[topic_id]")->fetch();
			echo $topic["name"];
		}
		else
		{
			echo "Ana Sayfa";
		}
		
		
	?>
		</a>
</h1>