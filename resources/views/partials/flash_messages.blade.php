@if(Session::has('success') || Session::has('danger') || Session::has('warning') || Session::has('info'))
    <div class="alert">
        @if( Session::has( 'success' ))
            <div class="alert alert-success">
                <i class="fa fa-check-circle alert-icon"></i>
                {{ Session::get( 'success' ) }}
            </div>
        @endif
        @if( Session::has( 'danger' ))
            <div class="alert alert-danger">
                <i class="fa fa-times-circle alert-icon"></i>
                {{ Session::get( 'danger' ) }}
            </div>
        @endif
        @if( Session::has( 'info' ))
            <div class="alert alert-info">
                <i class="fa fa-info-circle alert-icon"></i>
                {{ Session::get( 'info' ) }}
            </div>
        @endif
        @if( Session::has( 'warning' ))
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-circle alert-icon"></i>
                {{ Session::get( 'warning' ) }}
            </div>
        @endif
    </div>
@endif
