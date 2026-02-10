{{-- DOPS IMIP Evaluation Form - EDIT MODE --}}
<div id="dopsFormContent">
  {{-- Purple Header --}}
  <div class="evaluation-header">
    <h4 id="formTitle">DOPS IMIP</h4>
    <h5>Workplace – Based Assessment</h5>
    <h6>IMIP</h6>
  </div>

  <div class="custom-modal-body evaluation-form-body">
    
    {{-- Common Header Info --}}
    <table class="evaluation-table info-table">
      <tr>
        <td class="label-cell"><strong>Trainee's Name:</strong></td>
        <td class="value-cell" id="trainee_name"></td>
      </tr>
      <tr>
        <td class="label-cell"><strong>Trainee's IMA Number:</strong></td>
        <td class="value-cell" id="trainee_ima"></td>
      </tr>
      <tr>
        <td class="label-cell"><strong>Date of Assessment:</strong></td>
        <td class="value-cell" id="assessment_date"></td>
      </tr>
      <tr>
        <td class="label-cell"><strong>Trainee's ROTA:</strong></td>
        <td class="value-cell" id="trainee_rota"></td>
      </tr>
      <tr>
        <td class="label-cell"><strong>Assessor's Name:</strong></td>
        <td class="value-cell" id="assessor_name"></td>
      </tr>
      <tr>
        <td class="label-cell"><strong>Assessor's Email Address:</strong></td>
        <td class="value-cell" id="assessor_email"></td>
      </tr>
      <tr>
        <td class="label-cell"><strong>Assessor's Number:</strong></td>
        <td class="value-cell" id="assessor_number"></td>
      </tr>
      <tr>
        <td class="label-cell"><strong>Hospital name:</strong></td>
        <td class="value-cell" id="hospital_name"></td>
      </tr>
      <tr>
        <td class="label-cell"><strong>Clinical setting):</strong></td>
        <td class="value-cell" id="clinical_settings_container"></td>
      </tr>
      
      {{-- DOPS Specific: Procedure Name Dropdown --}}
      <tr id="procedure_name_row">
        <td class="label-cell"><strong style="color: #dc3545;">Procedure Name:</strong></td>
        <td class="value-cell">
          <select class="form-control select2" id="procedure_list_id" name="procedure_list_id" onchange="onProcedureSelectChange()" style="width: 100%;">
            <option value="">-- Select Procedure --</option>
            {{-- Options will be populated via JavaScript --}}
          </select>
          <input type="text" class="form-control mt-2" id="procedure_name_other" name="procedure_name_other" placeholder="Enter procedure name..." style="display: none;" />
        </td>
      </tr>
    </table>

    {{-- Instructions Text --}}
    <div class="evaluation-instructions">
      <p id="instruction_text"><strong>Please score the trainee on the scale shown.</strong> Please note that your scoring should reflect the performance of the trainee against which you would reasonably expect at their stage of training and level of experience. Please mark 'Not applicable' if the domain is not applicable: <strong>Assessment Criteria:</strong> (this is the Likert scale grading – put X in relevant box)</p>
    </div>

    {{-- Assessment Criteria Table --}}
    <table class="evaluation-table criteria-table">
      <thead>
        <tr>
          <th class="criteria-header">Assessment Criteria</th>
          <th class="rating-header">N/A</th>
          <th class="rating-header">Below standard</th>
          <th class="rating-header">meets standard</th>
          <th class="rating-header">Above standard</th>
        </tr>
      </thead>
      <tbody id="assessment_criteria_body"></tbody>
    </table>

    {{-- DOPS Specific: Independent Practice Rating --}}
    <div id="dops_independent_practice">
      <div class="evaluation-instructions">
        <p><strong>Based on this observation please now rate the level of independent practice the trainee has shown for this procedure:</strong></p>
      </div>
      <div class="independent-practice-options">
        <label class="checkbox-option">
          <input type="checkbox" name="unable_perform_procedure" id="unable_perform_procedure" value="1"> 
          Unable to perform procedure
        </label>
        <label class="checkbox-option">
          <input type="checkbox" name="able_perform_procedure" id="able_perform_procedure" value="1"> 
          Able to perform the procedure under direct supervision/assistance
        </label>
        <label class="checkbox-option">
          <input type="checkbox" name="trained_and_competent" id="trained_and_competent" value="1"> 
          Trained and competent in skills lab (this does not equate to clinical competence)
        </label>
        <label class="checkbox-option">
          <input type="checkbox" name="able_perform_procedure_limited" id="able_perform_procedure_limited" value="1"> 
          Able to perform the procedure with limited supervision/assistance
        </label>
        <label class="checkbox-option">
          <input type="checkbox" name="competent_perform_procedure_unsupervised" id="competent_perform_procedure_unsupervised" value="1"> 
          Competent to perform the procedure unsupervised and deal with complications
        </label>
      </div>
    </div>

    {{-- Signatures Section --}}
    <div class="signatures-section">
      <table class="evaluation-table signature-table">
        <tr>
          <th>Assessor's signature</th>
          <th>Trainee's signature</th>
        </tr>
        <tr>
          <td><div class="signature-box"></div></td>
          <td><div class="signature-box"></div></td>
        </tr>
      </table>
    </div>

    {{-- DOPS Specific: Feedback After Signatures --}}
    <div id="dops_feedback_after_signature">
      <div class="text-section">
        <label><strong>Which aspects of the encounter were done well?</strong></label>
        <textarea class="form-control" id="dops_aspects_done_well" name="dops_aspects_done_well" rows="4"></textarea>
      </div>

      <div class="text-section">
        <label><strong>Suggested areas for improvement:</strong></label>
        <p class="text-muted small">If a trainee receives a rating which is unsatisfactory, the assessor must complete this section.</p>
        <textarea class="form-control" id="dops_suggested_improvement" name="dops_suggested_improvement" rows="4"></textarea>
      </div>

      <div class="text-section">
        <label><strong>Agreed action plan:</strong></label>
        <textarea class="form-control" id="dops_agreed_action_plan" name="dops_agreed_action_plan" rows="4"></textarea>
      </div>
    </div>

  </div>

  {{-- Success Messages --}}
  <div id="evaluation_success_insert" style="display: none;">
    <h3 class="alert alert-success text-center">{{ __("public.flashMsg_SuccessInsert") }}</h3>
  </div>
  <div id="evaluation_success_update" style="display: none;">
    <h3 class="alert alert-success text-center">{{ __("public.flashMsg_SuccessUpdate") }}</h3>
  </div>

  {{-- Footer for Edit Mode - No Back Button --}}
  <div class="custom-modal-footer" id="footer_edit_mode">
    <button type="button" class="btn btn-primary" id="btn_save_evaluation" onclick="saveEvaluationForm()">
      <i class="fas fa-save"></i> {{ __("public.save") }}
    </button>
    <button type="button" class="btn btn-danger" id="btn_close_evaluation" onclick="closeCustomModal()">
      <i class="fas fa-times"></i> {{ __("public.close") }}
    </button>
  </div>
  
  {{-- Footer for View Mode - Hidden in Edit Mode --}}
  <div class="custom-modal-footer" id="footer_view_mode" style="display: none;">
    <button type="button" class="btn btn-primary" onclick="printEvaluationPDF()">
      <i class="fas fa-print"></i> {{ __("public.print") }}
    </button>
    <button type="button" class="btn btn-danger" onclick="closeCustomModal()">
      <i class="fas fa-times"></i> {{ __("public.close") }}
    </button>
  </div>
</div>
