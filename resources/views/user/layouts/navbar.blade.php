

    @php
        use App\Http\Controllers\UserController;
        $user=UserController::user();

        if(session('userId')){
            $name=explode(' ',$user[0]);

        }
 
           
    @endphp

    <!--/Header-->
    <header id="site-header" class="bg-dark ">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light stroke py-lg-0">
                <h1><a class="navbar-brand pe-xl-5 pe-lg-4" href="index.html">
                    Construe
                    
                </a></h1>

      
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
                    <span class="navbar-toggler-icon fa icon-close fa-times"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{url('home')}}"><button class="btn btn-dark">Home</button></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><button class="btn btn-dark">About</button></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><button class="btn btn-dark">Contact</button></a>
                        </li>

                    </ul>
                    
                    <ul class="navbar-nav">
                        @if(!session('userId'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('user-login')}}"><button class="btn btn-dark">Login</button></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('user-register')}}"><button class="btn btn-dark">Register</button></a>
                        </li>
                        @else

                        <li class="nav-item">
                            <a class="nav-link" href="{{url('user-logout')}}"><button class="btn btn-dark">Logout</button></a>
                        </li>
                        <li class="nav-item">
                          <h4 class="nav-item text-white mt-3">Hi,{{ucfirst($name[0])}}</h4>
                        </li>


                        @endif

            


                    </ul>
                        

              
                    <!--/search-right-->
                    {{-- <ul class="header-search mx-lg-4">
                        <div class="w3hny-search">
                            <form action="#" method="GET" class="d-flex search-form">
                                <input class="form-control" type="search" placeholder="Search..." aria-label="Search" required="">
                                <button class="btn btn-style btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </ul> --}}
                    <!--//search-right-->
                </div>
                <!-- toggle switch for light and dark theme -->
                <div class="mobile-position">
                    <nav class="navigation">
                        <div class="theme-switch-wrapper">
                         @if(!session('userId'))
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('owner-login')}}"><button class="btn btn-dark">Login as Owner</button></a>
                                </li>

                            </ul>
                            @endif
                            <label class="theme-switch" for="checkbox">
                                {{-- <input type="checkbox" id="checkbox">
                                <div class="mode-container">
                                    <i class="gg-sun"></i>
                                    <i class="gg-moon"></i>
                                </div> --}}
                           <a href="{{url('user-cart')}}"><button class="btn btn-danger"> <i class="fa-solid fa-cart-shopping"></i> <span>@if(session('cart')){{count(session('cart'))}} @endif</span> </button></a>
                           <a href="{{url('my-order')}}"> <button class="btn btn-danger">My Orders</button> </a> 
                            </label>
                        </div>
                    </nav>
                </div>

                <!-- //toggle switch for light and dark theme -->
            </nav>
        </div>
    </header>