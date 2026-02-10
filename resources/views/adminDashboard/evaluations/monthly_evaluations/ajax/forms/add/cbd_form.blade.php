{{-- CBD IMIP Evaluation Form - ADD MODE --}}
<div id="cbdFormContent">
  {{-- Purple Header --}}
  <div class="evaluation-header">
    <h4 id="formTitle">CBD IMIP</h4>
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
      
      {{-- CBD Specific: Title --}}
      <tr id="cbd_title_row">
        <td class="label-cell"><strong style="color: #dc3545;">CBD Title:</strong></td>
        <td class="value-cell">
          <input type="text" class="form-control" id="cbd_title" name="cbd_title"/>
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

    {{-- CBD Specific: Feedback Section --}}
    <div id="cbd_feedback_section">
      <div class="feedback-section">
        <h6><strong>Feedback</strong></h6>
        <table class="evaluation-table feedback-table">
          <tr>
            <td class="feedback-label">Time taken for discussion:</td>
            <td class="feedback-input"><input type="text" class="form-control" id="time_discussion" name="time_discussion" /></td>
          </tr>
          <tr>
            <td class="feedback-label">Time taken for feedback:</td>
            <td class="feedback-input"><input type="text" class="form-control" id="time_feedback" name="time_feedback" /></td>
          </tr>
        </table>
      </div>
      
      <div class="text-section">
        <label><strong>Which aspects of the encounter were done well?</strong></label>
        <textarea class="form-control" id="aspects_done_well" name="aspects_done_well" rows="4"></textarea>
      </div>

      <div class="text-section">
        <label><strong>Suggested areas for improvement:</strong></label>
        <p class="text-muted small">If a trainee receives a rating which is unsatisfactory, the assessor must complete this section.</p>
        <textarea class="form-control" id="suggested_improvement" name="suggested_improvement" rows="4"></textarea>
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

  </div>

  {{-- Success Messages --}}
  <div id="evaluation_success_insert" style="display: none;">
    <h3 class="alert alert-success text-center">{{ __("public.flashMsg_SuccessInsert") }}</h3>
  </div>
  <div id="evaluation_success_update" style="display: none;">
    <h3 class="alert alert-success text-center">{{ __("public.flashMsg_SuccessUpdate") }}</h3>
  </div>

  {{-- Footer for Add Mode - With Back Button --}}
  <div class="custom-modal-footer" id="footer_edit_mode">
    <button type="button" class="btn btn-primary" id="btn_save_evaluation" onclick="saveEvaluationForm()">
      <i class="fas fa-save"></i> {{ __("public.save") }}
    </button>
    <button type="button" class="btn btn-secondary" id="btn_back_evaluation" onclick="backToFormSelection()">
      <i class="fas fa-arrow-left"></i> {{ __("public.back") }}
    </button>
    <button type="button" class="btn btn-danger" id="btn_close_evaluation" onclick="closeCustomModal()">
      <i class="fas fa-times"></i> {{ __("public.close") }}
    </button>
  </div>
  
  {{-- Footer for View Mode - Hidden in Add Mode --}}
  <div class="custom-modal-footer" id="footer_view_mode" style="display: none;">
    <button type="button" class="btn btn-primary" onclick="printEvaluationPDF()">
      <i class="fas fa-print"></i> {{ __("public.print") }}
    </button>
    <button type="button" class="btn btn-danger" onclick="closeCustomModal()">
      <i class="fas fa-times"></i> {{ __("public.close") }}
    </button>
  </div>
</div>
