<x-app-layout>
    

    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                  </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->
      
          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-3">
      
                  <!-- Profile Image -->
                  <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                      <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="../../dist/img/user4-128x128.jpg"
                             alt="User profile picture">
                      </div>
      
                      <h3 class="profile-username text-center">{{ ucwords(Auth::user()->name) }}</h3>
      
                      <p class="text-muted text-center">
                      @foreach($user->roles as $role)
                        {{ $role->name }}
                      @endforeach</p>
      
                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                          <b>Email Id</b> <a class="float-right">{{ Auth::user()->email }}</a>
                        </li>
                        <li class="list-group-item">
                          <b>Products</b> <a class="float-right">543</a>
                        </li>
                        <li class="list-group-item">
                          <b>Purchased</b> <a class="float-right">13,287</a>
                        </li>
                      </ul>
      
                      <a href="#" class="btn btn-primary btn-block"><b>Edit</b></a>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
      
             
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                  <div class="card">
                    <div class="card-header p-2">
                      <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                        <li class="nav-item"><a class="nav-link" href="#changePassword" data-toggle="tab">Change Password</a></li>
                        <li class="nav-item"><a class="nav-link" href="#deleteAccount" data-toggle="tab">Delete Account</a></li>
                      </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                          <!-- The timeline -->
                          Activity will come here...
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="changePassword">
                          
                          Change password form here...
                          
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="deleteAccount">
                          <p>
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                           Before deleting your account, please download any data or information that you wish to retain.
                          </p>
                          <button type="button" class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modal-lg">
                            {{ __('Delete Account') }}
                          </button>

                          
                        </div>
                        <!-- /.tab-pane -->
                        
                      </div>
                      <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          <!-- /.content -->
        </div>
       
      </div>
      <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Account</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
              @csrf
            <div class="modal-body">
              
               
                @method('delete')
    

                <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i> {{ __('Are you sure you want to delete your account?') }}</h5>
                  {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </div>
    
                <div class="mt-6 col-md-4">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    <input id="password" name="password" type="password" placeholder="{{ __('Password') }}" class="form-control" placeholder="Enter Password...">
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
    
            
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
              <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
            </div>
          </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
</x-app-layout>
