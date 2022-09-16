<footer class="w3l-footer9">
    <section class="footer-inner-main py-5">
        <div class="container py-md-3">
            <div class="right-side">
                <div class="row footer-hny-grids sub-columns">
                    <div class="col-lg-12 sub-one-left pe-lg-12">
                        <h6>About </h6>
                        <p class="footer-phny pe-lg-3">Lorem ipsum viverra feugiat. Pellen tesque libero ut justo, ultrices in ligula. Semper at tempufddfel.Lorem ipsum dolor sit,l.Lorem ipsum dolor sit, amet consectetur elit. </p>
                        <div class="columns-2 mt-lg-5 mt-4">
                            <ul class="social">
                                <li><a href="#facebook"><span class="fab fa-facebook-f"></span></a>
                                </li>
                                <li><a href="#linkedin"><span class="fab fa-linkedin-in"></span></a>
                                </li>
                                <li><a href="#twitter"><span class="fab fa-twitter"></span></a>
                                </li>
                                <li><a href="#google"><span class="fab fa-google-plus-g"></span></a>
                                </li>

                            </ul>
                        </div>
                    </div>
 

                </div>
            </div>
            <div class="below-section mt-5">
                <div class="copyright-footer">
                    <div class="columns text-left">
                        <p>© 2021 Construe. All rights reserved | Designed by <a href="https://w3layouts.com" target="_blank">W3layouts</a>
                        </p>
                    </div>
                    <ul class="footer-w3list text-right">
                        <li><a href="#url">Privacy Policy</a>
                        </li>
                        <li><a href="#url">Terms &amp; Conditions</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Js scripts -->
    <!-- move top -->
    <button onclick="topFunction()" id="movetop" title="Go to top">
        <span class="fas fa-level-up-alt" aria-hidden="true"></span>
    </button>
    <script>
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("movetop").style.display = "block";
            } else {
                document.getElementById("movetop").style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

    </script>
    <!-- //move top -->
</footer>
<!--//footer-9 -->

<!-- Template JavaScript -->
<script src="{{url('assets/js/jquery-3.3.1.min.js')}}"></script>
<script src="https://kit.fontawesome.com/fccf0b41ac.js" crossorigin="anonymous"></script>
<script src="{{url('assets/js/theme-change.js')}}"></script>
<!-- MENU-JS -->
<script>
    $(window).on("scroll", function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 80) {
            $("#site-header").addClass("nav-fixed");
        } else {
            $("#site-header").removeClass("nav-fixed");
        }
    });

    //Main navigation Active Class Add Remove
    $(".navbar-toggler").on("click", function() {
        $("header").toggleClass("active");
    });
    $(document).on("ready", function() {
        if ($(window).width() > 991) {
            $("header").removeClass("active");
        }
        $(window).on("resize", function() {
            if ($(window).width() > 991) {
                $("header").removeClass("active");
            }
        });
    });

</script>
<!-- //MENU-JS -->

<!-- disable body scroll which navbar is in active -->
<script>
    $(function() {
        $('.navbar-toggler').click(function() {
            $('body').toggleClass('noscroll');
        })
    });

</script>
<!-- //disable body scroll which navbar is in active -->
<!-- //bootstrap -->
<script src="{{url('assets/js/bootstrap.min.js')}}"></script>
