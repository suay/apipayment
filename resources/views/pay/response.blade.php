<div class="panel-body">
    <section class="bills-env">
        <div class="panel panel-default">
            <div id="panel-receipt-list">
                @if($status == 0)
                <div style="text-align:center;">
                    <h1> ทำรายการไม่สำเร็จ </h1>
                   
                </div>
                @else
                <div style="text-align:center;">
                    <h1> ทำรายการสำเร็จ</h1>
                  
                </div>
                @endif
            </div>
        </div>
    </section>
</div>



<!-- favicon -->
<link rel="shortcut icon" href="{{url('/')}}/images/logo/favicon.ico" type="image/x-icon">
<link rel="icon" href="{{url('/')}}/images/logo/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="{{ url('/') }}/css/fonts/linecons/css/linecons.css">
<link rel="stylesheet" href="{{ url('/') }}/css/fonts/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ url('/') }}/css/bootstrap.css">
<link rel="stylesheet" href="{{ url('/') }}/css/core.css">
<link rel="stylesheet" href="{{ url('/') }}/css/xenon-forms.css">
<link rel="stylesheet" href="{{ url('/') }}/css/xenon-components.css">
<link rel="stylesheet" href="{{ url('/') }}/css/menu-style.css">
<link rel="stylesheet" href="{{ url('/') }}/css/ap-theme.css">

<link rel="stylesheet" href="{{ url('/') }}/css/custom.css?version={{time()}}">
<link rel="stylesheet" href="{{ url('/') }}/css/fonts/elusive/css/elusive.css">
<link rel="stylesheet" href="{{ url('/') }}/css/simple-line-icons/css/simple-line-icons.css">
<link rel="stylesheet" href="{{ url('/') }}/css/skins.css">

<script type="text/javascript" src="{{url('/')}}/js/jquery-validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
function close_window() {
    if (confirm("Close Window?")) {
        window.open('', '_parent', '');
        window.close();
    }
}
</script>





