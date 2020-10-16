<div id="profile-intro" style="height:40%;max-height:900px;position=absolute;overflow:auto">
	<div id="profile-intro-header" class="clearfix" style="height:20%;max-height:900px;position=absolute">
		<h1 id="user-profile-title" data-nick="hakki bluoyd"  style="height:20%;max-height=900px;position=absolute">
			<?php
			$username = $db->users("usr_id = ?", $_GET['u'])->fetch();
				echo '
				<a href="/mainpage.php?tn='. $username['name'] .'">'.$username['name'].'</a>
				</h1>
				<div class="clearfix">
				<div class="sub-title-menu profile-buttons">
				
				</div>
				</div>
				<ul id="user-badges">
				</ul>';
				

				
				$select = null;
				$u = $_GET['u'];
				$query = $db->entries()->select("*")->where("usr_id = " . $u);
				$array = range(0, $query->count()-1);
				shuffle($array);
				$i = 0;
				foreach($query as $q => $entry) 
				{
					if($array[$i] == 0) $select = $entry;
					$i = $i + 1;
				}
				$topic = $db->topics("topic_id = ?", $select["topic_id"])->fetch();
				
				$date = new DateTime($select["post_date"]);
				$proper_format = $date->format('d.m.Y H:i');
				echo '<ul id="user-entry-stats">
				<li id="entry-count-total" title="toplam entry sayısı">Toplam entry sayısı: '.$query->count().'</li>
				</ul>';
				
				echo '<blockquote id="quote-entry">
				
				<h2><a href="/mainpage.php?e='. $select["entry_id"] .'">'. $topic["name"]. '</a></h2>
				<div class="content" >
				<p>
				'.$select["text"].'
				</p>
				</div>
				<footer>'. $proper_format. '</footer>
				</blockquote>
				</div>
			</div>'
?>