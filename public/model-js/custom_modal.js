/**
 * Custom Modal JavaScript
 * Used for nested modals (popup inside popup) - Evaluation Forms
 */

// Store current evaluation data
var currentEvaluationData = null;
var currentMonthlyEvaluationId = null;
var currentDetailsId = null; // For update mode
var currentFormId = null;
var currentFormType = null;
var isViewMode = false; // Track if viewing existing evaluation

// Open Custom Modal and load form options
function openCustomModal(monthlyEvaluationId) {
  currentMonthlyEvaluationId = monthlyEvaluationId;
  currentDetailsId = null;
  currentFormId = null;
  currentFormType = null;
  isViewMode = false;
  
  // Show edit footer, hide view footer
  var footerEdit = document.getElementById('footer_edit_mode');
  var footerView = document.getElementById('footer_view_mode');
  if (footerEdit) footerEdit.style.display = 'flex';
  if (footerView) footerView.style.display = 'none';
  
  document.getElementById('customModal').style.display = 'flex';
  
  // Show form selection step, hide evaluation form
  document.getElementById('formSelectionStep').style.display = 'block';
  document.getElementById('evaluationFormStep').style.display = 'none';
  
  // Load evaluation forms dropdown
  loadEvaluationFormOptions();
}

// View existing evaluation - directly load the form with data
function viewEvaluation(monthlyEvaluationId, formId, detailsId) {
  currentMonthlyEvaluationId = monthlyEvaluationId;
  currentFormId = formId;
  currentDetailsId = detailsId;
  isViewMode = true;
  
  // Show view footer (only close button), hide edit footer
  var footerEdit = document.getElementById('footer_edit_mode');
  var footerView = document.getElementById('footer_view_mode');
  if (footerEdit) footerEdit.style.display = 'none';
  if (footerView) footerView.style.display = 'flex';
  
  // Show loader overlay
  var loader = document.getElementById('info_loading_overlay');
  if (loader) loader.style.display = 'flex';
  
  // First, load the form template HTML (VIEW mode)
  $.ajax({
    url: "get_evaluation_form_template",
    method: "post",
    data: {
      _token: document.getElementById('token').value,
      form_id: formId,
      mode: 'view'
    },
    success: function(templateHtml) {
      // Insert the template HTML into the container
      document.getElementById('evaluationFormStep').innerHTML = templateHtml;
      
      // Now load the form data
      $.ajax({
        url: "get_evaluation_form_data",
        method: "post",
        data: {
          _token: document.getElementById('token').value,
          form_id: formId,
          monthly_evaluation_id: monthlyEvaluationId,
          details_id: detailsId  // Pass the specific evaluation ID when viewing
        },
        success: function(result) {
          // Hide loader
          if (loader) loader.style.display = 'none';
          
          if (result.success) {
            currentEvaluationData = result;
            currentFormType = getFormType(result.form_name);
            
            // Set the details ID from result
            if (result.existing_data && result.existing_data.id) {
              currentDetailsId = result.existing_data.id;
            }
            
            populateEvaluationForm(result);
            
            // Disable all form inputs for view mode
            disableFormInputs(true);
            
            // Show custom modal with form
            document.getElementById('customModal').style.display = 'flex';
            document.getElementById('formSelectionStep').style.display = 'none';
            document.getElementById('evaluationFormStep').style.display = 'block';
          } else {
            alert('Error loading form data');
          }
        },
        error: function() {
          // Hide loader
          if (loader) loader.style.display = 'none';
          alert('Error loading form data');
        }
      });
    },
    error: function() {
      // Hide loader
      if (loader) loader.style.display = 'none';
      alert('Error loading form template');
    }
  });
}

// Edit existing evaluation - load the form with data in EDIT mode
function editEvaluation(monthlyEvaluationId, formId, detailsId) {
  currentMonthlyEvaluationId = monthlyEvaluationId;
  currentFormId = formId;
  currentDetailsId = detailsId;
  isViewMode = false;  // Edit mode, not view mode
  
  // Show edit footer, hide view footer
  var footerEdit = document.getElementById('footer_edit_mode');
  var footerView = document.getElementById('footer_view_mode');
  if (footerEdit) footerEdit.style.display = 'flex';
  if (footerView) footerView.style.display = 'none';
  
  // Show loader overlay
  var loader = document.getElementById('info_loading_overlay');
  if (loader) loader.style.display = 'flex';
  
  // First, load the form template HTML (EDIT mode)
  $.ajax({
    url: "get_evaluation_form_template",
    method: "post",
    data: {
      _token: document.getElementById('token').value,
      form_id: formId,
      mode: 'edit'
    },
    success: function(templateHtml) {
      // Insert the template HTML into the container
      document.getElementById('evaluationFormStep').innerHTML = templateHtml;
      
      // Now load the form data
      $.ajax({
        url: "get_evaluation_form_data",
        method: "post",
        data: {
          _token: document.getElementById('token').value,
          form_id: formId,
          monthly_evaluation_id: monthlyEvaluationId,
          details_id: detailsId  // Pass the specific evaluation ID
        },
        success: function(result) {
          // Hide loader
          if (loader) loader.style.display = 'none';
          
          if (result.success) {
            // Security check: Only allow edit if can_edit is true
            if (!result.can_edit) {
              alert('You are not authorized to edit this evaluation. Only the original assessor can edit.');
              return;
            }
            
            currentEvaluationData = result;
            currentFormType = getFormType(result.form_name);
            
            // Set the details ID from result
            if (result.existing_data && result.existing_data.id) {
              currentDetailsId = result.existing_data.id;
            }
            
            populateEvaluationForm(result);
            
            // Enable form inputs for edit mode
            disableFormInputs(false);
            
            // Remove Back button when editing existing (no form selection to go back to)
            // Completely remove from DOM so it can't be shown via inspect element
            var backBtn = document.getElementById('btn_back_evaluation');
            if (backBtn) backBtn.remove();
            
            // Show custom modal with form
            document.getElementById('customModal').style.display = 'flex';
            document.getElementById('formSelectionStep').style.display = 'none';
            document.getElementById('evaluationFormStep').style.display = 'block';
          } else {
            alert('Error loading form data');
          }
        },
        error: function() {
          // Hide loader
          if (loader) loader.style.display = 'none';
          alert('Error loading form data');
        }
      });
    },
    error: function() {
      // Hide loader
      if (loader) loader.style.display = 'none';
      alert('Error loading form template');
    }
  });
}

// Disable/Enable all form inputs
function disableFormInputs(disable) {
  var formStep = document.getElementById('evaluationFormStep');
  if (!formStep) return;
  
  // Disable/enable all inputs, textareas, selects, and radio/checkboxes
  var inputs = formStep.querySelectorAll('input, textarea, select');
  inputs.forEach(function(input) {
    input.disabled = disable;
    if (disable) {
      input.style.backgroundColor = '#f5f5f5';
      input.style.cursor = 'not-allowed';
    } else {
      input.style.backgroundColor = '';
      input.style.cursor = '';
    }
  });
}

// Close Custom Modal
function closeCustomModal() {
  document.getElementById('customModal').style.display = 'none';
  // Reset form selection
  document.getElementById('evaluation_form_select').value = '';
  document.getElementById('formSelectionStep').style.display = 'block';
  document.getElementById('evaluationFormStep').style.display = 'none';
  currentEvaluationData = null;
  currentDetailsId = null;
  currentFormId = null;
  
  // Re-enable form inputs for next use
  disableFormInputs(false);
}

// Load evaluation form options from server
function loadEvaluationFormOptions() {
  var select = document.getElementById('evaluation_form_select');
  select.innerHTML = '<option value="">-- Loading... --</option>';
  
  $.ajax({
    url: "get_evaluation_forms",
    method: "post",
    data: {
      _token: document.getElementById('token').value
    },
    success: function(result) {
      select.innerHTML = '<option value="">-- Select --</option>';
      if (result.forms && result.forms.length > 0) {
        result.forms.forEach(function(form) {
          var option = document.createElement('option');
          option.value = form.id;
          option.textContent = form.name;
          select.appendChild(option);
        });
      }
    },
    error: function() {
      select.innerHTML = '<option value="">-- Error loading --</option>';
    }
  });
}

// Load the selected evaluation form
function loadEvaluationForm() {
  var formId = document.getElementById('evaluation_form_select').value;
  if (!formId) return;
  
  currentFormId = formId;
  document.getElementById('formLoadingIndicator').style.display = 'block';
  
  // First, load the form template HTML (ADD mode)
  $.ajax({
    url: "get_evaluation_form_template",
    method: "post",
    data: {
      _token: document.getElementById('token').value,
      form_id: formId,
      mode: 'add'
    },
    success: function(templateHtml) {
      // Insert the template HTML into the container
      document.getElementById('evaluationFormStep').innerHTML = templateHtml;
      
      // Now load the form data (with is_new_record=true to always create a new evaluation)
      $.ajax({
        url: "get_evaluation_form_data",
        method: "post",
        data: {
          _token: document.getElementById('token').value,
          form_id: formId,
          monthly_evaluation_id: currentMonthlyEvaluationId,
          is_new_record: true  // Always create new record when adding
        },
        success: function(result) {
          document.getElementById('formLoadingIndicator').style.display = 'none';
          
          if (result.success) {
            currentEvaluationData = result;
            currentFormType = getFormType(result.form_name);
            
            // Always null for new records - will create new record
            currentDetailsId = null;
            
            populateEvaluationForm(result);
            
            // Show Back button when adding new (can go back to form selection)
            var backBtn = document.getElementById('btn_back_evaluation');
            if (backBtn) backBtn.style.display = 'inline-block';
            
            // Hide selection, show form
            document.getElementById('formSelectionStep').style.display = 'none';
            document.getElementById('evaluationFormStep').style.display = 'block';
          } else {
            alert('Error loading form data');
          }
        },
        error: function() {
          document.getElementById('formLoadingIndicator').style.display = 'none';
          alert('Error loading form data');
        }
      });
    },
    error: function() {
      document.getElementById('formLoadingIndicator').style.display = 'none';
      alert('Error loading form template');
    }
  });
}

// Determine form type from form name
function getFormType(formName) {
  if (!formName) return 'cbd';
  var name = formName.toLowerCase();
  if (name.indexOf('dops') !== -1) return 'dops';
  if (name.indexOf('mini-cex') !== -1 || name.indexOf('minicex') !== -1 || name.indexOf('mini cex') !== -1) return 'minicex';
  return 'cbd';
}

// Show/hide form sections based on form type
function showFormSections(formType) {
  // Table rows (inside info table)
  var cbdTitleRow = document.getElementById('cbd_title_row');
  var procedureNameRow = document.getElementById('procedure_name_row');
  var patientDataRow = document.getElementById('patient_data_row');
  var clinicalProblemRow = document.getElementById('clinical_problem_row');
  
  // CBD sections
  var cbdFeedbackSection = document.getElementById('cbd_feedback_section');
  
  // DOPS sections
  var dopsIndependentPractice = document.getElementById('dops_independent_practice');
  var dopsFeedbackAfterSignature = document.getElementById('dops_feedback_after_signature');
  
  // Mini-CEX sections
  var minicexTimeSection = document.getElementById('minicex_time_section');
  var minicexDescriptionSection = document.getElementById('minicex_description_section');
  
  // Hide all first
  if (cbdTitleRow) cbdTitleRow.style.display = 'none';
  if (procedureNameRow) procedureNameRow.style.display = 'none';
  if (patientDataRow) patientDataRow.style.display = 'none';
  if (clinicalProblemRow) clinicalProblemRow.style.display = 'none';
  if (cbdFeedbackSection) cbdFeedbackSection.style.display = 'none';
  if (dopsIndependentPractice) dopsIndependentPractice.style.display = 'none';
  if (dopsFeedbackAfterSignature) dopsFeedbackAfterSignature.style.display = 'none';
  if (minicexTimeSection) minicexTimeSection.style.display = 'none';
  if (minicexDescriptionSection) minicexDescriptionSection.style.display = 'none';
  
  // Show based on form type
  if (formType === 'cbd') {
    if (cbdTitleRow) cbdTitleRow.style.display = 'table-row';
    if (cbdFeedbackSection) cbdFeedbackSection.style.display = 'block';
  } else if (formType === 'dops') {
    if (procedureNameRow) procedureNameRow.style.display = 'table-row';
    if (dopsIndependentPractice) dopsIndependentPractice.style.display = 'block';
    if (dopsFeedbackAfterSignature) dopsFeedbackAfterSignature.style.display = 'block';
  } else if (formType === 'minicex') {
    if (patientDataRow) patientDataRow.style.display = 'table-row';
    if (clinicalProblemRow) clinicalProblemRow.style.display = 'table-row';
    if (minicexTimeSection) minicexTimeSection.style.display = 'block';
    if (minicexDescriptionSection) minicexDescriptionSection.style.display = 'block';
  }
}

// Current form type storage
var currentFormType = 'cbd';

// Populate the evaluation form with data
function populateEvaluationForm(data) {
  // Set header title
  var formTitleEl = document.getElementById('formTitle');
  if (formTitleEl) {
    formTitleEl.textContent = data.form_name || 'Evaluation Form';
  }
  
  // Determine form type (no longer need to show/hide sections since each form has its own template)
  currentFormType = getFormType(data.form_name);
  
  // Trainee Info
  var traineeNameEl = document.getElementById('trainee_name');
  if (traineeNameEl) traineeNameEl.textContent = data.trainee_name || '';
  
  var traineeImaEl = document.getElementById('trainee_ima');
  if (traineeImaEl) traineeImaEl.textContent = ''; // Empty for now
  
  var assessmentDateEl = document.getElementById('assessment_date');
  if (assessmentDateEl) assessmentDateEl.textContent = data.assessment_date || '';
  
  var traineeRotaEl = document.getElementById('trainee_rota');
  if (traineeRotaEl) traineeRotaEl.textContent = data.trainee_specialty || '';
  
  // Assessor Info
  var assessorNameEl = document.getElementById('assessor_name');
  if (assessorNameEl) assessorNameEl.textContent = data.assessor_name || '';
  
  var assessorEmailEl = document.getElementById('assessor_email');
  if (assessorEmailEl) assessorEmailEl.textContent = data.assessor_email || '';
  
  var assessorNumberEl = document.getElementById('assessor_number');
  if (assessorNumberEl) assessorNumberEl.textContent = ''; // Empty for now
  
  var hospitalNameEl = document.getElementById('hospital_name');
  if (hospitalNameEl) hospitalNameEl.textContent = data.hospital_name || '';
  
  // Clinical Settings (Checkboxes)
  var clinicalContainer = document.getElementById('clinical_settings_container');
  if (clinicalContainer) {
    clinicalContainer.innerHTML = '';
    var existingClinicalSettings = data.existing_clinical_settings || [];
    
    if (data.clinical_settings && data.clinical_settings.length > 0) {
      data.clinical_settings.forEach(function(setting) {
        var isChecked = existingClinicalSettings.includes(setting.id) ? 'checked' : '';
        var label = document.createElement('label');
        label.innerHTML = '<input type="checkbox" name="clinical_setting[]" value="' + setting.id + '" ' + isChecked + '> ' + setting.name;
        clinicalContainer.appendChild(label);
      });
    }
  }
  
  // Assessment Criteria (Questions)
  var criteriaBody = document.getElementById('assessment_criteria_body');
  if (criteriaBody) {
    criteriaBody.innerHTML = '';
    var existingAnswers = data.existing_answers || {};
    
    if (data.assessment_criteria && data.assessment_criteria.length > 0) {
      data.assessment_criteria.forEach(function(criteria, index) {
        var isBold = criteria.is_bold || false;
        var existingAnswer = existingAnswers[criteria.id] || {};
        
        // Check which radio should be selected
        var naChecked = existingAnswer.n_a == 1 ? 'checked' : '';
        var belowChecked = existingAnswer.below_standard == 1 ? 'checked' : '';
        var meetsChecked = existingAnswer.meets_standard == 1 ? 'checked' : '';
        var aboveChecked = existingAnswer.above_standard == 1 ? 'checked' : '';
        
        var tr = document.createElement('tr');
        tr.innerHTML = 
          '<td class="' + (isBold ? 'criteria-bold' : '') + '">' + criteria.question + '</td>' +
          '<td><input type="radio" name="criteria_' + criteria.id + '" value="na" ' + naChecked + ' onchange="clearRowValidation(this)"></td>' +
          '<td><input type="radio" name="criteria_' + criteria.id + '" value="below" ' + belowChecked + ' onchange="clearRowValidation(this)"></td>' +
          '<td><input type="radio" name="criteria_' + criteria.id + '" value="meets" ' + meetsChecked + ' onchange="clearRowValidation(this)"></td>' +
          '<td><input type="radio" name="criteria_' + criteria.id + '" value="above" ' + aboveChecked + ' onchange="clearRowValidation(this)"></td>';
        criteriaBody.appendChild(tr);
      });
    }
  }
  
  // Populate text inputs with existing data or clear them
  var existingData = data.existing_data || {};
  
  // CBD fields
  if (document.getElementById('cbd_title')) {
    document.getElementById('cbd_title').value = existingData.cbd_title || '';
  }
  if (document.getElementById('aspects_done_well')) {
    document.getElementById('aspects_done_well').value = existingData.aspects_done_well || '';
  }
  if (document.getElementById('suggested_improvement')) {
    document.getElementById('suggested_improvement').value = existingData.suggested_improvement || '';
  }
  if (document.getElementById('time_discussion')) {
    document.getElementById('time_discussion').value = existingData.time_discussion || '';
  }
  if (document.getElementById('time_feedback')) {
    document.getElementById('time_feedback').value = existingData.time_feedback || '';
  }
  
  // DOPS fields - Procedure List Dropdown
  var procedureListSelect = document.getElementById('procedure_list_id');
  if (procedureListSelect && data.procedure_list) {
    // Destroy existing Select2 if initialized
    if ($(procedureListSelect).hasClass('select2-hidden-accessible')) {
      $(procedureListSelect).select2('destroy');
    }
    
    // Clear existing options except the first one
    procedureListSelect.innerHTML = '<option value="">-- Select Procedure --</option>';
    
    // Add procedures with format: "Category Name | Procedure Name"
    data.procedure_list.forEach(function(proc) {
      var option = document.createElement('option');
      option.value = proc.id;
      option.textContent = proc.category_name + ' | ' + proc.procedure_name;
      procedureListSelect.appendChild(option);
    });
    
    // Add "Other" option at the end
    var otherOption = document.createElement('option');
    otherOption.value = 'other';
    otherOption.textContent = 'Other';
    procedureListSelect.appendChild(otherOption);
    
    // Set existing value
    if (existingData.procedure_list_id) {
      procedureListSelect.value = existingData.procedure_list_id;
    } else if (existingData.procedure_name_other) {
      procedureListSelect.value = 'other';
      var procedureOtherInput = document.getElementById('procedure_name_other');
      if (procedureOtherInput) {
        procedureOtherInput.value = existingData.procedure_name_other;
        procedureOtherInput.style.display = 'block';
      }
    }
    
    // Initialize Select2
    $(procedureListSelect).select2({
      placeholder: '-- Select Procedure --',
      allowClear: true,
      dropdownParent: $('#customModal')
    });
    
    // Bind change event for Select2
    $(procedureListSelect).on('change', function() {
      onProcedureSelectChange();
    });
  }
  
  // For view mode, display the procedure name as text (Category Name | Procedure Name)
  var procedureDisplayEl = document.getElementById('procedure_name_display');
  if (procedureDisplayEl) {
    if (existingData.procedure_list_id) {
      // Show "Category Name | Procedure Name" format
      var categoryName = existingData.category_name || '';
      var procedureName = existingData.procedure_name || '';
      if (categoryName && procedureName) {
        procedureDisplayEl.textContent = categoryName + ' | ' + procedureName;
      } else {
        procedureDisplayEl.textContent = procedureName || '-';
      }
    } else if (existingData.procedure_name_other) {
      procedureDisplayEl.textContent = existingData.procedure_name_other + ' (Other)';
    } else {
      procedureDisplayEl.textContent = existingData.procedure_name || '-';
    }
  }
  
  if (document.getElementById('dops_agreed_action_plan')) {
    document.getElementById('dops_agreed_action_plan').value = existingData.agreed_action_plan || '';
  }
  if (document.getElementById('dops_aspects_done_well')) {
    document.getElementById('dops_aspects_done_well').value = existingData.aspects_done_well || '';
  }
  if (document.getElementById('dops_suggested_improvement')) {
    document.getElementById('dops_suggested_improvement').value = existingData.suggested_improvement || '';
  }
  
  // DOPS Independent Practice Checkboxes
  if (document.getElementById('unable_perform_procedure')) {
    document.getElementById('unable_perform_procedure').checked = existingData.unable_perform_procedure == 1;
  }
  if (document.getElementById('able_perform_procedure')) {
    document.getElementById('able_perform_procedure').checked = existingData.able_perform_procedure == 1;
  }
  if (document.getElementById('trained_and_competent')) {
    document.getElementById('trained_and_competent').checked = existingData.trained_and_competent == 1;
  }
  if (document.getElementById('able_perform_procedure_limited')) {
    document.getElementById('able_perform_procedure_limited').checked = existingData.able_perform_procedure_limited == 1;
  }
  if (document.getElementById('competent_perform_procedure_unsupervised')) {
    document.getElementById('competent_perform_procedure_unsupervised').checked = existingData.competent_perform_procedure_unsupervised == 1;
  }
  
  // Mini-CEX fields
  if (document.getElementById('clinical_problem')) {
    document.getElementById('clinical_problem').value = existingData.clinical_problem || '';
  }
  if (document.getElementById('assessor_comments')) {
    document.getElementById('assessor_comments').value = existingData.assessor_comments || '';
  }
  if (document.getElementById('patient_age')) {
    document.getElementById('patient_age').value = existingData.patient_age || '';
  }
  if (document.getElementById('patient_sex')) {
    document.getElementById('patient_sex').value = existingData.patient_sex || '';
  }
  if (document.getElementById('minicex_observing_mins')) {
    document.getElementById('minicex_observing_mins').value = existingData.minicex_observing_mins || '';
  }
  if (document.getElementById('minicex_feedback_mins')) {
    document.getElementById('minicex_feedback_mins').value = existingData.minicex_feedback_mins || '';
  }
  
  // Mini-CEX complexity radio buttons
  if (existingData.complexity_low == 1) {
    var complexityLow = document.querySelector('input[name="minicex_complexity"][value="low"]');
    if (complexityLow) complexityLow.checked = true;
  } else if (existingData.complexity_moderate == 1) {
    var complexityMod = document.querySelector('input[name="minicex_complexity"][value="moderate"]');
    if (complexityMod) complexityMod.checked = true;
  } else if (existingData.complexity_high == 1) {
    var complexityHigh = document.querySelector('input[name="minicex_complexity"][value="high"]');
    if (complexityHigh) complexityHigh.checked = true;
  }
  
  // Mini-CEX global competency radio buttons
  if (existingData.not_competent == 1) {
    var notCompetent = document.querySelector('input[name="minicex_global_competency"][value="not_competent"]');
    if (notCompetent) notCompetent.checked = true;
  } else if (existingData.competent == 1) {
    var competent = document.querySelector('input[name="minicex_global_competency"][value="competent"]');
    if (competent) competent.checked = true;
  }
  
  // Check if user can edit - only the creator can edit existing forms
  var canEdit = data.can_edit !== false; // Default true for new forms
  var hasExistingData = data.existing_data && data.existing_data.id;
  
  // Get footer elements (they are inside the dynamically loaded template)
  var footerEditMode = document.getElementById('footer_edit_mode');
  var footerViewMode = document.getElementById('footer_view_mode');
  
  // If in view mode (opened via viewEvaluation), always show view footer
  if (isViewMode) {
    setFormReadOnly(true);
    if (footerEditMode) footerEditMode.style.display = 'none';
    if (footerViewMode) footerViewMode.style.display = 'flex';
  } else if (hasExistingData && !canEdit) {
    // User opened via add/edit but cannot edit (not the creator)
    setFormReadOnly(true);
    if (footerEditMode) footerEditMode.style.display = 'none';
    if (footerViewMode) footerViewMode.style.display = 'flex';
  } else {
    // Edit mode - user can add new or edit their own
    setFormReadOnly(false);
    if (footerEditMode) footerEditMode.style.display = 'flex';
    if (footerViewMode) footerViewMode.style.display = 'none';
  }
}

// Set form to read-only mode
function setFormReadOnly(readOnly) {
  var formContainer = document.getElementById('evaluationFormStep');
  
  // Disable all inputs, selects, textareas
  var inputs = formContainer.querySelectorAll('input, select, textarea');
  inputs.forEach(function(input) {
    input.disabled = readOnly;
  });
  
  // Add visual indicator for read-only mode
  if (readOnly) {
    formContainer.classList.add('form-read-only');
  } else {
    formContainer.classList.remove('form-read-only');
  }
}

// Clear validation error when user selects an answer
function clearRowValidation(radio) {
  var row = radio.closest('tr');
  if (row) {
    row.classList.remove('validation-error');
    row.style.border = '';
    row.style.backgroundColor = '';
  }
}

// Handle procedure dropdown change - show/hide "Other" text input
function onProcedureSelectChange() {
  var procedureSelect = document.getElementById('procedure_list_id');
  var procedureOtherInput = document.getElementById('procedure_name_other');
  
  if (procedureSelect && procedureOtherInput) {
    if (procedureSelect.value === 'other') {
      procedureOtherInput.style.display = 'block';
      procedureOtherInput.focus();
    } else {
      procedureOtherInput.style.display = 'none';
      procedureOtherInput.value = '';
    }
  }
}

// Go back to form selection
function backToFormSelection() {
  document.getElementById('formSelectionStep').style.display = 'block';
  document.getElementById('evaluationFormStep').style.display = 'none';
}

// Save Evaluation Form
function saveEvaluationForm() {
  // Clear previous validation errors
  var allRows = document.querySelectorAll('#assessment_criteria_body tr');
  allRows.forEach(function(row) {
    row.classList.remove('validation-error');
    row.style.border = '';
  });
  
  // Validate: All questions must be answered
  var hasValidationError = false;
  if (currentEvaluationData && currentEvaluationData.assessment_criteria) {
    currentEvaluationData.assessment_criteria.forEach(function(criteria, index) {
      var selectedRadio = document.querySelector('input[name="criteria_' + criteria.id + '"]:checked');
      if (!selectedRadio) {
        hasValidationError = true;
        // Find the row and add red border
        var row = allRows[index];
        if (row) {
          row.classList.add('validation-error');
          row.style.border = '2px solid #dc3545';
          row.style.backgroundColor = '#fff5f5';
        }
      }
    });
    
    if (hasValidationError) {
      // Scroll to first error
      var firstError = document.querySelector('#assessment_criteria_body tr.validation-error');
      if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
      return; // Stop saving
    }
  }
  
  // Collect form data based on form type
  var formData = {
    _token: document.getElementById('token').value,
    monthly_evaluation_id: currentMonthlyEvaluationId,
    form_id: currentFormId,
    details_id: currentDetailsId,
    form_type: currentFormType,
    answers: {},
    clinical_settings: []
  };
  
  // CBD fields: cbd_title, aspects_done_well, suggested_improvement, time_discussion, time_feedback
  if (currentFormType === 'cbd') {
    formData.cbd_title = document.getElementById('cbd_title') ? document.getElementById('cbd_title').value : '';
    formData.aspects_done_well = document.getElementById('aspects_done_well') ? document.getElementById('aspects_done_well').value : '';
    formData.suggested_improvement = document.getElementById('suggested_improvement') ? document.getElementById('suggested_improvement').value : '';
    formData.time_discussion = document.getElementById('time_discussion') ? document.getElementById('time_discussion').value : '';
    formData.time_feedback = document.getElementById('time_feedback') ? document.getElementById('time_feedback').value : '';
  }
  
  // DOPS fields: procedure_list_id, procedure_name_other, aspects_done_well, suggested_improvement, agreed_action_plan, and independent practice checkboxes
  if (currentFormType === 'dops') {
    formData.procedure_list_id = document.getElementById('procedure_list_id') ? document.getElementById('procedure_list_id').value : '';
    formData.procedure_name_other = document.getElementById('procedure_name_other') ? document.getElementById('procedure_name_other').value : '';
    formData.aspects_done_well = document.getElementById('dops_aspects_done_well') ? document.getElementById('dops_aspects_done_well').value : '';
    formData.suggested_improvement = document.getElementById('dops_suggested_improvement') ? document.getElementById('dops_suggested_improvement').value : '';
    formData.agreed_action_plan = document.getElementById('dops_agreed_action_plan') ? document.getElementById('dops_agreed_action_plan').value : '';
    
    // Independent practice checkboxes
    formData.unable_perform_procedure = document.getElementById('unable_perform_procedure') && document.getElementById('unable_perform_procedure').checked ? 1 : 0;
    formData.able_perform_procedure = document.getElementById('able_perform_procedure') && document.getElementById('able_perform_procedure').checked ? 1 : 0;
    formData.trained_and_competent = document.getElementById('trained_and_competent') && document.getElementById('trained_and_competent').checked ? 1 : 0;
    formData.able_perform_procedure_limited = document.getElementById('able_perform_procedure_limited') && document.getElementById('able_perform_procedure_limited').checked ? 1 : 0;
    formData.competent_perform_procedure_unsupervised = document.getElementById('competent_perform_procedure_unsupervised') && document.getElementById('competent_perform_procedure_unsupervised').checked ? 1 : 0;
  }
  
  // Mini-CEX fields: clinical_problem, assessor_comments, and time/complexity/competency fields
  if (currentFormType === 'minicex') {
    formData.clinical_problem = document.getElementById('clinical_problem') ? document.getElementById('clinical_problem').value : '';
    formData.assessor_comments = document.getElementById('assessor_comments') ? document.getElementById('assessor_comments').value : '';
    formData.patient_age = document.getElementById('patient_age') ? document.getElementById('patient_age').value : '';
    formData.patient_sex = document.getElementById('patient_sex') ? document.getElementById('patient_sex').value : '';
    formData.minicex_observing_mins = document.getElementById('minicex_observing_mins') ? document.getElementById('minicex_observing_mins').value : '';
    formData.minicex_feedback_mins = document.getElementById('minicex_feedback_mins') ? document.getElementById('minicex_feedback_mins').value : '';
    
    // Complexity radio buttons
    var complexityLow = document.querySelector('input[name="minicex_complexity"][value="low"]:checked');
    var complexityMod = document.querySelector('input[name="minicex_complexity"][value="moderate"]:checked');
    var complexityHigh = document.querySelector('input[name="minicex_complexity"][value="high"]:checked');
    formData.complexity_low = complexityLow ? 1 : 0;
    formData.complexity_moderate = complexityMod ? 1 : 0;
    formData.complexity_high = complexityHigh ? 1 : 0;
    
    // Global competency radio buttons
    var notCompetent = document.querySelector('input[name="minicex_global_competency"][value="not_competent"]:checked');
    var competent = document.querySelector('input[name="minicex_global_competency"][value="competent"]:checked');
    formData.not_competent = notCompetent ? 1 : 0;
    formData.competent = competent ? 1 : 0;
  }
  
  // Collect clinical settings (checked checkboxes) - for all forms
  var clinicalCheckboxes = document.querySelectorAll('input[name="clinical_setting[]"]:checked');
  clinicalCheckboxes.forEach(function(checkbox) {
    formData.clinical_settings.push(parseInt(checkbox.value));
  });
  
  // Collect answers (radio buttons) - for all forms
  if (currentEvaluationData && currentEvaluationData.assessment_criteria) {
    currentEvaluationData.assessment_criteria.forEach(function(criteria) {
      var selectedRadio = document.querySelector('input[name="criteria_' + criteria.id + '"]:checked');
      if (selectedRadio) {
        var value = selectedRadio.value;
        formData.answers[criteria.id] = {
          n_a: value === 'na' ? 1 : 0,
          below_standard: value === 'below' ? 1 : 0,
          meets_standard: value === 'meets' ? 1 : 0,
          above_standard: value === 'above' ? 1 : 0
        };
      }
    });
  }
  
  // Track if this is an insert or update
  var isUpdate = currentDetailsId ? true : false;
  
  // Show loading and disable all buttons
  var saveBtn = document.getElementById('btn_save_evaluation');
  var backBtn = document.getElementById('btn_back_evaluation');
  var closeBtn = document.getElementById('btn_close_evaluation');
  var closeModalBtn = document.querySelector('.custom-modal-close');
  var successInsertMsg = document.getElementById('evaluation_success_insert');
  var successUpdateMsg = document.getElementById('evaluation_success_update');
  
  var originalText = saveBtn.innerHTML;
  saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
  saveBtn.disabled = true;
  if (backBtn) backBtn.disabled = true;
  if (closeBtn) closeBtn.disabled = true;
  if (closeModalBtn) closeModalBtn.disabled = true;
  
  // Hide any previous success messages
  if (successInsertMsg) successInsertMsg.style.display = 'none';
  if (successUpdateMsg) successUpdateMsg.style.display = 'none';
  
  $.ajaxSetup({ headers: { "X-CSRF-TOKEN": document.getElementById('token').value } });
  $.ajax({
    url: "save_evaluation_form",
    method: "post",
    data: formData,
    success: function(result) {
      saveBtn.innerHTML = originalText;
      saveBtn.disabled = false;
      if (backBtn) backBtn.disabled = false;
      if (closeBtn) closeBtn.disabled = false;
      if (closeModalBtn) closeModalBtn.disabled = false;
      
      if (result.success) {
        currentDetailsId = result.details_id; // Update for future saves
        
        // Close the custom modal
        closeCustomModal();
        
        // Reload the info popup to refresh the table, then show success message
        reloadInfoPopup(isUpdate);
      } else {
        alert('Error: ' + (result.message || 'Unknown error'));
      }
    },
    error: function(xhr) {
      saveBtn.innerHTML = originalText;
      saveBtn.disabled = false;
      if (backBtn) backBtn.disabled = false;
      if (closeBtn) closeBtn.disabled = false;
      if (closeModalBtn) closeModalBtn.disabled = false;
      alert('Error saving evaluation. Please try again.');
      console.log(xhr.responseText);
    }
  });
}

// Reload the info popup to refresh the evaluations table
function reloadInfoPopup(isUpdate) {
  if (currentMonthlyEvaluationId) {
    $.ajaxSetup({ headers: { "X-CSRF-TOKEN": $("#token").val() } });
    $.ajax({
      url: "monthly_evaluations_info",
      method: "post",
      data: {
        id: currentMonthlyEvaluationId,
      },
      success: function(result) {
        $(".result_content").html(result);
        
        // Show success message after reload (wait for DOM to update)
        setTimeout(function() {
          var infoSuccessInsert = document.getElementById('info_success_insert');
          var infoSuccessUpdate = document.getElementById('info_success_update');
          
          // Hide both first
          if (infoSuccessInsert) infoSuccessInsert.style.display = 'none';
          if (infoSuccessUpdate) infoSuccessUpdate.style.display = 'none';
          
          // Show correct message based on operation type
          if (isUpdate) {
            if (infoSuccessUpdate) infoSuccessUpdate.style.display = 'block';
          } else {
            if (infoSuccessInsert) infoSuccessInsert.style.display = 'block';
          }
        }, 100);
      },
    });
  }
}

// Print Evaluation Form as PDF
function printEvaluationPDF() {
  if (!currentDetailsId) {
    alert('No evaluation to print');
    return;
  }
  
  // Open PDF in new window/tab - encode the encrypted IDs for URL safety
  var url = 'print_evaluation_pdf?details_id=' + encodeURIComponent(currentDetailsId) + '&form_id=' + encodeURIComponent(currentFormId);
  window.open(url, '_blank');
}

// Initialize - Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
  var customModal = document.getElementById('customModal');
  if (customModal) {
    customModal.addEventListener('click', function(e) {
      if (e.target === this) {
        closeCustomModal();
      }
    });
  }
});
