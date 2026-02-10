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
     <label>{{__("settings.settings_specialties_name_en")}}</label>
     <input type="text" autocomplete="false"  value="" class="form-control  "   id="name_en" name="name_en"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("settings.settings_specialties_name_ar")}}</label>
     <input type="text" autocomplete="false"  value="" class="form-control  "   id="name_ar" name="name_ar"  />
    </div>
  </div>
</div><!--close row-->
 

   
   
<!--*********End draw elemets*********-->   
<div class="errorsResults" id="errorsResults"></div>   
<div class="modal-footer" id="modal-footer">     
   <button   type="button"  id = "Save" name = "Save"  class="btn   btn btn-primary"    onclick="specialties_ConfirmInsertData()"   > <i class="loader fa  "></i>  {{  __("public.save") }}   </button>
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
