<x-app-layout>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- Flash Messages -->
        @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
        @endif
        <div class="row">
          <div class="col-lg-12">

            <div class="card">
              
              <div class="card-body table-responsive p-0">
                <table class="table table-striped project">
                  <thead>
                    <tr>
                      <th>SNO.</th>
                      <th>Product Title</th>
                      <th>Designes</th>
                      <th>Price</th>
                      <th>Status</th>
                      <th>Sales</th>
                      <th>Designer</th>
                      <th>Category</th>
                      <th>More</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $index => $product)
                    <tr>
                      <td>
                        {{ $index + 1 }}.
                      </td>
                      <td>
                        {{-- <img src="{{ Vite::asset("public/dist/img/default-150x150.png")}}" alt="Product 1" class="img-circle img-size-32 mr-2"> --}}
                        <a class="lead">{{ $product->title }}</a></br><small>code : <cite title={{ $product->product_code }}>{{ $product->product_code }}</cite></small>
                      </td>
                      <td>
                        @foreach ($product->productdesign as $designes)
                        <img src="{{ Vite::asset('storage/app/public/').$designes['file_path'] }}" class="img-size-32 mr-2">
                        @endforeach
                      </td>
                      <td>(&#8377;){{ $product->price }}</td>
                      <td>
                        @if ($product->status == 1)
                        <span class="badge badge-primary">Pending</span>
                        @elseif ($product->status == 2)
                        <span class="badge badge-success">Approved</span>
                        @else
                        <span class="badge badge-danger">Rejected</span>
                        @endif
                      </td>
                      <td>
                        <small class="text-success mr-1">
                          <i class="fas fa-arrow-up"></i>
                          12%
                        </small>
                        12,000 Sold
                      </td>
                      <td>{{ $product->designer_name }}</td>
                      <td>{{ $product->category->code }}/{{ $product->subcategory->code }}</td>
                      <td>
                        <a href="{{ route('products.eCommerce',[$product->id]) }}" class="text-muted">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</x-app-layout>