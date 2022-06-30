<div class="inputgroup">
 <label for="_{{$name}}">{{__($name)}}</label>
 <input type="text" name="_{{$name}}" id="_{{$name}}" />
 <input type="button" value="+" onClick="
       if (getElementById('_{{$name}}').value != '') {
	     getElementById('value_{{$name}}').innerHTML += '<li>'+getElementById('_{{$name}}').value+'</li>';
	     getElementById('{{$name}}').value += getElementById('_{{$name}}').value+'|';
	     getElementById('_{{$name}}').value = '';
	     } 	         
	     "/>
	<input type="hidden" name="{{$name}}" id="{{$name}}" value=""/>
	<ul id="value_{{$name}}"></ul>
  <script>
	$(document).ready(function () {
		var options = {
  			url: function(phrase) {
    			return "/ajax/objectSearch";
  			},
  			getValue: function(element) {
    			return element.name;
  			},
  			ajaxSettings: {
    			dataType: "json",
    			method: "POST",
    			data: {
      				dataType: "json",
      				allowedObjects: {!! $allowed_objects !!},
      				_token: "{{csrf_token()}}"
    			}
  			},
  			preparePostData: function(data) {
    			data.phrase = $("#_{{$name}}").val();
    			return data;
  			},
			list: {
				onChooseEvent: function() {
          getElementById('{{$name}}').value += $("#_{{$name}}").getSelectedItemData().id+'|'
				}
			},
  			requestDelay: 400
		};
	 $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });	
		$("#_{{$name}}").easyAutocomplete(options);
	});
		 </script>
</div>
