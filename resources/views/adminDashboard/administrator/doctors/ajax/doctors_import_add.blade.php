{{-- doctors import modal --}}
@if($permissions["insertNew"])
<div class="modal-header">
  <h5>{{__("public.import_new_field")}}</h5>
</div>
<div class="modal-body">
  <div class="alert alert-info mb-3">
    {{__("public.choose_file_to_import") ?? 'Upload Excel/CSV file with doctors.'}}
    <a href="{{ route('adminPanel.doctors.import.sample') }}" class="btn btn-sm btn-outline-secondary ms-2">{{ __("public.download_sample") ?? 'Download sample file'}}</a>
  </div>
  <div id="errorsResults" class="errorsResults"></div>
  <div class="form-group">
    <label for="file">{{__('public.file')}}</label>
    <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv">
  </div>
</div>
<div class="modal-footer">
  <button type="button" id="Save" class="btn btn-primary" onclick="doctors_ConfirmImport()"><i class="loader fa"></i> {{__('public.import')}}</button>
  <button type="button" id="Close" class="btn btn-danger" data-bs-dismiss="modal" onclick="hidepopup()">{{__('public.close')}}</button>
</div>
@else
<div class="modal-header">
  <h5>{{__("public.import_new_field")}}</h5>
</div>
<div class="modal-body">
  <div class="alert alert-danger">{{__('public.noPermission')}}</div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="hidepopup()">{{__('public.close')}}</button>
</div>
@endif
