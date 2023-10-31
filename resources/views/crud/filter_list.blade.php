 <div class="field has-addons">
  <label class="label">{{ __('Filter condition').':' }}&nbsp;</label>
  <div class="control">
   <div class="select">
	<select id="choosefilter">
     <option value="none" {{ $filter_none }}>{{ __('no filter') }}</option>
     @foreach($filters as $filter)
     <option value="{{ $filter->value }}" {{ $filter->selected }}>{{ $filter->name }}</option>
     @endforeach
    </select>   
   </div>
  </div>
  <div class="control">
   <button class="button js-modal-trigger" id="add_filter" name="add_filter" data-target="filter-dialog">+</button>   
  </div>   
 </div>
 <form method="post" id="filterform" action="{{ route($crud_base.'.filter') }}">
 @csrf 
 <div id="filter-dialog" class="modal">
  <div class="modal-background"></div>

  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{ __('Filter dialog') }}</p>
      <button class="delete" aria-label="close"></button>    
    </header>
    <section class="modal-card-body">
 	  <div class="field is-grouped">
 	   <label class="label">{{ __('Conditions have to match') }}</label>
 	   <div class="select">
 	    <select name="connection">
 	     <option value="all">{{ __('all') }}</option>
 	     <option value="any">{{ __('any') }}</option>
 	    </select>
 	   </div>
 	  </div>
 	  <input type="hidden" id="cond_count" name="cond_count" value="1">
 	  <div class="field is-grouped">
 	   <label class="label">{{ __('Field') }}</label>
 	   <div class="control is-narrow">
  	    <div class="select">
  	     <select id="field" name="field1">
  	      <option value="" selected>{{ __('Choose a field') }}</option>
		  @foreach($searchfields as $field)
		  <option value="{{ $field->value }}">{{ __($field->name) }}</option>
		  @endforeach
  	     </select>
  	    </div>
  	   </div>   	    
 	   <label class="label" >{{ __('Relation') }}</label>
 	   <div class="control is-narrow">
  	    <div class="select">
  	     <select id="relations1" name="relations1" disabled>
  	     </select>
  	    </div>  	    
 	   </div>
 	   <label class="label">{{ __('Condition') }}</label>
 	   <div class="control">
         <input class="input" id="condition1" name="condition1" type="text">
 	   </div>
 	  </div>
 	  <div id="additional_cond"></div>
 	  <div class="field is-grouped">
 	   <div class="control">
 	    <button id="add_condition">+</button>
 	   </div>
 	  </div>	
 	  <div class="field is-grouped">
 	   <div class="control">
		<label class="label">{{ __('Name to save (an empty field will not save)') }}</label>
		<input name="save" type="input">
 	   </div>
 	  </div>	
     </section>
     <footer class="modal-card-foot">
         <div class="field is-grouped">
			<input id="submit" class="button is_success" type="submit" value="{{ __('OK') }}">         
          <button class="close-dialog button">{{ __('Cancel') }}</button>
         </div> 
     </footer>
  </div>
</div>
<script>
 $('#choosefilter').on('change', function() {
 	window.location.replace('{{ route($crud_base.'.list', ['page'=>0,'order'=>'default']) }}/'+this.value);
 });
 const relations = new Map();
 @foreach($searchfields as $field)
 relations.set("{{ $field->value }}",[
  @foreach ($field->relations as $relation)
   {text:"{!! $relation !!}",value:"{!! $relation !!}"}@if (!$loop->last),@endif 
  @endforeach
 ]);
  @endforeach

 $('#add_condition').on('click', function() {
	current = $("#cond_count").val();
	if (current == 9) {
	 alert(" {{__("Maximum count of conditions reached") }} ");
	 return;
	} 
	$("#cond_count").val(++current);
	$("#additional_cond").append("<div class=\"field is-grouped\"><label class=\"label\">{{ __('Field') }}</label>"+
 	"<div class=\"control is-narrow\"><div class=\"select\"><select id=\"field\" name=\"field"+current+"\">"+
  	"<option value=\"\" selected>{{ __('Choose a field') }}</option>"+
		  @foreach($searchfields as $field)
		  "<option value=\"{{ $field->value }}\">{{ __($field->name) }}</option>"+
		  @endforeach
  	"</select></div></div><label class=\"label\" >{{ __('Relation') }}</label>"+
 	"<div class=\"control is-narrow\"><div class=\"select\">"+
 	"<select id=\"relations"+current+"\" name=\"relations"+current+"\" disabled></select></div></div>"+
 	"<label class=\"label\">{{ __('Condition') }}</label><div class=\"control\">"+
    "<input class=\"input\" id=\"condition"+current+"\" name=\"condition"+current+"\" type=\"text\">"+
 	"</div></div>");
 });
 $('#field').on('change', function() {
  number = this.name.slice(-1);
  if (this.value) {
  	$('#relations'+number).prop("disabled",false);
  	$('#relations'+number).replaceOptions(relations.get(this.value));
  } else {
  	$('#relations'+number).prop("disabled",true);
  }
 });
</script>  
</form>

