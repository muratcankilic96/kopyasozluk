
<div class="edittextbox">
	<input type="button" id="bakz" value="(bkz: link)" onclick="bkz()"></input>
	<input type="button" id="linkclick" value="link" onclick="link()"></input>
	<input type="button" id="hiddenclick" value="*" onclick="hiddenizer()"></input>
	<input type="button" id="spoilerz" value="spoiler" onclick="spoiler()"></input>
	<input type="button" id="kalın" value="şey" style="font-weight:bold" onclick="boldize()"></input>
	<input type="button" id="italik" value="şey" style="font-style:italic" onclick="italicize()"></input>
	<input type="button" id="cizili" value="şey" style="text-decoration: underline" onclick="lineadder()"></input></div>

<script>
	var bkz = function()
	{
		var w = window.prompt("neye bakınız?");
		if(w != null) {
			var t = document.getElementById('editbox');
			var startPos = t.selectionStart;
			var endPos = t.selectionEnd;
			t.value = t.value.substring(0, startPos)
            + 'bkz:(' + w +')'
            + t.value.substring(endPos, t.value.length);
		}
	}
	var link = function()
	{
		var w = window.prompt("neye link verelim?");
		if(w != null) {
			var t = document.getElementById('editbox');
			var startPos = t.selectionStart;
			var endPos = t.selectionEnd;
			t.value = t.value.substring(0, startPos)
            + '¨' +w +'¨'
            + t.value.substring(endPos, t.value.length);
		}
	}
	var hiddenizer = function()
	{
		var w = window.prompt("neye gizli bakınız verelim?");
		if(w != null) {
			var t = document.getElementById('editbox');
			var startPos = t.selectionStart;
			var endPos = t.selectionEnd;
			t.value = t.value.substring(0, startPos)
            + ':`' + w +'`:'
            + t.value.substring(endPos, t.value.length);
			
		}
	}
	
	var spoiler = function()
	{
		var w = window.prompt("neye spoiler verelim?");
		if(w != null) {
			var t = document.getElementById('editbox');
			var startPos = t.selectionStart;
			var endPos = t.selectionEnd;
			t.value = t.value.substring(0, startPos)
            + '-- spoiler --\n' + w + '\n-- spoiler -- '
            + t.value.substring(endPos, t.value.length);
			
		}
	}
	
	var boldize = function()
	{
		var w = window.prompt("neyi kalınlaştıralım?");
		if(w != null) {
			var t = document.getElementById('editbox');
			var startPos = t.selectionStart;
			var endPos = t.selectionEnd;
			t.value = t.value.substring(0, startPos)
            + '*' + w + '*'
            + t.value.substring(endPos, t.value.length);
			
		}
	}
	
		var italicize = function()
	{
		var w = window.prompt("neyi yataylaştıralım?");
		if(w != null) {
			var t = document.getElementById('editbox');
			var startPos = t.selectionStart;
			var endPos = t.selectionEnd;
			t.value = t.value.substring(0, startPos)
            + '_' + w + '_'
            + t.value.substring(endPos, t.value.length);
			
		}
	}
	
		var lineadder = function()
	{
		var w = window.prompt("neyin altını çizelim?");
		if(w != null) {
			var t = document.getElementById('editbox');
			var startPos = t.selectionStart;
			var endPos = t.selectionEnd;
			t.value = t.value.substring(0, startPos)
            + '~' + w + '~'
            + t.value.substring(endPos, t.value.length);
			
		}
		
	}
	
	
	
	
	
	
</script>