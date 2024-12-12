<x-app-layout>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Products</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Products</li>
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
                                    <h3 class="card-title">Product List</h3>
                                </div>
                                <!-- /.card-header -->



                                <!-- Success Message -->
                                @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif

                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Product</th>
                                                <th>Code</th>
                                                <th>Created By</th>
                                                <th>Content</th>
                                                <th>Price (&#8377;)</th>
                                                <th>Status</th>
                                                <th>Designer</th>
                                                <th>Created on</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $index => $product)
                                          <tr data-widget="expandable-table" aria-expanded="false">
                                                <td>{{ $index + 1 }}.</td>
                                                <td>{{ ucwords($product->title) }}</td>
                                                <td>{{ "{$product->product_code}-{$product->category->code}-{$product->subcategory->code}" }}</td>
                                                <td>
                                                    @if($product->users != null)
                                                    {{ ucwords($product->users['name']) }}
                                                    @endif
                                                </td>
                                                <td>{{ $product->design_count }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>
                                                    @if ($product->status == 1)
                                                    <span class="badge badge-primary">Pending</span>
                                                    @elseif ($product->status == 2)
                                                    <span class="badge badge-success">Approved</span>
                                                    @else
                                                    <span class="badge badge-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>{{ ucwords($product->designer_name) }}</td>
                                                <td>{{ date('Y-m-d',strtotime($product->created_at)) }}</td>
                                                <td>
                                                    <a href="{{ route('products.detail',[$product->id]) }}" class="text-muted">
                                                        <button type="button" class="btn btn-sm btn-outline-info">View More</button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="expandable-body">
                                                <td colspan="10">
                                                    <h4 class="p-3">Description</h4>
                                                <p>
                                                    {{ $product->description }}
                                                </p>
                                                </td>
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