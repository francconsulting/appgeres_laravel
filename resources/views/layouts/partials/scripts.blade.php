<!-- REQUIRED JS SCRIPTS -->

<script src="{{ url ('js/appgeres/JQuery-3_2_1.js') }}" type="text/javascript"></script>
<script src="{{ url ('js/appgeres/common.js') }}" type="text/javascript"></script>
<script src="{{ url ('js/appgeres/func_async.js') }}" type="text/javascript"></script>
<script src="{{ url ('js/appgeres/personalsanitario/personalsanitario.js') }}" type="text/javascript"></script>



<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->

<script src="{{ url ('plugins/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('plugins/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<link href="{{url('plugins/dataTables.bootstrap.css')}}" rel="stylesheet">


