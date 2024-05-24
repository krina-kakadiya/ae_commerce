
<header class="header mb-5">

      <div id="top">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 offer mb-3 mb-lg-0"></div>
            <div class="col-lg-6 text-center text-lg-right">
              <ul class="menu list-inline mb-0">
                @if (Auth::guard('user')->check())
                <li class="list-inline-item">
                <div class="dropdown">
                  <button class="btn btn-info dropdown-toggle"  type="button" data-toggle="dropdown" aria-expanded="false">
                    Hello  {{ Auth::guard('user')->user()->name }}
                  </button>
                  <ul class="dropdown-menu" style="background: black;">
                    <li><a class="dropdown-item" href="{{ route('user.profile.view')}}">Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.order')}}">My Orders</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
                  </ul>
                </div>
                </li>
                @else
                <li class="list-inline-item"><a href="#" data-toggle="modal" data-target="#login-modal">Login</a></li>
                <li class="list-inline-item"><a href="{{ route('user.register')}}">Register</a></li>
                @endif
              </ul>
            </div>
          </div>
        </div>
        <div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true" class="modal fade">
          <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 389px;height: 377px;margin-top: 200px;">
              <div class="modal-header">
                <h5 class="modal-title">Customer login</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body">
                  <form method="post" action="{{ route('user.login')}}" id="userLoginForm">
                    @csrf
                    <br>
                  <div class="form-group">
                    <label for="name"> Email : </label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="email" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="name"> Password : </label>
                    <input type="password" name="password" id="password" class="form-control  @error('password') is-invalid @enderror" placeholder="password" required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <p class="text-center">
                    <button class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
                  </p>
                </form>
                <p class="text-center text-muted">Not registered yet? <a href="{{ route('user.register')}}"><strong>Register now</strong></a></p>
              </div>
            </div>
          </div>
        </div>
        <!-- *** TOP BAR END ***-->
        
        
      </div>
      <nav class="navbar navbar-expand-lg">
        <div class="container"><a href="{{ route('user.home') }}" class="navbar-brand home"><img src="{{ asset('user/img/ecom.png') }}" alt="Obaju logo" class="d-none d-md-inline-block" height="100" width="120"><img src="{{ asset('user/img/ecom.png') }}" alt="Obaju logo" class="d-inline-block d-md-none"><span class="sr-only">Obaju - go to homepage</span></a>
          <div class="navbar-buttons">
            <button type="button" data-toggle="collapse" data-target="#navigation" class="btn btn-outline-secondary navbar-toggler"><span class="sr-only">Toggle navigation</span><i class="fa fa-align-justify"></i></button>
            <button type="button" data-toggle="collapse" data-target="#search" class="btn btn-outline-secondary navbar-toggler"><span class="sr-only">Toggle search</span><i class="fa fa-search"></i></button><a href="basket.html" class="btn btn-outline-secondary navbar-toggler"><i class="fa fa-shopping-cart"></i></a>
          </div>
          <div id="navigation" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item"><a href="{{ route('user.home') }}" class="nav-link active">Home</a></li>
              <li class="nav-item dropdown"><a href="#" data-toggle="dropdown" data-hover="dropdown" data-delay="200" class="dropdown-toggle nav-link">Category<b class="caret"></b></a>
                <ul class="dropdown-menu megamenu">

                  @php
                  $allCategoryData = App\Models\Category::where('category_status', 0)->get();
                  @endphp
                  @foreach ($allCategoryData as $item)
                  {{-- <a class="dropdown-item" href="{{ route('user.category.view',$item->id )}}">{{ $item->category_name }}</a> --}}
                    <li class="nav-item"><a href="{{ route('user.category.view',$item->id) }}" class="nav-link">{{ $item->category_name }}</a></li>
                  @endforeach
                </ul>
              </li>
            </ul>
            <div class="navbar-buttons d-flex justify-content-end">
              <!-- /.nav-collapse-->
              <div id="search-not-mobile" class="navbar-collapse collapse"></div>
              {{-- <a data-toggle="collapse" href="#search" class="btn navbar-btn btn-primary d-none d-lg-inline-block">
                <span class="sr-only">Toggle search</span>
                <i class="fa fa-search"></i>
              </a> --}}
              <div id="basket-overview" class="navbar-collapse collapse d-none d-lg-block">
                <a href="{{ route('user.cart') }}" class="btn btn-primary navbar-btn"><i class="fa fa-shopping-cart"></i>
                  <span>
                    @if(session('cart'))
                      @php
                        $cart = count(session('cart')); 
                        echo $cart;
                      @endphp
                    @else
                      {{ "0" }}
                    @endif
                     items in cart
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>
      {{-- <div id="search" class="collapse">
        <div class="container">
          <form role="search" class="ml-auto">
            <div class="input-group">
              <input type="text" placeholder="Search" class="form-control">
              <div class="input-group-append">
                <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </form>
        </div>
      </div> --}}
    </header>

