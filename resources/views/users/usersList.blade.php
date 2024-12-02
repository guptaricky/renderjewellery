<x-app-layout>
    <div class="wrapper">
        <div class="content-wrapper">
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
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Users List</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- Filter and Search Form (single line) -->
                                <form method="GET" action="{{ route('user.list') }}">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <!-- Search Input -->
                                            <div class="form-group col-md-4">
                                                <label for="searchtext">Search:</label>
                                                <input type="text" class="form-control" id="searchtext" name="searchtext" value="{{ old('searchtext', $searchtext) }}" placeholder="Search by name or email">
                                            </div>

                                            <!-- Filter by Role -->
                                            <div class="form-group col-md-4">
                                                <label for="role">Filter by Role:</label>
                                                <select class="form-control" id="role" name="role">
                                                    <option value="">All Roles</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->name }}" {{ $role->name == $roleFilter ? 'selected' : '' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="form-group col-md-4 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- /.form -->

                                <!-- Success Message -->
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

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
                                                            {{ $user->plan['name'] }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ route('user.details', ['id' => $user->id]) }}">
                                                        <button type="button" class="btn btn-sm btn-outline-info">View Details</button>
                                                    </a></td>
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
