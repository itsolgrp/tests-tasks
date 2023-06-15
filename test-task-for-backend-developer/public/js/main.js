(function ($) {
    $(document).ready(function() {

        $('.btn-expand-collapse').click(function(e) {
            $('#desktop-menu').toggleClass('collapsed');
        });

        touchSideSwipe = new TouchSideSwipe({
            // container element
            elementID: 'sidebar',
    
            elementWidth: 260, //px
    
            elementMaxWidth: 0.75,
    
            // animation speed in seconds
            moveSpeed: 0.4,
    
            // opacity of background
            opacityBackground: 0.4,
    
            sideHookWidth: 20
        });

        $('#sidebarCollapse').click(function (e) {
            touchSideSwipe.tssOpen();
        });

        $('.mobile-menu-link').click(function(e) {
            $(this).next('.collapse').collapse('toggle');
        });
        
        
        $.each( $('.submenu-link') , function(i, v) {
            if($(v).hasClass('active')) {
               $(v).parent().collapse('show');
            }
        });

        $.each( $('.mobile-submenu-link') , function(i, v) {
            if($(v).hasClass('active')) {
               $(v).parent().collapse('show');
            }
        });
        /*
        $('.overlay').on('click', function () {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');      
        });
        */

    });
})(jQuery);





