{{-- Info Popup --}}
{{-- Include Custom Modal CSS --}}
<link rel="stylesheet" href="{{ asset('css/custom_modal.css') }}">
 

<div class="modal-header">
  <h5>{{ __("evaluations.submenu_monthly_evaluations") }}</h5>
  <button type="button" class="btn btn-success" onclick="openCustomModal('{{ encrypt($record->id) }}')">
    <i class="fas fa-plus"></i> {{ __("public.add_new_evaluation") }}
  </button>
</div> <!--modal-header-->
<div class="modal-body">
<!--**********Start Content *************-->   

{{-- Success Messages for Info Popup --}}
<div id="info_success_insert" style="display: none;">
  <h4 class="alert alert-success text-center">{{ __("public.flashMsg_SuccessInsert") }}</h4>
</div>
<div id="info_success_update" style="display: none;">
  <h4 class="alert alert-success text-center">{{ __("public.flashMsg_SuccessUpdate") }}</h4>
</div>

{{-- Loader Overlay --}}
<div id="info_loading_overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999; justify-content: center; align-items: center;">
  <div style="text-align: center;">
    <img src="../images/loading.gif" style="width: 80px;" />
    <p style="margin-top: 10px; font-weight: bold;">Loading...</p>
  </div>
</div>

{{-- Evaluations Table --}}
<div class="table-responsive">
  <table class="table table-bordered table-striped text-center">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
        <th>{{ __("evaluations.form_name") }}</th>
        <th>{{ __("evaluations.submitted_date") }}</th>
        <th>{{ __("evaluations.assessor_name") }}</th>
        <th>{{ __("public.actions") }}</th>
      </tr>
    </thead>
    <tbody>
      @if(count($evaluations) > 0)
        @foreach($evaluations as $index => $evaluation)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $evaluation->form_name }}</td>
          <td>{{ $evaluation->submitted_date ? date('Y-m-d', strtotime($evaluation->submitted_date)) : '-' }}</td>
          <td>{{ $evaluation->assessor_name ?? '-' }}</td>
          <td>
            <button type="button" class="btn btn-info btn-sm" onclick="viewEvaluation('{{ encrypt($record->id) }}', '{{ encrypt($evaluation->form_id) }}', '{{ encrypt($evaluation->id) }}')" title="{{ __("public.details") }}">
              <i class="fas fa-eye"></i>
            </button>
            @if($evaluation->created_by == $currentUserId)
            <button type="button" class="btn btn-primary btn-sm" onclick="editEvaluation('{{ encrypt($record->id) }}', '{{ encrypt($evaluation->form_id) }}', '{{ encrypt($evaluation->id) }}')" title="Edit">
              <i class="fas fa-edit"></i>
            </button>
            @endif
          </td>
        </tr>
        @endforeach
      @else
        <tr>
          <td colspan="5">{{ __("evaluations.no_evaluations") }}</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>

<!--*********End Content*********-->   
<div class="modal-footer" id="modal-footer">     
   <button type="button" id="Close" name="Close" data-toggle="modal" data-target=".bd-dialog-modal-lg" data-bs-dismiss="modal" class="btn btn btn-danger" onclick="hidepopup()">
     <i class=""></i> {{ __("public.close") }}
   </button>
</div><!--modal-footer-->  
</div><!--modal-body-->

{{-- Include Custom Modal View --}}
@include('adminDashboard.evaluations.monthly_evaluations.ajax.custom_modal')

{{-- Include Custom Modal JS --}}
<script src="{{ asset('model-js/custom_modal.js') }}"></script>
