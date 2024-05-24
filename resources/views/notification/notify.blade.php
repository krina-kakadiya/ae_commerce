<!-- Notifications  css -->
<link href="{{ URL::asset('assets/plugins/notify/css/jquery.growl.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
<!-- Popover js -->
<script src="{{ URL::asset('assets/js/popover.js') }}"></script>
<!-- Notifications js -->
<script src="{{ URL::asset('assets/plugins/notify/js/rainbow.js') }}"></script>
{{-- <script src="{{ URL::asset('assets/plugins/notify/js/sample.js') }}"></script> --}}
<script src="{{ URL::asset('assets/plugins/notify/js/jquery.growl.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>

@if (session()->get('success'))
    <script>
        notif({
            msg: '<b>Success: </b> {{ session()->get('success') }}',
            type: "success"
        });
    </script>
@endif

@if (session()->get('info'))
    <script>
        notif({
            msg: '<b>Info: </b> {{ session()->get('info') }}',
            type: "info"
        });
    </script>
@endif

@if (session()->get('error'))
    <script>
        notif({
            msg: '<b>Error: </b> {{ session()->get('error') }}',
            type: "error"
        });
    </script>
@endif
