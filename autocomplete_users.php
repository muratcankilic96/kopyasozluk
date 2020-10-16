						<?php
							echo "<script> var arr = [];";
							$users = $db->users()->select("*");
							foreach($users as $u => $user) {
								echo "arr.push('" . $user['name'] . "');";
							}
							echo "
							var who = document.getElementById('input-receipt');	
							who.addEventListener('input', function() {
							closeAllLists();
							var list = document.createElement('DIV');
							var inp = this.value;
							if (!inp) { return false;}
							list.setAttribute('id', this.id + 'form');
							list.setAttribute(\"class\", \"autocomplete\");
							this.parentNode.appendChild(list);
							for (i = 0; i < arr.length; i++) {
							if (arr[i].substr(0, inp.length).toLowerCase() === inp.toLowerCase()) {
							b = document.createElement(\"DIV\");
							b.innerHTML += \"<input type='button' value='\" + arr[i] + \"'>\";
							b.addEventListener('click', function(e) {
							who.value = this.getElementsByTagName('input')[0].value;
							closeAllLists();
							});
							list.appendChild(b);
							}
							}
							});
							
							function closeAllLists(elmnt) {
							var x = document.getElementsByClassName('autocomplete');
							for (var i = 0; i < x.length; i++) {
							if (elmnt != x[i] && elmnt != who) {
							x[i].parentNode.removeChild(x[i]);
							}
							}
							}
							
							document.addEventListener('click', function (e) {
							closeAllLists(e.target);
							});
							</script>"
						?>