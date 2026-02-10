{{-- 8895654567 Update Form --}}
  @if($permissions["update"])
<div class="modal-header"> 
 <h5> {{__("public.update_form_field") }} 
</div> <!-- modal-header -->
<div class="modal-body">
<!--**********Start draw elements   *************-->   
   
@php
    /******** Start get variables from table  ********/
    $value_name = $records->name;
    $value_email = $records->email;
    $value_profile_photo_path = $records->profile_photo_path;
    $value_tbl_users_type_id = $records->tbl_users_type_id;
    $value_phone = $records->phone;
    $value_genders_id = $records->genders_id;
    $value_city_id = $records->city_id;
    $value_hospitals_id = $records->hospitals_id;
    $value_specialties_id = $records->specialties_id;
    /******** End get variables from table    ********/

 @endphp
    <!--******** Start draw elements     ********-->
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_name")}}</label>
     <input type="text" autocomplete="false"  value="{{ $value_name }}" class="form-control  "   id="name" name="name"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_email")}}</label>
     <input type="text" autocomplete="false"  value="{{ $value_email }}" class="form-control  "   id="email" name="email"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_profile_photo_path")}}</label>
      <div class="row">
       <div class="col-2"> <img src="{{ asset("uploads/$value_profile_photo_path") }}" class="form-control  " /> </div>
       <div class="col-10"><input type="file"   autocomplete="false"    class="form-control  "   id="profile_photo_path" name="profile_photo_path"/></div>
      </div>
    </div>
  </div>
    </div> 
 
    <div class="row">
 @if($value_tbl_users_type_id > 2)
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_tbl_users_type_id_name")}}</label>
      <select class="form-control select2 "  name="tbl_users_type_id" id="tbl_users_type_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_tbl_users_type->count() >= 1)
         @foreach($data_tbl_users_type as $row)
           <option  @if($row->id == $value_tbl_users_type_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
 @elseif(Auth::user()->tbl_users_type_id == 1  && $value_tbl_users_type_id == 2)
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_tbl_users_type_id_name")}}</label>
      <select class="form-control select2 "  name="tbl_users_type_id" id="tbl_users_type_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_tbl_users_type->count() >= 1)
         @foreach($data_tbl_users_type as $row)
           <option  @if($row->id == $value_tbl_users_type_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
  @else
  <input type="hidden" name="tbl_users_type_id" id="tbl_users_type_id" value="{{ encrypt($value_tbl_users_type_id) }}" />
  @endif
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_phone")}}</label>
     <input type="text" autocomplete="false"  value="{{ $value_phone }}" class="form-control  "   id="phone" name="phone"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_genders_id_name_en")}}</label>
      <select class="form-control select2 "  name="genders_id" id="genders_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_genders->count() >= 1)
        @php  $genders_id_name="name_$lang" @endphp
         @foreach($data_genders as $row)
           <option @if($row->id == $value_genders_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->$genders_id_name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_city_id_name_en")}}</label>
      <select class="form-control select2 " onchange='get_data_users_city_id_hospitals() ' name="city_id" id="city_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_city->count() >= 1)
        @php  $city_id_name="name_$lang" @endphp
         @foreach($data_city as $row)
           <option @if($row->id == $value_city_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->$city_id_name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
    </div> 
 
    <div class="row">
 @if($value_tbl_users_type_id > 2)
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_hospitals_id_name")}}</label>
      <select class="form-control select2 "  name="hospitals_id" id="hospitals_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_hospitals->count() >= 1)
         @foreach($data_hospitals as $row)
           <option  @if($row->id == $value_hospitals_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
 @elseif(Auth::user()->tbl_users_type_id == 1  && $value_tbl_users_type_id == 2)
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_hospitals_id_name")}}</label>
      <select class="form-control select2 "  name="hospitals_id" id="hospitals_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_hospitals->count() >= 1)
         @foreach($data_hospitals as $row)
           <option  @if($row->id == $value_hospitals_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
  @else
  <input type="hidden" name="hospitals_id" id="hospitals_id" value="{{ encrypt($value_tbl_users_type_id) }}" />
  @endif
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_specialties_id_name_en")}}</label>
      <select class="form-control select2 "  name="specialties_id" id="specialties_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_specialties->count() >= 1)
        @php  $specialties_id_name="name_$lang" @endphp
         @foreach($data_specialties as $row)
           <option @if($row->id == $value_specialties_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->$specialties_id_name }}</option>
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
   <button   type="button"  id = "Save" name = "Save"  class="btn   btn btn-primary"    onclick="ConfirmUpdateData_users()"   > <i class="loader fa  "></i>  {{  __("public.save") }}   </button>
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
