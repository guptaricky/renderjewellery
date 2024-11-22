<x-app-layout>
    

    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Manage Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
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
                        <h3 class="card-title">Users List</h3>
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
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Plan</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $index => $user)
                               
                                  <tr>
                                    <td>{{ $index + 1 }}.</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            {{ $role->name }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($user->plan != null)
                                        {{ $user->plan['name']}}
                                        @else NA @endif
                                    </td>
                                    <td><button type="button" class="btn btn-sm btn-outline-info btn-sm">Manage Profile</button></td>   
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
