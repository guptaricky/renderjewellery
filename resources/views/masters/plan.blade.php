<x-app-layout>
    

    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Plans</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Plans</li>
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
                  <!-- left column -->
                  <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-warning">
                      <div class="card-header">
                        <h3 class="card-title">Create New Plan</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      <form method="POST" action="{{ route('plan.store') }}">
                        @csrf
                      <div class="card-body">
                        
                          <div class="row">
                            <div class="col-sm-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Plan Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Plan Name...">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control" placeholder="Enter Code..." >
                              </div>
                            </div>
                          </div>
                        
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </form>
                    </div>
                    <!-- /.card -->
                  </div>
                  <!--/.col (left) -->
                  <!-- right column -->
                  <div class="col-md-6">
                    <!-- general form elements disabled -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Plan List</h3>
                      </div>
                      <!-- /.card-header -->
                      
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Plan</th>
                                    <th>In Use</th>
                                    <th>% use</th>
                                    <th>code</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($plans as $index => $plan)
                                  <tr>
                                    <td>{{ $index + 1 }}.</td>
                                    <td>{{ $plan->name }}</td>
                                    <td>
                                      <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                      </div>
                                    </td>
                                    <td><span class="badge bg-danger">55%</span></td>
                                    <td>{{ $plan->code }}</td>
                                  </tr>
                                @endforeach
                                </tbody>
                              </table>
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
