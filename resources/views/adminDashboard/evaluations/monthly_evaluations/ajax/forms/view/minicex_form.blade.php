{{-- Mini-CEX IMIP Evaluation Form - VIEW MODE --}}
<div id="minicexFormContent">
  {{-- Purple Header --}}
  <div class="evaluation-header">
    <h4 id="formTitle">Mini-CEX IMIP</h4>
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
      
      {{-- Mini-CEX Specific: Patient Data --}}
      <tr id="patient_data_row">
        <td class="label-cell"><strong>Patient Data:</strong></td>
        <td class="value-cell">
          <span class="patient-data-inline">
            Age: <input type="number" class="form-control-inline" id="patient_age" name="patient_age" style="width: 80px; display: inline-block;" min="0" max="150" readonly disabled/>
            &nbsp;&nbsp;
            Sex: <input type="text" class="form-control-inline" id="patient_sex" name="patient_sex" style="width: 80px; display: inline-block;" readonly disabled/>
          </span>
        </td>
      </tr>
      
      {{-- Mini-CEX Specific: Clinical Problem --}}
      <tr id="clinical_problem_row">
        <td class="label-cell"><strong style="color: #dc3545;">Clinical Problem:</strong></td>
        <td class="value-cell">
          <input type="text" class="form-control" id="clinical_problem" name="clinical_problem" readonly disabled/>
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

    {{-- Mini-CEX Specific: Time and Complexity --}}
    <div id="minicex_time_section">
      <table class="evaluation-table">
        <tr>
          <td><strong>Mini-CEX time:</strong> Observing: <input type="text" class="form-control-inline" id="minicex_observing_mins" style="width: 60px;" readonly disabled> Mins.</td>
          <td>Providing Feedback: <input type="text" class="form-control-inline" id="minicex_feedback_mins" style="width: 60px;" readonly disabled> Mins</td>
        </tr>
      </table>
      
      <table class="evaluation-table complexity-table">
        <tr>
          <td class="complexity-header"><strong>Complexity</strong></td>
          <td class="complexity-option"><label><input type="radio" name="minicex_complexity" value="low" disabled> Low</label></td>
          <td class="complexity-option"><label><input type="radio" name="minicex_complexity" value="moderate" disabled> Moderate</label></td>
          <td class="complexity-option complexity-high"><label><input type="radio" name="minicex_complexity" value="high" disabled> high</label></td>
        </tr>
      </table>
      
      <div class="global-rating-section">
        <p><strong>Global rating</strong> An overall rating of this doctor's performance and professionalism in all areas. The global rating is not an algorithmic calculation of the candidate assessment criteria ratings but a judgement about the overall performance of the candidate.</p>
        <table class="evaluation-table competency-table">
          <tr>
            <th>Not-Competent</th>
            <th>Competent</th>
          </tr>
          <tr>
            <td><input type="radio" name="minicex_global_competency" value="not_competent" disabled></td>
            <td><input type="radio" name="minicex_global_competency" value="competent" disabled></td>
          </tr>
        </table>
      </div>
      
      <div class="text-section">
        <label><strong>Comments of assessor:</strong> <span class="text-muted small">Please describe what was effective, what could be improved and your overall impression. If required, please specify suggested actions for improvement and a timeline.</span></label>
        <textarea class="form-control" id="assessor_comments" name="assessor_comments" rows="4" readonly disabled></textarea>
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

    {{-- Mini-CEX Specific: Description Section --}}
    <div id="minicex_description_section">
      <div class="minicex-info-box">
        <p class="minicex-intro"><strong>The Mini-Clinical Evaluation Exercise (Mini-CEX)</strong> is a 10- to 20-minute, workplace-based assessment tool where a faculty member observes a trainee-patient interaction to provide immediate, constructive feedback. It evaluates key clinical skills like history-taking, physical exam, and professionalism.</p>
        
        <p>The mini-clinical evaluation exercise is the process of directly observing a doctor in a focused patient encounter for the purposes of assessment. It entails observing a candidate perform a focused task with a real patient such as taking a history, examining or counselling a patient. The assessor records judgments of the candidate's performance on a rating form and conducts a feedback session on the candidate's performance.</p>
        
        <h6 class="descriptors-title"><strong>Descriptors of criteria assessed during Mini-CEX</strong></h6>
        
        <p><strong class="criteria-name">Medical Interviewing and Communication Skills</strong><br>
        Facilitates patient's telling of story and explores the patient's problem(s) using plain English.<br>
        Effectively listens and uses questions/directions to obtain accurate/adequate information needed<br>
        Responds appropriately to affect non-verbal cues, establishes rapport.</p>
        
        <p><strong class="criteria-name">Professional/humanistic skills</strong><br>
        Is aware of safety issues; washes hands; maintains a professional approach to patient; demonstrates an understanding of the role of teams in patient care; attends to the patient's needs of comfort and any disabilities; and is respectful of colleagues Is open honest, empathetic and compassionate.</p>
        
        <p><strong class="criteria-name">Organisation/efficiency</strong><br>
        Makes efficient use of time and resources; is practised and well-organised.</p>
        
        <p><strong class="criteria-name">History taking skills</strong><br>
        Uses questions effectively to obtain an accurate, adequate history with necessary information; clearly identifies presenting problem and other active problems; identifies relevant features of past, social and family history.</p>
        
        <p><strong class="criteria-name">Physical examination skills</strong><br>
        Follows an efficient and logical sequence; performs an accurate and relevant clinical examination; explains process to patient; correctly interprets any significant abnormal clinical signs.</p>
        
        <p><strong class="criteria-name">Counselling, education and management skills</strong><br>
        Demonstrates an understanding of different cultural beliefs, values and priorities regarding their health and health care provision, and communicates effectively; manages informed consent; appropriate level of information provided; ability to use available educational resources; provides accurate information according to best practice guidelines; recommends sources of quality information.</p>
        
        <p><strong class="criteria-name">Clinical judgement/clinical reasoning</strong><br>
        Integrates and interprets findings from the history and/or examination to arrive at an initial assessment, including a relevant differential diagnosis; interprets clinical information accurately; and counselling takes account of the patient's socio-economic and psychosocial circumstances. Considers patient safety as a priority</p>
        
        <p><strong class="criteria-name">Global rating:</strong><br>
        <strong>An overall judgement of performance at the expected level at the end of IMIP.</strong></p>
      </div>
    </div>

  </div>

  {{-- Footer for View Mode - Print and Close Buttons --}}
  <div class="custom-modal-footer" id="footer_view_mode">
    <button type="button" class="btn btn-primary" onclick="printEvaluationPDF()">
      <i class="fas fa-print"></i> {{ __("public.print") }}
    </button>
    <button type="button" class="btn btn-danger" onclick="closeCustomModal()">
      <i class="fas fa-times"></i> {{ __("public.close") }}
    </button>
  </div>
</div>
