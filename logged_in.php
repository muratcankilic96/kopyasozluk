    <ul>
	<?php
	$id = $_SESSION['id'];
	if($_SESSION["authority"] == 2) {
	echo "
		<li>
          <a href='/panel.php'>
            admin paneli
          </a>
        </li>";
		}
	?>
	
	    <li <?php 
		
		$q = $db->messages()->select("*")->where("receiver_id = " . $_SESSION["id"] . " AND isRead = 0");
		if($q->count() !== 0) {
			echo 'style="border-radius: 30px 30px 30px 30px / 25px 25px 25px 25px;background-color:lightblue"';
		}
		
		?>
		
		>
          <a href="/message.php">
            mesajlar
          </a>
        </li>
        
        <li>
          <a id="top-login-link" href="/user.php?u=<?php echo $id?>">
            ben
          </a>
        </li>
		  <li>
          <a href="/mainpage.php?logout=true">
            çıkış yap
          </a>
        </li>
    </ul>