<x-app-layout>
    

    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Uploaded Designs</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Uploaded Design</li>
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
                  <!-- right column -->
                  <div class="col-md-12">
                    <!-- general form elements disabled -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Uploaded Design</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <?php //dd($users); ?>
                        <div class="card-body">
                            <div class="post">
                                <div class="user-block">
                                  <img class="img-circle img-bordered-sm" src="{{ Vite::asset('public/dist/img/user6-128x128.jpg')}}" alt="User Image">
                                  <span class="username">
                                    <a href="#">{{ $user->name}}</a>
                                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                  </span>
                                  <span class="description">Posted {{ formatTimestamp($uploaded_designes->created_at) }}</span>
                                </div>
                                <!-- /.user-block -->
                                <div class="row mb-3">
                                 
                                  <div class="col-sm-12">
                                    <div class="row">
                                    @foreach ($designes as $design)
                                      <div class="col-sm-3">
                                        <img class="img-fluid mb-3" src="{{ Vite::asset('storage/app/public/').$design->file_path }}" alt="Photo">
                                      </div>
                                    @endforeach
                                      <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                  </div>
                                  <!-- /.col -->
                                </div>
                                <!-- /.row -->
          
                                
                              </div>
                        </div>
                        <!-- /.card-body -->
                      
                    </div>
                    <!-- /.card -->
                  </div>
                  <!--/.col (right) -->
                </div>
                <!-- /.row -->
              </div>
          </section>
          <!-- /.content -->
        </div>
       
      </div>
</x-app-layout>
