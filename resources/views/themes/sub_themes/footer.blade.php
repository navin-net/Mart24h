   <!-- Js Plugins -->
   <script src="{{ asset('themes/js/jquery-3.3.1.min.js') }}"></script>
   <script src="{{ asset('themes/assets/js/bootstrap.min.js') }}"></script>
   <script src="{{ asset('themes/assets/js/tiny-slider.js') }}"></script>
   <script src="{{ asset('themes/assets/js/glightbox.min.js') }}"></script>
   <script src="{{ asset('themes/assets/js/main.js') }}"></script>
   <script type="text/javascript">
     //========= Hero Slider
     tns({
           container: '.hero-slider',
           slideBy: 'page',
           autoplay: true,
           autoplayButtonOutput: false,
           mouseDrag: true,
           gutter: 0,
           items: 1,
           nav: false,
           controls: true,
           controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
       });

       //======== Brand Slider
       tns({
           container: '.brands-logo-carousel',
           autoplay: true,
           autoplayButtonOutput: false,
           mouseDrag: true,
           gutter: 15,
           nav: false,
           controls: false,
           responsive: {
               0: {
                   items: 1,
               },
               540: {
                   items: 3,
               },
               768: {
                   items: 5,
               },
               992: {
                   items: 6,
               }
           }
       });
   </script>
