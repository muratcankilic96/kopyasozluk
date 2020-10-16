						<?php
							echo "<script> var topic_thing = [];";
							$topics = $db->topics()->select("*");
							foreach($topics as $t => $topic) {
								echo "topic_thing.push(\"" . $topic["name"] . "\");";
							}
							echo "
							var topiclist = document.getElementById('searcher_box');	
							topiclist.addEventListener('input', function() {
							closeAllLists();
							var penpu = document.createElement('DIV');
							var xalyu = this.value;
							if (!xalyu) { return false;}
							penpu.setAttribute('id', this.id + 'form');
							penpu.setAttribute(\"class\", \"autocomplete\");
							this.parentNode.appendChild(penpu);
							for (i = 0; i < topic_thing.length; i++) {
							if (topic_thing[i].substr(0, xalyu.length).toLowerCase() === xalyu.toLowerCase()) {
							b = document.createElement(\"DIV\");
							b.innerHTML += \"<input type='button' value='\" + topic_thing[i] + \"'>\";
							b.addEventListener('click', function(e) {
							topiclist.value = this.getElementsByTagName('input')[0].value;
							closeAllLists();
							});
							penpu.appendChild(b);
							}
							}
							});
							
							function closeAllLists(elmnt) {
							var x = document.getElementsByClassName('autocomplete');
							for (var i = 0; i < x.length; i++) {
							if (elmnt != x[i] && elmnt != topiclist) {
							x[i].parentNode.removeChild(x[i]);
							}
							}
							}
							
							document.addEventListener('click', function (e) {
							closeAllLists(e.target);
							});
							</script>"
						?>