{{-- 8895654567 Update Form --}}
  @if($permissions["update"])
<div class="modal-header"> 
 <h5> {{__("public.update_form_field") }} 
</div> <!-- modal-header -->
<div class="modal-body">
<!--**********Start draw elements   *************-->   
   
@php
    /******** Start get variables from table  ********/
    $value_users_id = $records->users_id;
    $value_hospitals_id = $records->hospitals_id;
    $value_hospitals_has_specialties_id = $records->hospitals_has_specialties_id;
    $value_status_id = $records->status_id;
    /******** End get variables from table    ********/

 @endphp
    <!--******** Start draw elements     ********-->
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("doctorsdistributions.doctorsdistributions_distributions_users_id_name")}}</label>
      <select class="form-control select2 "  name="users_id" id="users_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_users->count() >= 1)
         @foreach($data_users as $row)
           <option  @if($row->id == $value_users_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("doctorsdistributions.doctorsdistributions_distributions_hospitals_id_name")}}</label>
      <select class="form-control select2 " onchange='get_data_distributions_hospitals_id_hospitals_has_specialties() ' name="hospitals_id" id="hospitals_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_hospitals->count() >= 1)
         @foreach($data_hospitals as $row)
           <option  @if($row->id == $value_hospitals_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("doctorsdistributions.doctorsdistributions_distributions_hospitals_has_specialties_id_specialties_id")}}</label>
      <select class="form-control select2 "  name="hospitals_has_specialties_id" id="hospitals_has_specialties_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_hospitals_has_specialties->count() >= 1)
         @foreach($data_hospitals_has_specialties as $row)
           <option  @if($row->id == $value_hospitals_has_specialties_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->specialties_name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("doctorsdistributions.doctorsdistributions_distributions_status_id_name_en")}}</label>
      <select class="form-control select2 "  name="status_id" id="status_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_status->count() >= 1)
        @php  $status_id_name="name_$lang" @endphp
         @foreach($data_status as $row)
           <option @if($row->id == $value_status_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->$status_id_name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
    </div> 
 

    <!--******** End draw elemets  ********-->


   
   
<!--*********End draw elemets*********--> 
<div class="errorsResults" id="errorsResults"></div>    
<div class="modal-footer" >        
   <button   type="button"  id = "Save" name = "Save"  class="btn   btn btn-primary"    onclick="ConfirmUpdateData_distributions()"   > <i class="loader fa  "></i>  {{  __("public.save") }}   </button>
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
