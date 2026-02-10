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
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_monthly_evaluations_id_id")}}</label>
      <select class="form-control select2 "  name="monthly_evaluations_id" id="monthly_evaluations_id" >
       <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
       @if($data_monthly_evaluations->count() >= 1)
         @foreach($data_monthly_evaluations as $row)
           <option value="{{ encrypt($row->id) }}"  >{{ $row->id }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_assessment_criteria_id_question")}}</label>
      <select class="form-control select2 "  name="assessment_criteria_id" id="assessment_criteria_id" >
       <option value="{{ encrypt(-1) }}">{{__("public.select")}}</option>
       @if($data_assessment_criteria->count() >= 1)
         @foreach($data_assessment_criteria as $row)
           <option value="{{ encrypt($row->id) }}"  >{{ $row->question }}</option>
         @endforeach
       @endif
      </select>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_n_a")}}</label>
     <input type="number" autocomplete="false"  value="" class="form-control  "   id="n_a" name="n_a"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_below_standard")}}</label>
     <input type="number" autocomplete="false"  value="" class="form-control  "   id="below_standard" name="below_standard"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_meets_standard")}}</label>
     <input type="number" autocomplete="false"  value="" class="form-control  "   id="meets_standard" name="meets_standard"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_above_standard")}}</label>
     <input type="number" autocomplete="false"  value="" class="form-control  "   id="above_standard" name="above_standard"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_feedback_discussion")}}</label>
     <textarea type="number" autocomplete="false"  value="" class="form-control  "   id="feedback_discussion" name="feedback_discussion"  ></textarea>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_feedback")}}</label>
     <textarea type="number" autocomplete="false"  value="" class="form-control  "   id="feedback" name="feedback"  ></textarea>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_aspects")}}</label>
     <textarea type="number" autocomplete="false"  value="" class="form-control  "   id="aspects" name="aspects"  ></textarea>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_suggested")}}</label>
     <textarea type="number" autocomplete="false"  value="" class="form-control  "   id="suggested" name="suggested"  ></textarea>
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_able_perform_procedure")}}</label>
     <input type="number" autocomplete="false"  value="" class="form-control  "   id="able_perform_procedure" name="able_perform_procedure"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_unable_perform_procedure")}}</label>
     <input type="number" autocomplete="false"  value="" class="form-control  "   id="unable_perform_procedure" name="unable_perform_procedure"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_trained_and_competent")}}</label>
     <input type="number" autocomplete="false"  value="" class="form-control  "   id="trained_and_competent" name="trained_and_competent"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_able_perform_procedure_limited")}}</label>
     <input type="number" autocomplete="false"  value="" class="form-control  "   id="able_perform_procedure_limited" name="able_perform_procedure_limited"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_competent_perform_procedure_unsupervised")}}</label>
     <input type="number" autocomplete="false"  value="" class="form-control  "   id="competent_perform_procedure_unsupervised" name="competent_perform_procedure_unsupervised"  />
    </div>
  </div>
</div><!--close row-->
 
<div class="row">
  <div class="form-group row col-lg-12">
    <div class="col-lg-12">
     <label>{{__("evaluations.evaluations_monthly_evaluations_details_agree_action_plan")}}</label>
     <textarea type="number" autocomplete="false"  value="" class="form-control  "   id="agree_action_plan" name="agree_action_plan"  ></textarea>
    </div>
  </div>
</div><!--close row-->
 

   
   
<!--*********End draw elemets*********-->   
<div class="errorsResults" id="errorsResults"></div>   
<div class="modal-footer" id="modal-footer">     
   <button   type="button"  id = "Save" name = "Save"  class="btn   btn btn-primary"    onclick="monthly_evaluations_details_ConfirmInsertData()"   > <i class="loader fa  "></i>  {{  __("public.save") }}   </button>
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
