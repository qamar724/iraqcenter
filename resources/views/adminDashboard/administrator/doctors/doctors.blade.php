@extends("layouts.adminDashboard")    
@section("content") 
@php   
//74545233320012   
@endphp 
<div class="col-md-12 main_content"    >
<div class="card card-primary">
<div class="card-header  d-flex justify-content-between align-items-center">
  <h3 class="card-title "> {{ __("administrator.submenu_doctors") }} </h3>
  @if($permissions["importNew"]) 
    <button   type="button"  data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg" id = "ImportForm" name = "ImportForm"  class="btn btn btn-primary btn-sm "    onclick="ImportForm_doctors()"> <i class="loader fa  "></i>  {{ __("public.import_new_field") }}  </button> 
  @endif
</div>
<div class="card-body">
<!-- start filters code--> 
 
 <div class="row d-flex  justify-content-between align-items-center mb-3" style="flex-wrap: nowrap;"> 
  <div class="d-flex  align-items-center">
          <button id="" name="" type="button" class="btn iconsys waves-effect waves-float waves-light m-0" onclick="changeLayoutUser('{{$table}}','table')"  title="{{ __("public.change_layout_to_table") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.change_layout_to_table") }}" > <i class="fa far fa-table" aria-hidden="true"></i> </button>        
          <button id="" name="" type="button" class="btn iconsys waves-effect waves-float waves-light m-3" onclick="changeLayoutUser('{{$table}}','cards')"  title="{{ __("public.change_layout_to_cards") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.change_layout_to_cards") }}" > <i class="fa fas fa-address-card" aria-hidden="true"></i> </button>        
    <div class="d-flex align-items-center">
      <label for="rowsPerPage" class="me-2">Rows</label>
      <select name="rowsPerPage" id="rowsPerPage" class="form-select" onchange="changeRowsPerPage('{{$table}}')">
        <option value="16" @if($pagination == 16) selected @endif >16</option>
        <option value="32" @if($pagination == 32) selected @endif >32</option>
        <option value="48" @if($pagination == 48) selected @endif >48</option>
        <option value="64" @if($pagination == 64) selected @endif >64</option>
        <option value="80" @if($pagination == 80) selected @endif >80</option>
        <option value="100" @if($pagination == 100) selected @endif >100</option>
    </select>
  </div>
  </div>
 </div> 
<!-- start response CRUD code --> 
 @if(Session::has("success_import"))
     <h3 class="alert alert-success  text-center"> {{ Session::get("success_import") }} </h3> 
 @endif
@if(Session::has("success_update"))
     <h3 class="alert alert-success  text-center"> {{ Session::get("success_update") }} </h3> 
 @endif
 @if(Session::has("success"))
     <h3 class="alert alert-success text-center">{{ Session::get("success") }}</h3>
 @endif
<!-- end response CRUD code --> 
 @if($permissions["viewPage"])
  @if ($layout == "cards")  
  <?php $counter = 1 ;?>  
  @if(count($records)  >= 1)  
<div class="row">
   @foreach($records as $record) 
   @php $record_id = encrypt($record->id) @endphp 
<div class="col-xl-3 col-lg-3 col-sm-12" id="column_{{ $record_id }}">
<div class="card border">
    <div class="card-body pb-0">
         <ul class="list-group list-group-flush p-0">
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("administrator.administrator_users_id") }}  </strong>  
              <span class="mb-0">  {{ $counter++ }}</span> 
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("administrator.administrator_users_name") }}  </strong>  
              <span class="mb-0">    {{ $record->name }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("administrator.administrator_users_email") }}  </strong>  
              <span class="mb-0">    {{ $record->email }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
              <span class="mb-0 col-12">
              @php  $profile_photo_path = public_path()."/uploads/$record->profile_photo_path" @endphp 
                @if (File::exists(($profile_photo_path)) && $record->profile_photo_path != NULL)
                @php $assetprofile_photo_path = asset("uploads/$record->profile_photo_path") @endphp
                   <a  href="{{ $assetprofile_photo_path }}" data-lightbox="image">
                    <img src="{{ $assetprofile_photo_path }}" class="imageCards">
                   </a> 
               @else  
                 <img src="{{ asset("images/Image_not_available.png") }}" class="imageCards"> 
               @endif
              </span>
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("administrator.administrator_users_tbl_users_type_id_name") }}  </strong>  
              <span class="mb-0">    {{ $record->tbl_users_type_id_name }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("administrator.administrator_users_phone") }}  </strong>  
              <span class="mb-0">    {{ $record->phone }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("administrator.administrator_users_genders_id_name_en") }}  </strong>  
              <span class="mb-0">    {{ $record->genders_id_name_en }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("administrator.administrator_users_city_id_name_en") }}  </strong>  
              <span class="mb-0">    {{ $record->city_id_name_en }}</span>  
        </li>      
</ul>
</div>
<div class="card-footer pt-0 pb-0 text-center card-line-top">
    <div class="row">
        <div class="col-3 pt-3 pb-3 border-right">
          @if($permissions["update"])
           <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="update_form_doctors( '{{$record_id}}'  )"  class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fas fa-pencil-alt"></i></a> 
         @endif
        </div>
        @if($record["tbl_users_type_id"] != Auth::user()->tbl_users_type_id)
        <div class="col-3 pt-3 pb-3 border-right">
          @if($permissions["delete"])
          <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="delete_form_doctors( '{{$record_id}}'  )"  class="btn btn-danger shadow btn-xs sharp "><i class="fa fa-trash"></i></a> 
         @endif
        </div>
        <div class="col-3 pt-3 pb-3 border-right">
               <a href="javascript:void(0)"   data-bs-toggle="modal"   title="{{ __("public.tooltip_change_password") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_change_password") }}"   data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="UsersChangePassword_form_users('{{$record_id}}','users')"  class="btn btn-secondary shadow btn-xs sharp mr-1"><i class="fa fa-key"></i></a> 
        </div>
        <div class="col-3 pt-3 pb-3 border-right">
                 @if($record->active_status_id==1)
               <a href="javascript:void(0)"   data-bs-toggle="modal"    title="{{ __("public.tooltip_unlocked_account") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_unlocked_account") }}"  data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="LockAccount_form_users('{{$record_id}}','users')"  class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-unlock"></i></a> 
                 @elseif($record->active_status_id==2)
               <a href="javascript:void(0)"   data-bs-toggle="modal" title="{{ __("public.tooltip_locked_account") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_locked_account") }}"     data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="LockAccount_form_users('{{$record_id}}','users')"  class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-lock"></i></a> 
                 @endif
        </div>
         @endif
         
    </div>
</div>
</div>
</div>
   @endforeach 
   {{ $records->links("pagination::bootstrap-4") }}  
</div>
    @else  
     <h3 class="alert alert-warning  text-center">{{__("public.msgIndexNoData")}}</h3>    
    @endif  
  @else 
    <!-- count if exists records -->
    @if(count($records)  >= 1)
       <div class="table-responsive"  id="Table_Responsive" >
        <table class="table table-bordered table-generated  table-hover styled-table table-sm text-center"   id="table"  > 
        <thead>  
        <tr> 
        <th> {{ __("administrator.administrator_users_id") }} </th>  
        <th> {{ __("administrator.administrator_users_name") }} </th>  
        <th> {{ __("administrator.administrator_users_email") }} </th>  
        <th> {{ __("administrator.administrator_users_profile_photo_path") }} </th>  
        <th> {{ __("administrator.administrator_users_tbl_users_type_id_name") }} </th>  
        <th> {{ __("administrator.administrator_users_phone") }} </th>  
        <th> {{ __("administrator.administrator_users_genders_id_name_en") }} </th>  
        <th> {{ __("administrator.administrator_users_city_id_name_en") }} </th>  
      @if($permissions["update"] || $permissions["delete"]) 
        <th> {{ __("public.actions") }} </th> 
      @endif 
        </tr> 
        </thead> 
        <tbody> 
        <?php $counter = 1 ;?> 
          @foreach($records as $record)
     @php $record_id = encrypt($record->id) @endphp 
           <tr id='tr_{{$record_id}}'>
              <td>  {{ $counter++ }}</td> 
              <td>    {{ $record->name }}</td>  
              <td>    {{ $record->email }}</td>  
              <td>
              @php  $profile_photo_path = public_path()."/uploads/$record->profile_photo_path" @endphp 
                @if (File::exists(($profile_photo_path)) && $record->profile_photo_path != NULL)
                @php $assetprofile_photo_path = asset("uploads/$record->profile_photo_path") @endphp
                   <a  href="{{ $assetprofile_photo_path }}" data-lightbox="image">
                    <img src="{{ $assetprofile_photo_path }}" class="imageTable">
                   </a> 
               @else  
                 <img src="{{ asset("images/Image_not_available.png") }}" class="imageTable"> 
               @endif
              </td>
              <td>    {{ $record->tbl_users_type_id_name }}</td>  
              <td>    {{ $record->phone }}</td>  
              <td>    {{ $record->genders_id_name_en }}</td>  
              <td>    {{ $record->city_id_name_en }}</td>  
              @if($permissions["update"] || $permissions["delete"])
              <td>
              @if($permissions["update"])
               <a href="javascript:void(0)"   data-bs-toggle="modal"  title="{{ __("public.tooltip_update") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_update") }}"   data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="update_form_doctors('{{$record_id}}','users')"  class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fas fa-pencil-alt"></i></a> 
              @endif
             @if($record["tbl_users_type_id"] != Auth::user()->tbl_users_type_id)
             @if($permissions["delete"] )
               <a href="javascript:void(0)"   data-bs-toggle="modal"   title="{{ __("public.tooltip_change_password") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_change_password") }}"   data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="UsersChangePassword_form_users('{{$record_id}}','users')"  class="btn btn-secondary shadow btn-xs sharp mr-1"><i class="fa fa-key"></i></a> 
                 @if($record->active_status_id==1)
               <a href="javascript:void(0)"   data-bs-toggle="modal"    title="{{ __("public.tooltip_unlocked_account") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_unlocked_account") }}"  data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="LockAccount_form_users('{{$record_id}}','users')"  class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-unlock"></i></a> 
                 @elseif($record->active_status_id==2)
               <a href="javascript:void(0)"   data-bs-toggle="modal" title="{{ __("public.tooltip_locked_account") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_locked_account") }}"     data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="LockAccount_form_users('{{$record_id}}','users')"  class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-lock"></i></a> 
                 @endif
             @endif
             @endif
              @if($permissions["delete"]  && $record["tbl_users_type_id"] > 3)
               <a href="javascript:void(0)"   data-bs-toggle="modal"  title="{{ __("public.tooltip_delete") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_delete") }}"   data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="delete_form_doctors('{{$record_id}}','users')"  class="btn btn-danger shadow btn-xs sharp "><i class="fa fa-trash"></i></a> 
              @endif
              </td>
          @endif
          </tr> 
          @endforeach
        </tbody> 
        </table> 
       </div> 
       {{ $records->links("pagination::bootstrap-4") }} 
       @else 
          <h3 class="alert alert-warning  text-center">{{__("public.msgIndexNoData")}}</h3>    
       @endif  
       @endif  
  
   @else  
          <h3 class="alert alert-danger text-center">{{__("public.noPermission")}}</h3>    
   @endif    
  </div>     
 </div>     
</div>     
   <input type="hidden" id="hiddenFolderName" class="hiddenFolderName" value="{{$folderName}}"/>      
   <input type="hidden" id="hiddenTable" class="hiddenTable" value="{{$table}}"/>      
 @if($permissions["viewPage"])
   <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
   <script src=   {{asset("model-js/doctors.js")}}></script>
@endif
@endsection  


