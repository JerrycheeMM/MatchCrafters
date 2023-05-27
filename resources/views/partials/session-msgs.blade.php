{{-- display error message --}}
@if(session('msg_error'))
    <div class="spacer"></div>
    <div class="col-md-115 alert alert-danger alert-dismissable" role="alert">
        <button style="top: 8px !important;" type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <ul class="left-pad-35">
            <li style="width: 95%">{{session('msg_error')}}</li>
        </ul>
    </div>
@endif
{{-- display info message --}}
@if(session('msg_info'))
    <div class="spacer"></div>
    <div class="col-md-115 alert alert-info alert-dismissable" role="alert">
        <button style="top: 8px !important;" type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <ul class="left-pad-35">
            <li style="width: 95%">{{session('msg_info')}}</li>
        </ul>
    </div>
@endif
{{-- display succsess message --}}
@if(session('msg_success'))
    <div class="spacer"></div>
    <div class="col-md-115 alert alert-success alert-dismissable" role="alert">
        <button style="top: 8px !important;" type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <ul class="left-pad-35">
            <li style="width: 95%">{{session('msg_success')}}</li>
        </ul>
    </div>
@endif
{{-- display warning message --}}
@if(session('msg_warning'))
    <div class="spacer"></div>
    <div class="col-md-115 alert alert-warning alert-dismissable" role="alert">
        <button style="top: 8px !important;" type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <ul class="left-pad-35">
            <li style="width: 95%">{{session('msg_warning')}}</li>
        </ul>
    </div>
@endif
@if($errors->any())
    <div class="spacer"></div>
    <div class="col-md-115 alert alert-danger alert-dismissable" role="alert">
        <button style="top: 8px !important;" type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <ul class="left-pad-35">
            @foreach ($errors->all() as $error)
                <li style="width: 95%">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
