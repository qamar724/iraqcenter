@extends("layouts.adminDashboard")    
@section("content") 
@php   
//74545233320012   
@endphp 
<div class="col-md-12 main_content"    >
<div class="card card-primary">
<div class="card-header  d-flex justify-content-between align-items-center">
  <h3 class="card-title "> {{ __("settings.submenu_hospitals") }} </h3>
  @if($permissions["insertNew"]) 
    <button   type="button" data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg" id = "AddForm" name = "AddForm"  class="btn btn btn-primary btn-sm "    onclick="AddForm_hospitals()"> <i class="loader fa  "></i>  {{ __("public.add_new_field") }}  </button> 
  @endif
</div>
<div class="card-body">
<!-- start filters code--> 
 <form action="hospitals" method="POST"> 
 @csrf 
<div class = 'form-group '><input type = 'button' value = 'Show Filter' class = 'btn   btn btn-danger btn-sm'   id = 'showFilter' onclick='toggleFilter()'   /></div><div class='col-lg12 bg-orange text-white' id='filterDialog' style='padding: 10px 10px 20px 10px; border-radius: 15px; display: <?php if(request()->all()){ echo 'block'; }else{ echo 'none'; }?>;'>
<div class="row"> 
<div class="col-lg-3"> 
 <label> {{__("settings.settings_hospitals_city_id_name_en")}} </label>
 <select class="form-control select2 "  name="key_city_id" id="key_city_id" >
  <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
   @if($data_city->count() >= 1)
 @php $filter_name="name_$lang" @endphp
     @foreach($data_city as $row)
     <option value="{{ encrypt($row->id) }}" {{ request()->has("key_city_id") && decrypt(request()->input("key_city_id")) == $row->id ? "selected" : "" }}>   {{ $row->$filter_name}}  </option>
   @endforeach
   @endif
   </select>
</div>
<div class="form-group  col-lg-3">
<div class="col-lg-12">
    <label>{{__("public.from_date")}}</label>
    <div class="input-group date">
        <div class="input-group-addon">    </div>
        <input type="text" autocomplete="false" readonly="" class="form-control pull-right date " id="id_from_date" value="" name="id_from_date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>  
    </div>
</div>
</div>
<div class="form-group  col-lg-3">
<div class="col-lg-12">
    <label>{{__("public.to_date")}}</label>
    <div class="input-group date">
        <div class="input-group-addon">    </div>
        <input type="text" autocomplete="false" readonly="" class="form-control pull-right date " id="id_to_date" value="" name="id_to_date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>  
    </div>
</div>
</div>
</div>
<div class="form-group  col-lg-12 text-center"><input type="submit" value="{{__("public.search")}}" class="btn btn btn-success col-lg-3" id="" name=""></div>
</div>
 </form> 
<!-- end  filters code --> 
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
 @if(Session::has("success_insert"))
     <h3 class="alert alert-success  text-center"> {{ Session::get("success_insert") }} </h3> 
 @endif
 @if(Session::has("success_update"))
     <h3 class="alert alert-success  text-center"> {{ Session::get("success_update") }} </h3> 
 @endif
<!-- end response CRUD code --> 
 @if($permissions["viewPage"])
  @if ($layout == "cards")  
  <?php $counter=1 ;?>  
  @if(count($records)  >= 1)  
<div class="row">
   @foreach($records as $record) 
   @php $record_id = encrypt($record->id) @endphp 
<div class="col-xl-3 col-lg-3 col-sm-12" id="column_{{ $record_id }}">
<div class="card border">
    <div class="card-body pb-0">
         <ul class="list-group list-group-flush p-0">
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("settings.settings_hospitals_id") }}  </strong>  
              <span class="mb-0">  {{ $counter++ }}</span> 
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("settings.settings_hospitals_name") }}  </strong>  
              <span class="mb-0">    {{ $record->name }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("settings.settings_hospitals_phone") }}  </strong>  
              <span class="mb-0">    {{ $record->phone }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("settings.settings_hospitals_email") }}  </strong>  
              <span class="mb-0">    {{ $record->email }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("settings.settings_hospitals_city_id_name_en") }}  </strong>  
              <span class="mb-0">    {{ $record->city_id_name_en }}</span>  
        </li>     
</ul>
</div>
<div class="card-footer pt-0 pb-0 text-center card-line-top">
    <div class="row">
        <div class="col-6 pt-3 pb-3 border-right">
          @if($permissions["update"])
           <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="update_form_hospitals( '{{$record_id}}'  )"  class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fas fa-pencil-alt"></i></a> 
         @endif
        </div>
        <div class="col-6 pt-3 pb-3 border-right">
          @if($permissions["delete"])
          <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="delete_form_hospitals( '{{$record_id}}'  )"  class="btn btn-danger shadow btn-xs sharp "><i class="fa fa-trash"></i></a> 
         @endif
        </div>
         
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
        <th> {{ __("settings.settings_hospitals_id") }} </th>  
        <th> {{ __("settings.settings_hospitals_name") }} </th>  
        <th> {{ __("settings.settings_hospitals_phone") }} </th>  
        <th> {{ __("settings.settings_hospitals_email") }} </th>  
        <th> {{ __("settings.settings_hospitals_city_id_name_en") }} </th>  
      @if($permissions["update"] || $permissions["delete"]) 
        <th> {{ __("public.actions") }} </th> 
      @endif 
        </tr> 
        </thead> 
        <tbody> 
        <?php $counter=1 ;?> 
          @foreach($records as $record)
     @php $record_id = encrypt($record->id) @endphp 
           <tr id='tr_{{$record_id}}'>
              <td>  {{ $counter++ }}</td> 
              <td>    {{ $record->name }}</td>  
              <td>    {{ $record->phone }}</td>  
              <td>    {{ $record->email }}</td>  
              <td>    {{ $record->city_id_name_en }}</td>  
              @if($permissions["update"] || $permissions["delete"])
              <td>
              @if($permissions["update"])
               <a href="javascript:void(0)" title="{{ __("public.tooltip_update") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_update") }}"    data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="update_form_hospitals('{{$record_id}}','hospitals')"  class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fas fa-pencil-alt"></i></a> 
              @endif
              @if($permissions["delete"])
               <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" title="{{ __("public.tooltip_delete") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_delete") }}" data-target=".bd-dialog-modal-lg" onclick="delete_form_hospitals('{{$record_id}}','hospitals')"  class="btn btn-danger shadow btn-xs sharp "><i class="fa fa-trash"></i></a> 
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
   <script src=   {{asset("model-js/hospitals.js")}}></script>
@endif
@endsection  
