<?php
	if(isset($_GET['header'])) 
			{
				$req = explode("?", $_SESSION["svr"]);
				$urn = ""; $qm = ""; $am = "?";
				$headeron = $_GET["headeron"];
				if(strpos($req[1], 'tn=') !== false || strpos($req[1], 't=') !== false || strpos($req[1], 'e=') !== false) 
				{ 
					$urn = $req[1];
					$qm = "?"; 
					$am = "&";
				}
				if($_GET['header'] === 'load') {
					if(!headers_sent()) {
						header('Location:' . '/mainpage.php?tn=' . $_GET["headeron"]);
						exit();
					}
				}
				if($_GET['header'] === 'search') {
					if(!headers_sent()) {
						header('Location:' . $_SERVER["PHP_SELF"] . $qm . $urn . $am . "s=" . $_GET["headeron"]);
						exit();
					}
				}
				
			}
	?>