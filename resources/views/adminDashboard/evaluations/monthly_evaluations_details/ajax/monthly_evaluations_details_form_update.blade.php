{{-- 8895654567 Update Form --}}
  @if($permissions["update"])
<div class="modal-header"> 
 <h5> {{__("public.update_form_field") }} 
</div> <!-- modal-header -->
<div class="modal-body">
<!--**********Start draw elements   *************-->   
   
@php
    /******** Start get variables from table  ********/
    $value_monthly_evaluations_id = $records->monthly_evaluations_id;
    $value_assessment_criteria_id = $records->assessment_criteria_id;
    $value_n_a = $records->n_a;
    $value_below_standard = $records->below_standard;
    $value_meets_standard = $records->meets_standard;
    $value_above_standard = $records->above_standard;
    $value_feedback_discussion = $records->feedback_discussion;
    $value_feedback = $records->feedback;
    $value_aspects = $records->aspects;
    $value_suggested = $records->suggested;
    $value_able_perform_procedure = $records->able_perform_procedure;
    $value_unable_perform_procedure = $records->unable_perform_procedure;
    $value_trained_and_competent = $records->trained_and_competent;
    $value_able_perform_procedure_limited = $records->able_perform_procedure_limited;
    $value_competent_perform_procedure_unsupervised = $records->competent_perform_procedure_unsupervised;
    $value_agree_action_plan = $records->agree_action_plan;
    /******** End get variables from table    ********/

 @endphp
    <!--******** Start draw elements     ********-->
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_monthly_evaluations_id_id")}}</label>
      <select class="form-control select2 "  name="monthly_evaluations_id" id="monthly_evaluations_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_monthly_evaluations->count() >= 1)
         @foreach($data_monthly_evaluations as $row)
           <option  @if($row->id == $value_monthly_evaluations_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->id }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_assessment_criteria_id_question")}}</label>
      <select class="form-control select2 "  name="assessment_criteria_id" id="assessment_criteria_id" >
       <option value="">{{__("public.select")}}</option>
       @if($data_assessment_criteria->count() >= 1)
         @foreach($data_assessment_criteria as $row)
           <option  @if($row->id == $value_assessment_criteria_id) selected @endif value="{{ encrypt($row->id) }}">{{ $row->question }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_n_a")}}</label>
     <input type="number" autocomplete="false"  value="{{ $value_n_a }}" class="form-control  "   id="n_a" name="n_a"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_below_standard")}}</label>
     <input type="number" autocomplete="false"  value="{{ $value_below_standard }}" class="form-control  "   id="below_standard" name="below_standard"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_meets_standard")}}</label>
     <input type="number" autocomplete="false"  value="{{ $value_meets_standard }}" class="form-control  "   id="meets_standard" name="meets_standard"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_above_standard")}}</label>
     <input type="number" autocomplete="false"  value="{{ $value_above_standard }}" class="form-control  "   id="above_standard" name="above_standard"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_feedback_discussion")}}</label>
     <textarea type="number" autocomplete="false"    class="form-control  "   id="feedback_discussion" name="feedback_discussion"    >{{ $value_feedback_discussion }}</textarea>
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_feedback")}}</label>
     <textarea type="number" autocomplete="false"    class="form-control  "   id="feedback" name="feedback"    >{{ $value_feedback }}</textarea>
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_aspects")}}</label>
     <textarea type="number" autocomplete="false"    class="form-control  "   id="aspects" name="aspects"    >{{ $value_aspects }}</textarea>
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_suggested")}}</label>
     <textarea type="number" autocomplete="false"    class="form-control  "   id="suggested" name="suggested"    >{{ $value_suggested }}</textarea>
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_able_perform_procedure")}}</label>
     <input type="number" autocomplete="false"  value="{{ $value_able_perform_procedure }}" class="form-control  "   id="able_perform_procedure" name="able_perform_procedure"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_unable_perform_procedure")}}</label>
     <input type="number" autocomplete="false"  value="{{ $value_unable_perform_procedure }}" class="form-control  "   id="unable_perform_procedure" name="unable_perform_procedure"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_trained_and_competent")}}</label>
     <input type="number" autocomplete="false"  value="{{ $value_trained_and_competent }}" class="form-control  "   id="trained_and_competent" name="trained_and_competent"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_able_perform_procedure_limited")}}</label>
     <input type="number" autocomplete="false"  value="{{ $value_able_perform_procedure_limited }}" class="form-control  "   id="able_perform_procedure_limited" name="able_perform_procedure_limited"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_competent_perform_procedure_unsupervised")}}</label>
     <input type="number" autocomplete="false"  value="{{ $value_competent_perform_procedure_unsupervised }}" class="form-control  "   id="competent_perform_procedure_unsupervised" name="competent_perform_procedure_unsupervised"  />
    </div>
  </div>
    </div> 
 
    <div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_agree_action_plan")}}</label>
     <textarea type="number" autocomplete="false"    class="form-control  "   id="agree_action_plan" name="agree_action_plan"    >{{ $value_agree_action_plan }}</textarea>
    </div>
  </div>
    </div> 
 

    <!--******** End draw elemets  ********-->


   
   
<!--*********End draw elemets*********--> 
<div class="errorsResults" id="errorsResults"></div>    
<div class="modal-footer" >        
   <button   type="button"  id = "Save" name = "Save"  class="btn   btn btn-primary"    onclick="ConfirmUpdateData_monthly_evaluations_details()"   > <i class="loader fa  "></i>  {{  __("public.save") }}   </button>
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
