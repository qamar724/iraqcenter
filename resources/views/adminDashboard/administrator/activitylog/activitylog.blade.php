@extends('layouts.adminDashboard')
@section('content')
    @php
        //74545233320012
        use App\Http\Controllers\SystemController\System;
        use App\Http\Controllers\SystemController\Permission;
        use Jenssegers\Agent\Agent as Agent;
        $Agent = new Agent();
    @endphp
    <div class="col-md-12 ">
        <div class="card card-primary">
            <div class="card-header ">
                <h3 class="card-title "> {{ __('public.submenu_logsystem') }} </h3>
                
            </div>
            <div class="card-body">
                <!-- start response CRUD code -->
                @if (Session::has('success_insert'))
                    <h3 class="alert alert-success  text-center"> {{ Session::get('success_insert') }} </h3>
                @endif
                @if (Session::has('success_update'))
                    <h3 class="alert alert-success  text-center"> {{ Session::get('success_update') }} </h3>
                @endif
                <!-- end response CRUD code -->
                @if ($permissions['viewPage'])
                    @if ($Agent->isMobile())
                        <?php $counter = 1; ?>
                        @foreach ($records as $record)
                            <div class="col-xl-4 col-lg-12 col-sm-12">
                                <div class="card border">
                                    <div class="card-body pb-0">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex px-0 justify-content-between">
                                                <strong> {{ __('public.administrator_logsystem_id') }} </strong>
                                                <td> {{ $counter++ }}</td>
                                            </li>
                                            <li class="list-group-item d-flex px-0 justify-content-between">
                                                <strong> {{ __('public.administrator_logsystem_log_name') }}
                                                </strong>
                                                <span class="mb-0"> <span
                                                        style='background: {{ $record->log_name }} ;display: block; width: 73px; height: 20px;margin: 0px auto;'></span>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex px-0 justify-content-between">
                                                <strong> {{ __('public.administrator_logsystem_description') }}
                                                </strong>
                                                <span class="mb-0"> <span
                                                        style='background: {{ $record->description }} ;display: block; width: 73px; height: 20px;margin: 0px auto;'></span>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex px-0 justify-content-between">
                                                <strong> {{ __('public.administrator_logsystem_subject_type') }}
                                                </strong>
                                                <span class="mb-0"> <span
                                                        style='background: {{ $record->subject_type }} ;display: block; width: 73px; height: 20px;margin: 0px auto;'></span>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex px-0 justify-content-between">
                                                <strong> {{ __('public.administrator_logsystem_causer_type') }}
                                                </strong>
                                                <span class="mb-0"> <span
                                                        style='background: {{ $record->causer_type }} ;display: block; width: 73px; height: 20px;margin: 0px auto;'></span>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex px-0 justify-content-between">
                                                <strong> {{ __('public.administrator_logsystem_properties') }}
                                                </strong>
                                                <span class="mb-0"> <span
                                                        style='background: {{ $record->properties }} ;display: block; width: 73px; height: 20px;margin: 0px auto;'></span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer pt-0 pb-0 text-center">
                                        <div class="row">
                                            <div class="col-6 pt-3 pb-3 border-right">
                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal"
                                                    data-target=".bd-dialog-modal-lg"
                                                    onclick="getDetails_logsystem({{ $record->id }},'logsystem')"
                                                    class="btn btn-info shadow btn-xs sharp "><i class="fa fa-info"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- count if exists records -->
                        @if (count($records) >= 1)
                            <div class="table-responsive" id="Table_Responsive">
                                <table
                                    class="table table-bordered table-generated  table-hover styled-table table-sm text-center"
                                    id="table">
                                    <thead>
                                        <tr>
                                            <th> {{ __('public.administrator_logsystem_id') }} </th>
                                            <th> {{ __('public.administrator_logsystem_log_name') }} </th>
                                            <th> {{ __('public.administrator_logsystem_description') }}  </th>
                                            <th> {{ __('public.administrator_logsystem_action_by') }}  </th>
                                            <th> {{ __('public.administrator_logsystem_subject_type') }} </th>
                                         
                                            <th> {{ __('public.created_date') }}
                                            <th> {{ __('public.actions') }} </th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 1; ?>
                                        @foreach ($records as $record)
                                            <tr id='tr_{{ $record->id }}'>
                                                <td> {{ $counter++ }}</td>
                                                <td> {{ $record->log_name }}</td>
                                                <td>
                                                    @if ($record->description == 'created')
                                                        <span class="badge badge-pill badge-lg badge-success">{{ __("public.created_log") }}</span>
                                                    @endif
                                                    @if ($record->description == 'updated')
                                                        <span class="badge badge-pill badge-lg badge-warning">{{ __("public.updated_log") }}</span>
                                                    @endif
                                                    @if ($record->description == 'deleted')
                                                        <span class="badge badge-pill badge-lg badge-danger">{{ __("public.deleted_log") }}</span>
                                                    @endif
                                                </td>
                                                <td> {{ $record->user_name }}</td>
                                                <td> {{ $record->subject_type }}</td>
                                              
                                                <td> {{ $record->created_at }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target=".bd-dialog-modal-lg" data-toggle="modal"
                                                        data-target=".bd-dialog-modal-lg"
                                                        onclick="getDetails_activitylog({{ $record->id }},'logsystem')"
                                                        class="btn btn-info shadow btn-xs sharp "><i
                                                            class="fa fa-info"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $records->links('pagination::bootstrap-4') }}
                        @else
                            <h3 class="alert alert-warning  text-center">{{ __('public.msgIndexNoData') }}</h3>
                        @endif
                    @endif
                @else
                    <h3 class="alert alert-danger text-center">{{ __('public.noPermission') }}</h3>
                @endif
            </div>
        </div>
    </div>
    <input type="hidden" id="hiddenFolderName" class="hiddenFolderName" value="{{ $folderName }}" />
    <input type="hidden" id="hiddenTable" class="hiddenTable" value="{{ $table }}" />
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <script src={{ asset('model-js/activitylog.js') }}></script>
@endsection
