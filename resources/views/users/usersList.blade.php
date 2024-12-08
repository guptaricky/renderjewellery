<x-app-layout>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Manage Users</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Users</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Users List</h3>
                                </div>

                                <!-- Filter and Search Form -->
                                <form method="GET" action="{{ route('user.list') }}">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <!-- Search Input -->
                                            <div class="form-group col-md-4">
                                                <label for="searchtext">Search:</label>
                                                <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="Search by name or email">
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

                                            <!-- Filter by Plan -->
                                            <div class="form-group col-md-3">
                                                <label for="plan">Filter by Plan:</label>
                                                <select class="form-control" id="plan" name="plan">
                                                    <option value="">All Plans</option>
                                                    @foreach($plans as $plan)
                                                    <option value="{{ $plan->name }}" {{ $plan->name == $planFilter ? 'selected' : '' }}>{{ $plan->name }}</option>
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

                                <!-- Success Message -->
                                @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif

                                <!-- Search Results -->
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
                                        <tbody id="user-table-body">
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
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Dynamic Search Script -->
    <script>
        document.getElementById('searchtext').addEventListener('input', function() {
            const searchText = this.value;
            const roleFilter = document.getElementById('role').value;
            const planFilter = document.getElementById('plan').value;

            fetch(`{{ route('user.search') }}?searchtext=${encodeURIComponent(searchText)}&role=${encodeURIComponent(roleFilter)}&plan=${encodeURIComponent(planFilter)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('user-table-body');
                    tbody.innerHTML = ''; // Clear the table body

                    if (data.users.length > 0) {
                        data.users.forEach((user, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${index + 1}.</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.roles.map(role => role.name).join(', ')}</td>
                        <td>${user.plan ? user.plan.name : 'NA'}</td>
                        <td>
                            <a href="/users/${user.id}" class="btn btn-sm btn-outline-info">View Details</a>
                        </td>
                    `;
                            tbody.appendChild(row);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No users found.</td></tr>';
                    }
                })
                .catch(error => console.error('Error fetching users:', error));

        });
    </script>
</x-app-layout>