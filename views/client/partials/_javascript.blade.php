<!--[if lt IE 9]>
<script src="{{ asset('css/global/plugins/respond.min.js')}}"></script>
<script src="{{ asset('css/global/plugins/excanvas.min.js')}}"></script>
<script src="{{ asset('css/global/plugins/ie8.fix.min.js')}}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('css/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('css/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/amcharts/amcharts/amcharts.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/amcharts/amcharts/serial.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/amcharts/amcharts/pie.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/amcharts/amcharts/radar.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/amcharts/amcharts/themes/light.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/amcharts/amcharts/themes/patterns.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/amcharts/amcharts/themes/chalk.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/amcharts/ammap/ammap.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/amcharts/ammap/maps/js/worldLow.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/amcharts/amstockcharts/amstock.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/horizontal-timeline/horizontal-timeline.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/flot/jquery.flot.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/flot/jquery.flot.resize.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jqvmap/jqvmap/jquery.vmap.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('css/global/scripts/app.min.js')}}" type="text/javascript"></script>

<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('css/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('css/layout2/scripts/layout.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/layout2/scripts/demo.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/layout2/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/layout2/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- END THEME LAYOUT SCRIPTS -->

<script>
    jQuery('#addOcassion').click(function(){
        jQuery('#occasion').slideToggle();
    });
</script>
<script type="text/javascript">
    $('.label-like').on('click', function(){
        var id = $(this).attr('data-id');
        console.log(id);
        $('#label-dislike-'+id).hide();

    });

    $('.label-dislike').on('click', function(){
        var id = $(this).attr('data-id');
        console.log(id);
        $('#label-like-'+id).hide();
    });
</script>
<script>
    $('.dropdown-user').click(function(){
        $(this).toggleClass('open');
    });
    $('.dropdown-tasks').click(function(){
        $(this).toggleClass('open');
    });
    $('#header_notification_bar').click(function(){
        $(this).toggleClass('open');
    })
</script>
<script>
    jQuery('.gender').click(function(e){
        jQuery(e.target).css('background', '#669966');
        jQuery(e.target).siblings().css('background', '#999999');
    });
</script>

<script>
    jQuery('.caption.edit').click(function(){
        $('.caption.edit').hide();
        jQuery(this).parent().parent().find('form').slideToggle();
    });

</script>
<script>
    jQuery("#calendar").datepicker({
        showWeek: true,
        minDate:"+3w",
        onSelect: function(dateText, inst) {
            dateFormat: $.datepicker.iso8601Week(new Date(dateText)),
                $(this).val($.datepicker.iso8601Week(new Date(dateText)));
        }
    });
</script>
<script>

    $('#relativeSelect').on('change', function(){
        var val = $(this).val();
        console.log(val);

        if(val == "Loved one's birthday")
        {
            jQuery('.additional').css('display', 'block');
            jQuery('#relative').attr('value','1');
            $('input[name=genderRelative], input[name=ageRangeRelative]').prop('required', true);
        }
        else if (val == "Daughter's birthday") {
            jQuery('.additional').css('display', 'block');
            jQuery('#relative').attr('value','1');
            $('#input-female').prop('checked', true);
            $('#input-male').prop('checked', false);
            $('#input-female').parent('label').css('background', 'rgb(102, 153, 102)');
            $('#input-male').parent('label').css('background', '#999999');
            $('input[name=genderRelative], input[name=ageRangeRelative]').prop('required', true);
        }
        else if (val == "Son's birthday") {
            jQuery('.additional').css('display', 'block');
            jQuery('#relative').attr('value','1');
            $('#input-male').prop('checked', true);
            $('#input-female').prop('checked', false);
            $('#input-male').parent('label').css('background', 'rgb(102, 153, 102)');
            $('#input-female').parent('label').css('background', '#999999');
            $('input[name=genderRelative], input[name=ageRangeRelative]').prop('required', true);
        }
        else if (val == "Friend's birthday") {
            jQuery('.additional').css('display', 'block');
            jQuery('#relative').attr('value','1');
            $('input[name=genderRelative], input[name=ageRangeRelative]').prop('required', true);
        }else {
            jQuery('.additional').css('display', 'none');
            jQuery('#relative').attr('value','0');
            $('input[name=genderRelative], input[name=ageRangeRelative]').prop('required', false);
        }
    });


    $('.enjoys span ').on('click', function(e){
        console.log($(e.target).text());

    })
</script>