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
     <label>{{__("administrator.administrator_users_name")}}</label>
     <input type="text" autocomplete="false"  value="" class="form-control  "   id="name" name="name"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_email")}}</label>
     <input type="text" autocomplete="false"  value="" class="form-control  "   id="email" name="email"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_profile_photo_path")}}</label>
     <input type="file"   autocomplete="false"  value=" " class="form-control  "   id="profile_photo_path" name="profile_photo_path"/>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_tbl_users_type_id_name")}}</label>
      <select class="form-control select2 "  name="tbl_users_type_id" id="tbl_users_type_id" >
       <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
       @if($data_tbl_users_type->count() >= 1)
         @foreach($data_tbl_users_type as $row)
           <option value="{{ encrypt($row->id) }}"  >{{ $row->name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_phone")}}</label>
     <input type="text" autocomplete="false"  value="" class="form-control  "   id="phone" name="phone"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_genders_id_name_en")}}</label>
      <select class="form-control select2 "  name="genders_id" id="genders_id" >
       <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
       @if($data_genders->count() >= 1)
        @php  $genders_id_name="name_$lang" @endphp
         @foreach($data_genders as $row)
           <option value="{{ encrypt($row->id) }}">{{ $row->$genders_id_name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_city_id_name_en")}}</label>
      <select class="form-control select2 " onchange='get_data_users_city_id_hospitals() ' name="city_id" id="city_id" >
       <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
       @if($data_city->count() >= 1)
        @php  $city_id_name="name_$lang" @endphp
         @foreach($data_city as $row)
           <option value="{{ encrypt($row->id) }}">{{ $row->$city_id_name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_hospitals_id_name")}}</label>
      <select class="form-control select2 "  name="hospitals_id" id="hospitals_id" >
       <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
       @if($data_hospitals->count() >= 1)
         @foreach($data_hospitals as $row)
           <option value="{{ encrypt($row->id) }}"  >{{ $row->name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("administrator.administrator_users_specialties_id_name_en")}}</label>
      <select class="form-control select2 "  name="specialties_id" id="specialties_id" >
       <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
       @if($data_specialties->count() >= 1)
        @php  $specialties_id_name="name_$lang" @endphp
         @foreach($data_specialties as $row)
           <option value="{{ encrypt($row->id) }}">{{ $row->$specialties_id_name }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
</div><!--close row-->
 

   
   
<!--*********End draw elemets*********-->   
<h3 class="alert alert-info"> {{__("public.addNewUserPasswordMsg")}}</h3>   
<div class="errorsResults" id="errorsResults"></div>   
<div class="modal-footer" id="modal-footer">     
   <button   type="button"  id = "Save" name = "Save"  class="btn   btn btn-primary"    onclick="users_ConfirmInsertData()"   > <i class="loader fa  "></i>  {{  __("public.save") }}   </button>
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
