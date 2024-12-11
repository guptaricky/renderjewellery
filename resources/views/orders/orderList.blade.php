<x-app-layout>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Orders</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Orders</li>
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
                                    <h3 class="card-title">Order List</h3>
                                </div>
                                <!-- /.card-header -->

                                

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
                                                <th>Order No.</th>
                                                <th>Order By</th>
                                                <th>Status</th>
                                                <th>Amount (&#8377;)</th>
                                                <th>Payment Status</th>
                                                <th>Payment Mode</th>
                                                <th>Order Date/Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $index => $order)
                                                <tr>
                                                    <td>{{ $index + 1 }}.</td>
                                                    <td>{{ $order->order_number }}</td>
                                                    <td>
                                                        @if($order->user != null)
                                                            {{ $order->user['name'] }}
                                                        @endif</td>
                                                    <td>{{ $order->status }}</td>
                                                    <td>{{ $order->final_total }}</td>
                                                    <td>{{ $order->payment_status }}</td>
                                                    <td>{{ $order->payment_method }}</td>
                                                    <td>{{ $order->created_at }}</td>
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
