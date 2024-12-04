<x-app-layout>
    

    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Profile Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">User Details </li>
                  
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
      
                      <h3 class="profile-username text-center"> {{ ucwords($user->name) }}</h3>
      
                      <p class="text-muted text-center">{{ $user->email }}</p>
      
                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                          <b>Role</b> <a class="float-right">
                            @foreach($user->roles as $role)
                              {{ $role->name }}
                            @endforeach
                          </a>
                        </li>
                        <li class="list-group-item">
                          <b>Plan</b> <a class="float-right">@if($user->plan != null)
                                        {{ $user->plan['name']}}
                                        @else NA @endif</a>
                        </li>
                        <li class="list-group-item">
                          <b>Uploads</b> <a class="float-right">{{ $design_count}}</a>
                        </li>
                      </ul>
      
                      
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
                      </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                          <!-- The timeline -->
                          <div class="timeline timeline-inverse">
                            @foreach($uploaded_designes as $index => $uploaded_designe)
                            <!-- timeline time label -->
                            <div class="time-label">
                              <span class="bg-danger">
                                {{ date("d M Y",strtotime($uploaded_designe['created_at'])) }}
                              </span>
                            </div>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                           
                            @if ( isset($uploaded_designe['order_number']) )
                            <div>
                              <i class="fas fa-credit-card bg-purple"></i>
      
                              <div class="timeline-item">
                                <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
      
                                <h3 class="timeline-header"><a href="#">Purchased</a> a Design</h3>

                                <div class="timeline-body">


                                  <h5 class="mt-4 mb-2">Description</h5>
                                  {{ $uploaded_designe['order_number'] }}
                                  
                                </div>
                             
                              </div>
                            </div>
                            
                            @else
                            <div>
                              <i class="fas fa-camera bg-purple"></i>
      
                              <div class="timeline-item">
                                <span class="time"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($uploaded_designe['created_at'])->setTimezone('Asia/Kolkata')->format('H:i a') }}</span>
      
                                <h3 class="timeline-header"><a href="#">Uploaded</a> a new Design</h3>
      
                                <div class="timeline-body">

                                  <div class="card card-primary">

                                    <div class="card-header">
                                      <h4 class="card-title">{{ $uploaded_designe['title'] }}</h4>
                                    </div>

                                    <div class="card-body">
                                      <div>
                                        <div class="filter-container p-0 row">
                                          @foreach ($uploaded_designe['productdesign'] as $design)
                                            <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                                              <a href="{{ Vite::asset('storage/app/public/').$design['file_path'] }}" data-toggle="lightbox" data-title="sample 1 - white">
                                                <img class="img-fluid mb-3" src="{{ Vite::asset('storage/app/public/').$design['file_path'] }}" class="img-fluid mb-2" alt="white sample">
                                              </a>
                                            </div>
                                          @endforeach
                                        </div>
                                      </div>
                                    </div>

                                  </div>

                                  <h5 class="mt-4 mb-2">Description</h5>
                                  {{ $uploaded_designe['description'] }}

                                  <p class="mt-4">
                                    <a href="#" class="link-black text-sm mr-2"><i class="fas fa-tag mr-1"></i> Price: {{ $uploaded_designe['category_id'] }}</a>
                                    <a href="#" class="link-black text-sm mr-2"><i class="fas fa-users-class mr-1"></i> Category: {{ $uploaded_designe['category_id'] }}</a>
                                    <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Code: {{ $uploaded_designe['subcategory_id'] }}</a>
                                    <span class="float-right">
                                      <a href="#" class="link-black text-sm">
                                        <i class="far fa-comments mr-1"></i> Designed By :  {{ $uploaded_designe['designer_name'] }}
                                      </a>
                                    </span>
                                  </p>
                                  
                                </div>
                                {{-- <div class="timeline-footer">
                                  <a href="{{ route('user.designDetails', ['id' => $user->id,'upload_id' => $uploaded_designe->id]) }}" class="btn btn-primary btn-sm">
                                    View All
                                  </a>
                                </div> --}}
                                
                              </div>
                              
                            </div>
                            @endif
                            <!-- END timeline item -->
                            @endforeach
                            <div>
                              <i class="far fa-clock bg-gray"></i>
                            </div>
                          </div>
      
      
                        </div>
                       
                        
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
      <script>
        $(function () {
          $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
              alwaysShowClose: true
            });
          });
      
          $('.filter-container').filterizr({gutterPixels: 3});
          $('.btn[data-filter]').on('click', function() {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
          });
        })
      </script>
</x-app-layout>
