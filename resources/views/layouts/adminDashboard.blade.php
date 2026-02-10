@if (config('app.theme') == 'adminlte')
    @include('layouts._adminlte')
@elseif(config('app.theme') == 'Fit')
    @include('layouts._fit')
@elseif(config('app.theme') == 'sash')
    @include('layouts._sash')
@elseif(config('app.theme') == 'ubold')
    @include('layouts._ubold')
@endif
