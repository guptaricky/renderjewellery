<x-app-layout>
  
  <div class="wrapper">
    <div class="content-wrapper">
      <!-- Page Header -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-7">
              <h1 class="m-0"><b>{{ $products->title }}</b></h1>
            </div>
            <div class="col-sm-5">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Details</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <section class="content">
        <div class="card">
          <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif
            <div class="row">
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-gradient-info">
                  <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Sales</span>
                    <span class="info-box-number">41,410</span>
    
                    <div class="progress">
                      <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                      70% Increase in 30 Days
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-gradient-success">
                  <span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Expected Price</span>
                    <span class="info-box-number">{{ $products->price }}</span>
    
                    <div class="progress">
                      <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                      70% Increase in 30 Days
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-gradient-danger">
                  <span class="info-box-icon"><i class="fas fa-comments"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Comments</span>
                    <span class="info-box-number">41,410</span>
    
                    <div class="progress">
                      <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                      70% Increase in 30 Days
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-gradient-warning">
                  <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Likes</span>
                    <span class="info-box-number">41,410</span>
    
                    <div class="progress">
                      <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                      70% Increase in 30 Days
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              
            </div>
            <div class="row">
              <!-- Product Details Section -->
              <div class="col-12 col-md-8">
                <!-- Carousel Section -->
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                          <ol class="carousel-indicators">
                            @foreach ($products->productdesign as $key => $design)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                        @endforeach
                          </ol>
                          <div class="carousel-inner">
                            @foreach ($products->productdesign as $k => $design)
                            <div class="carousel-item {{ $k == 0 ? 'active' : '' }}">
                              <img class="d-block w-100" src="{{ Vite::asset('storage/app/public/' . $design['file_path']) }}" alt="First slide">
                            </div>
                            @endforeach
                          </div>
                          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                              <i class="fas fa-chevron-left"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                              <i class="fas fa-chevron-right"></i>
                            </span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
                </div>
              </div>

              <!-- Sidebar Section -->
              <div class="col-12 col-md-4">
                <h3 class="text-primary">Description</h3>
                <p class="text-muted">{{ substr($products->description, 0, 300) }}...</p>
                <br>
                <p class="text-sm">Status : <b class='text-green'>{{ ucwords($products->statusMsg) }}</b></p>
                <p class="text-sm">Category/Sub-category : <b>{{ ucwords($products->category->name) }}/{{ ucwords($products->subcategory->name) }}</b></p>
                <p class="text-sm">Product Code : <b>{{ strtoupper($products->product_code.$products->category->code.$products->subcategory->code) }}</b></p>

                
                <div class="row">
                  <div class="col-12 col-sm-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="fas fa-text-width"></i>
                          File Formats
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <ul class="nav flex-column">
                          <li class="nav-item">
                            <span class="nav-link">
                              Stereolithography (.stl) (6 files) <span class="float-right text-muted"><strong>31 MB</strong></span>
                            </span>
                          </li>
                          <li class="nav-item">
                            <span class="nav-link">
                              Rhinoceros 3D (.3dm) (6 files) <span class="float-right text-muted"><strong>5 MB</strong></span>
                            </span>
                          </li>
                          <li class="nav-item">
                            <span class="nav-link">
                              OBJ (.obj, .mtl) (12 files) <span class="float-right text-muted"><strong>12 MB</strong></span>
                            </span>
                          </li>
                        </ul>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
                </div>

                {{-- <div class="text-center mt-2 mb-3">
                  @if($products->status != 2)
                  <a href="{{ route('products.approval', ['id' => $products->id, 'status' => 2]) }}" class="btn btn-sm btn-block btn-primary">Approve</a>
                  @endif
                  <a href="{{ route('products.approval',  ['id' => $products->id, 'status' => 3]) }}" class="btn btn-sm btn-block btn-danger">Reject</a>
                </div> --}}
                @if($products->status != 2)
                <button type="button" class="btn btn-sm btn-block btn-primary" id="approve-btn" data-toggle="modal" data-target="#modal-sm" > Approve </button>
                @else
                <button type="button" class="btn btn-sm btn-block btn-primary" id="approve-btn" disabled> Approved </button>
                @endif

                @if($products->status != 3)
                <button type="button" class="btn btn-sm btn-block btn-danger" id="comment-btn" data-toggle="modal" data-target="#modal-lg"> Reject </button>
                @else
                <button type="button" class="btn btn-sm btn-block btn-danger" id="comment-btn" disabled> Rejected </button>
                @endif
              </div>

              <!-- Comment Section -->
              <div class="col-12 mt-4">
                <h4>Recent Activity</h4>

                <!-- Display Comments -->
                <div class="comments-section">
                    @foreach($products->comments as $comment)
                    <div class="comment-box mb-3">
                        <strong>{{ $comment->user->name }}</strong>
                        <p>{{ $comment->comment }}</p>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    @endforeach
                </div>

                <!-- Add Comment Form -->
                <!-- Add Comment Form -->
                <form action="{{ route('products.storeComment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $products->id }}">
                    <div class="form-group">
                        <textarea
                            name="comment"
                            class="form-control @error('comment') is-invalid @enderror"
                            rows="3"
                            placeholder="Add your comment here..."
                            required>{{ old('comment') }}</textarea>
                        @error('comment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </form>
            </div>
            
            </div>
            
          </div>
        </div>
      </section>
    </div>
  </div>
  <div class="modal fade" id="modal-sm">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{ __('Are you sure you want to Approve this Product?') }}
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
          <a href="javascript:void(0);" data-id="{{ $products->id }}" data-status="2" class="btn btn-sm btn-success approve-product">{{ __('Confirm Approve') }}</a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Comments</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
          
            <div class="mt-6 col-md-12">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <textarea id="comment" name="comment" placeholder="{{ __('Comment here...') }}" class="form-control" ></textarea>
            </div>

        
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
          <a href="javascript:void(0);" data-id="{{ $products->id }}" data-status="3" class="btn btn-sm btn-primary comment-on-product">{{ __('Post Comment') }}</a>
        </div>
      </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</x-app-layout>