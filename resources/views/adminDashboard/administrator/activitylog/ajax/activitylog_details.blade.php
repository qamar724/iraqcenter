<?php 
use App\Http\Controllers\SystemController\Mform;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\SystemController\Input;
use App\Http\Controllers\SystemController\System;
//3234998554
$lang =app()->getLocale();
$id = Input::get("id");
$table = Input::get("table");
$sql = " SELECT 
activity_log.id AS id,
activity_log.log_name AS log_name,
activity_log.description AS description,
activity_log.subject_type AS subject_type,
activity_log.causer_type AS causer_type,
activity_log.properties AS properties
 FROM activity_log
 WHERE activity_log.id=$id ";
$records = DB::select($sql);
  ?>
@if ( count($records) >= 1)  
<div class="row">
<table class='table table-striped details_table  '>
@foreach ($records  as $record)  
<tr>
<td> {{__('public.administrator_logsystem_id')}}</td>
 <td>{{ $record->id }}</td> 
 </tr> 
<tr>
<td> {{__('public.administrator_logsystem_log_name')}}</td>
 <td>{{ $record->log_name }}</td> 
 </tr> 
<tr>
<td> {{__('public.administrator_logsystem_description')}}</td>
 <td>{!! $record->description !!}  </td> 
 </tr> 
<tr>
<td> {{__('public.administrator_logsystem_subject_type')}}</td>
 <td>{{ $record->subject_type }}</td> 
 </tr> 
<tr>
<td> {{__('public.administrator_logsystem_causer_type')}}</td>
 <td>{{ $record->causer_type }}</td> 
 </tr> 
<tr>
<td> {{__('public.administrator_logsystem_properties')}}</td>
 <td><pre> <?php print_r(json_decode($record->properties)) ?></pre>  </td> 
 </tr> 
@endforeach
</table>
</div>
@endif
<div class = "form-group col-lg-6 col-md-6 col-sm-6 col-xs-6 float-m-by-lang NOpadding NOmargin  rev-padding-left-5"> 
<input data-toggle="modal" data-target=".bd-dialog-modal-lg" data-bs-dismiss="modal"  id = "Close" name = "Close" type="button" value =  "{{ __("public.close") }}" class="btn   btn-danger rev-popUp-btn-left"   > 
</div> 
