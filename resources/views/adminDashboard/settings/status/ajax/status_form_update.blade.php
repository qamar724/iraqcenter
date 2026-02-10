{{-- 8895654567 Update Form --}}
  @if($permissions["update"])
<div class="modal-header"> 
 <h5> {{__("public.update_form_field") }} 
</div> <!-- modal-header -->
<div class="modal-body">
<!--**********Start draw elements   *************-->   
   
@php
    /******** Start get variables from table  ********/
    $value_name_en = $records->name_en;
    $value_name_ar = $records->name_ar;
    /******** End get variables from table    ********/

 @endphp
    <!--******** Start draw elements     ********-->
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("settings.settings_status_name_en")}}</label>
     <input type="text" autocomplete="false"  value="{{ $value_name_en }}" class="form-control  "   id="name_en" name="name_en"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("settings.settings_status_name_ar")}}</label>
     <input type="text" autocomplete="false"  value="{{ $value_name_ar }}" class="form-control  "   id="name_ar" name="name_ar"  />
    </div>
  </div>
    </div> 
 

    <!--******** End draw elemets  ********-->


   
   
<!--*********End draw elemets*********--> 
<div class="errorsResults" id="errorsResults"></div>    
<div class="modal-footer" >        
   <button   type="button"  id = "Save" name = "Save"  class="btn   btn btn-primary"    onclick="ConfirmUpdateData_status()"   > <i class="loader fa  "></i>  {{  __("public.save") }}   </button>
   <button   type="button"  id = "Close" name = "Close"  data-bs-dismiss="modal"   data-toggle="modal" data-target=".bd-dialog-modal-lg" class="btn   btn btn-danger"    onclick="hidepopup()"   > <i class="   "></i>  {{  __("public.close") }}   </button>
</div> 
<input type="hidden" id="id"   value="{{ request()->id }}" >  
<input type="hidden" id="table"   value="{{ $table }}" >     
</div>    
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
