@extends("layouts.adminDashboard")    
@section("content") 
@php   
//74545233320012   
@endphp 
<div class="col-md-12 main_content"    >
<div class="card card-primary">
<div class="card-header  d-flex justify-content-between align-items-center">
  <h3 class="card-title "> {{ __("evaluations.submenu_monthly_evaluations_details") }} </h3>
  @if($permissions["insertNew"]) 
    <button   type="button" data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg" id = "AddForm" name = "AddForm"  class="btn btn btn-primary btn-sm "    onclick="AddForm_monthly_evaluations_details()"> <i class="loader fa  "></i>  {{ __("public.add_new_field") }}  </button> 
  @endif
</div>
<div class="card-body">
<!-- start filters code--> 
 <form action="monthly_evaluations_details" method="POST"> 
 @csrf 
<div class = 'form-group '><input type = 'button' value = 'Show Filter' class = 'btn   btn btn-danger btn-sm'   id = 'showFilter' onclick='toggleFilter()'   /></div><div class='col-lg12 bg-orange text-white' id='filterDialog' style='padding: 10px 10px 20px 10px; border-radius: 15px; display: <?php if(request()->all()){ echo 'block'; }else{ echo 'none'; }?>;'>
<div class="row"> 
<div class="col-lg-3"> 
 <label> {{__("evaluations.evaluations_monthly_evaluations_details_monthly_evaluations_id_id")}} </label>
 <select class="form-control select2 "  name="key_monthly_evaluations_id" id="key_monthly_evaluations_id" >
  <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
   @if($data_monthly_evaluations->count() >= 1)
     @foreach($data_monthly_evaluations as $row)
     <option value="{{ encrypt($row->id) }}" {{ request()->has("key_monthly_evaluations_id") && decrypt(request()->input("key_monthly_evaluations_id")) == $row->id ? "selected" : "" }}>   {{ $row->id }}  </option>
   @endforeach
   @endif
   </select>
</div>
<div class="col-lg-3"> 
 <label> {{__("evaluations.evaluations_monthly_evaluations_details_assessment_criteria_id_question")}} </label>
 <select class="form-control select2 "  name="key_assessment_criteria_id" id="key_assessment_criteria_id" >
  <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
   @if($data_assessment_criteria->count() >= 1)
     @foreach($data_assessment_criteria as $row)
     <option value="{{ encrypt($row->id) }}" {{ request()->has("key_assessment_criteria_id") && decrypt(request()->input("key_assessment_criteria_id")) == $row->id ? "selected" : "" }}>   {{ $row->question }}  </option>
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
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_id") }}  </strong>  
              <span class="mb-0">  {{ $counter++ }}</span> 
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_monthly_evaluations_id_id") }}  </strong>  
              <span class="mb-0">    {{ $record->monthly_evaluations_id_id }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_assessment_criteria_id_question") }}  </strong>  
              <span class="mb-0">    {{ $record->assessment_criteria_id_question }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_n_a") }}  </strong>  
              <span class="mb-0">    {{ $record->n_a }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_below_standard") }}  </strong>  
              <span class="mb-0">    {{ $record->below_standard }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_meets_standard") }}  </strong>  
              <span class="mb-0">    {{ $record->meets_standard }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_above_standard") }}  </strong>  
              <span class="mb-0">    {{ $record->above_standard }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_feedback_discussion") }}  </strong>  
              <span class="mb-0">    {{ $record->feedback_discussion }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_feedback") }}  </strong>  
              <span class="mb-0">    {{ $record->feedback }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_aspects") }}  </strong>  
              <span class="mb-0">    {{ $record->aspects }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_suggested") }}  </strong>  
              <span class="mb-0">    {{ $record->suggested }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_able_perform_procedure") }}  </strong>  
              <span class="mb-0">    {{ $record->able_perform_procedure }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_unable_perform_procedure") }}  </strong>  
              <span class="mb-0">    {{ $record->unable_perform_procedure }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_trained_and_competent") }}  </strong>  
              <span class="mb-0">    {{ $record->trained_and_competent }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_able_perform_procedure_limited") }}  </strong>  
              <span class="mb-0">    {{ $record->able_perform_procedure_limited }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_competent_perform_procedure_unsupervised") }}  </strong>  
              <span class="mb-0">    {{ $record->competent_perform_procedure_unsupervised }}</span>  
        </li>     
        <li class="list-group-item d-flex px-0 justify-content-between">     
         <strong> {{ __("evaluations.evaluations_monthly_evaluations_details_agree_action_plan") }}  </strong>  
              <span class="mb-0">    {{ $record->agree_action_plan }}</span>  
        </li>     
</ul>
</div>
<div class="card-footer pt-0 pb-0 text-center card-line-top">
    <div class="row">
        <div class="col-6 pt-3 pb-3 border-right">
          @if($permissions["update"])
           <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="update_form_monthly_evaluations_details( '{{$record_id}}'  )"  class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fas fa-pencil-alt"></i></a> 
         @endif
        </div>
        <div class="col-6 pt-3 pb-3 border-right">
          @if($permissions["delete"])
          <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="delete_form_monthly_evaluations_details( '{{$record_id}}'  )"  class="btn btn-danger shadow btn-xs sharp "><i class="fa fa-trash"></i></a> 
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
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_id") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_monthly_evaluations_id_id") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_assessment_criteria_id_question") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_n_a") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_below_standard") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_meets_standard") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_above_standard") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_feedback_discussion") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_feedback") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_aspects") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_suggested") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_able_perform_procedure") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_unable_perform_procedure") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_trained_and_competent") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_able_perform_procedure_limited") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_competent_perform_procedure_unsupervised") }} </th>  
        <th> {{ __("evaluations.evaluations_monthly_evaluations_details_agree_action_plan") }} </th>  
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
              <td>    {{ $record->monthly_evaluations_id_id }}</td>  
              <td>    {{ $record->assessment_criteria_id_question }}</td>  
              <td>    {{ $record->n_a }}</td>  
              <td>    {{ $record->below_standard }}</td>  
              <td>    {{ $record->meets_standard }}</td>  
              <td>    {{ $record->above_standard }}</td>  
              <td>    {{ $record->feedback_discussion }}</td>  
              <td>    {{ $record->feedback }}</td>  
              <td>    {{ $record->aspects }}</td>  
              <td>    {{ $record->suggested }}</td>  
              <td>    {{ $record->able_perform_procedure }}</td>  
              <td>    {{ $record->unable_perform_procedure }}</td>  
              <td>    {{ $record->trained_and_competent }}</td>  
              <td>    {{ $record->able_perform_procedure_limited }}</td>  
              <td>    {{ $record->competent_perform_procedure_unsupervised }}</td>  
              <td>    {{ $record->agree_action_plan }}</td>  
              @if($permissions["update"] || $permissions["delete"])
              <td>
              @if($permissions["update"])
               <a href="javascript:void(0)" title="{{ __("public.tooltip_update") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_update") }}"    data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="update_form_monthly_evaluations_details('{{$record_id}}','monthly_evaluations_details')"  class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fas fa-pencil-alt"></i></a> 
              @endif
              @if($permissions["delete"])
               <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg"  data-toggle="modal" title="{{ __("public.tooltip_delete") }}" tabindex="0" data-plugin="tippy" data-tippy-placement="top" data-tippy="" data-original-title="{{ __("public.tooltip_delete") }}" data-target=".bd-dialog-modal-lg" onclick="delete_form_monthly_evaluations_details('{{$record_id}}','monthly_evaluations_details')"  class="btn btn-danger shadow btn-xs sharp "><i class="fa fa-trash"></i></a> 
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
   <script src=   {{asset("model-js/monthly_evaluations_details.js")}}></script>
@endif
@endsection  
