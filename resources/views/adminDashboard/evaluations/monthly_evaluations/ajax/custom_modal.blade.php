{{-- Custom Modal (Second Layer) - Evaluation Form --}}
<div id="customModal" class="custom-modal-overlay" style="display: none;">
  <div class="custom-modal-container evaluation-form-modal">
    
    {{-- Step 1: Form Selection --}}
    <div id="formSelectionStep">
      <div class="custom-modal-header">
        <h5>{{ __("public.add_new_evaluation") }}</h5>
        <button type="button" class="custom-modal-close" onclick="closeCustomModal()">&times;</button>
      </div>
      <div class="custom-modal-body">
        <div class="form-group">
          <label><strong>{{ __("public.select") }} {{ __("public.evaluation_form") }}:</strong></label>
          <select class="form-control" id="evaluation_form_select" onchange="loadEvaluationForm()">
            <option value="">-- {{ __("public.select") }} --</option>
          </select>
        </div>
        <div id="formLoadingIndicator" style="display: none; text-align: center; padding: 20px;">
          <img src="../images/loading.gif" style="width: 50px;" />
        </div>
      </div>
      <div class="custom-modal-footer">
        <button type="button" class="btn btn-danger" onclick="closeCustomModal()">
          <i class="fas fa-times"></i> {{ __("public.close") }}
        </button>
      </div>
    </div>

    {{-- Step 2: Evaluation Form Content Container (Hidden initially) - Form HTML will be loaded via AJAX --}}
    <div id="evaluationFormStep" style="display: none;">
      {{-- Form content will be loaded here dynamically based on form type --}}
    </div>

  </div>
</div>
