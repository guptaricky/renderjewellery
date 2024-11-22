<x-guest-layout>
    <body class="hold-transition lockscreen">
        <!-- Automatic element centering -->
        <div class="lockscreen-wrapper">
          <div class="lockscreen-logo">
            <a href="../../index2.html">Forgot Password</a>
          </div>
         
          <div class="help-block text-center mb-5">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}  
          </div>
          <div class="lockscreen-item bg-secondary-subtle">
            <form method="POST" action="{{ route('password.email') }}">
            @csrf
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Email">
              </div>
              <div class="input-group d-flex flex-column align-items-center"> 
                <button type="submit" class="btn btn-block btn-dark mt-3">Email Password Link</button>
                <a href="{{ route('login') }}"><button type="button" class="btn btn-block btn-primary mt-3 ">Back to Login Page</button></a>
              </div>
            </form>
          </div>
        </div>
        <!-- /.center -->
        </body>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

</x-guest-layout>
