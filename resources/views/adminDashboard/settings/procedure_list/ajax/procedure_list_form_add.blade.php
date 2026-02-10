{{-- 700021133 - add form --}}
 @if($permissions["insertNew"]) 
<div class="modal-header">
  <h5>{{__("public.add_new_field")}}</h5>
</div> <!--modal-header-->
<div class="modal-body">
<!--**********Start draw elements   *************-->   
   
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("settings.settings_procedure_list_category_procedure_id")}}</label>
      <select class="form-control select2 "  name="category_procedure_id" id="category_procedure_id" >
       <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
       @if($data_category_procedure->count() >= 1)
         @foreach($data_category_procedure as $row)
           <option value="{{ encrypt($row->id) }}">{{ $row->name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
</div><!--close row-->

<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("settings.settings_procedure_list_name")}}</label>
     <input type="text" autocomplete="false"  value="" class="form-control  "   id="name" name="name"  />
    </div>
  </div>
</div><!--close row-->
 

   
   
<!--*********End draw elemets*********-->   
<div class="errorsResults" id="errorsResults"></div>   
<div class="modal-footer" id="modal-footer">     
   <button   type="button"  id = "Save" name = "Save"  class="btn   btn btn-primary"    onclick="procedure_list_ConfirmInsertData()"   > <i class="loader fa  "></i>  {{  __("public.save") }}   </button>
   <button   type="button"  id = "Close" name = "Close"  data-toggle="modal" data-target=".bd-dialog-modal-lg"  data-bs-dismiss="modal"  class="btn   btn btn-danger"    onclick="hidepopup()"   > <i class="   "></i>  {{  __("public.close") }}   </button>
</div><!--modal-footer-->  
</div><!--modal-body-->  
<input type="hidden" id="table" class="table" name="" value="{{$table}}"/> 
<script>
$('.date').datepicker({
    format: 'yyyy-mm-dd',
  todayBtn: 'linked',
  clearBtn: true,
 autoclose: true
  });
$('.select2').select2({
placeholder: 'Select an option'
 });
 
 
</script>
    
@else 
 <div class="modal-header">
 <h5>{{__("public.add_new_field")}}</h5>
 </div> <!--modal-header-->
 <div class="modal-body">
<div class="alert alert-danger">{{__("public.noPermission")}}</div> 
 </div><!--modal-body-->
 <div class="modal-footer" id="modal-footer"> 
    <button   type="button"  id = "Close" name = "Close"  data-toggle="modal" data-target=".bd-dialog-modal-lg"  data-bs-dismiss="modal"  class="btn   btn btn-danger"    onclick="hidepopup()"   > <i class="   "></i>  {{  __("public.close") }}   </button>        
 </div><!--modal-footer-->
 
@endif 
