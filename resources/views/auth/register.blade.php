<x-guest-layout>
    <body class="hold-transition register-page">
        <div class="register-box">
          <div class="card card-outline card-primary">
            <div class="card-header text-center">
              <a href="../../index2.html" class="h1"><b>Render</b>Jewellery</a>
            </div>
            <div class="card-body">
              <p class="login-box-msg">Register a new Account</p>
        
              <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="input-group mb-3">
                  <input type="text" name="name" id="name" class="form-control" placeholder="Full name" value="{{old('name')}}" required autofocus autocomplete="name" />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="email" id="email" class="form-control" placeholder="Email" name="email" value="{{old('email')}}" required autocomplete="username" />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" id="password" class="form-control" placeholder="Password"
                  name="password"
                  required autocomplete="new-password" />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" id="password_confirmation" class="form-control" placeholder="Retype password"
                  name="password_confirmation" required autocomplete="new-password" />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8">
                    <div class="icheck-primary">
                      <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                      <label for="agreeTerms">
                       I agree to the <a href="#">terms</a>
                      </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>
        
        
              <a href="{{ route('login') }}" class="text-center">{{ __('I already have a Account') }}</a>
            </div>
            <!-- /.form-box -->
          </div><!-- /.card -->
        </div>
    </body>    
    
</x-guest-layout>
