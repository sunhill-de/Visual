<div class="inputgroup">
 <label for="_tags">Tags</label>
 <input type="text" name="_tags" id="_tags" />
 <input type="button" value="+" onClick="
	     if (getElementById('_tags').value != '') {
	     getElementById('value_tags').innerHTML += '<li>'+getElementById('_tags').value+'</li>';
	     getElementById('tags').value += getElementById('_tags').value+'|';
	     getElementById('_tags').value = '';
	     } 	         
	     "/>
 <input type="hidden" name="tags" id="tags" value=""/>
 <ul id="value_tags"></ul>	     
</div>
