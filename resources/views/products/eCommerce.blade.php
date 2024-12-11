<x-app-layout>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add to cart</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none">{{ $products['title']}}</h3>
              <div class="col-12">
                @if (!empty($products['productdesign']) && isset($products['productdesign'][0]))
                    <img src="{{ Vite::asset('storage/app/public/' . $products['productdesign'][0]['file_path']) }}" class="product-image" alt="Product Image">
                @endif
              </div>
              <div class="col-12 product-image-thumbs">
                @foreach ($products['productdesign'] as $design)
                  <div class="product-image-thumb active"><img src="{{ Vite::asset('storage/app/public/').$design['file_path'] }}" alt="Product Image"></div>
                @endforeach
              </div>
            </div>
            
            <div class="col-12 col-sm-6">
              <h3 class="my-3">{{ $products['title']}}</h3>
              <p>{{ $products['short_description'] }}</p>

              <hr>
              <div class="row">
                <div class="col-12 col-sm-7">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-text-width"></i>
                        3D Model Formats
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
                <div class="col-12 col-sm-5">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-text-width"></i>
                        3D Model Details
                      </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <ul class="nav flex-column">
                        <li class="nav-item">
                          <span class="nav-link">
                            Publish Date <span class="float-right text-muted"><strong>{{ $products['created_at']}}</strong></span>
                          </span>
                        </li>
                        <li class="nav-item">
                          <span class="nav-link">
                            Model ID <span class="float-right text-muted"><strong>{{ strtoupper($products['product_code'])}}</strong></span>
                          </span>
                        </li>
                        <li class="nav-item">
                          <span class="nav-link">
                            Ready for 3D Printing <span class="float-right text-muted"><strong><i class="fas fa-check-circle text-success"></i></strong></span>
                          </span>
                        </li>
                      </ul>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
              </div>
              

              

              <div class="bg-green py-2 px-3 mt-4">
                <h2 class="mb-0">
                  &#8377;{{ $products['price']}}
                </h2>
                <h4 class="mt-0">
                  <small>GST: &#8377;80.00 </small>
                </h4>
              </div>

              <div class="mt-4">
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div>
                    <input type="hidden" id="product-id" value={{ $products['id']}}> <!-- Replace 123 with the actual product ID -->
                    <input type="hidden" id="quantity" value="1" min="1" class="form-control" placeholder="Enter quantity">
                </div>
                <div class="btn btn-primary btn-lg btn-flat" id="add-to-cart-btn">
                  <i class="fas fa-cart-plus fa-lg mr-2"></i>
                  Add to Cart
                </div>

                <div class="btn btn-default btn-lg btn-flat">
                  <i class="fas fa-heart fa-lg mr-2"></i>
                  Add to Wishlist
                </div>
              </div>

              <div class="mt-4 product-share">
                <a href="#" class="text-gray">
                  <i class="fab fa-facebook-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fab fa-twitter-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fas fa-envelope-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fas fa-rss-square fa-2x"></i>
                </a>
              </div>

            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">Comments</a>
                <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Rating</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">{{ $products['description'] }} </div>
              <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab"> Vivamus rhoncus nisl sed venenatis luctus. Sed condimentum risus ut tortor feugiat laoreet. Suspendisse potenti. Donec et finibus sem, ut commodo lectus. Cras eget neque dignissim, placerat orci interdum, venenatis odio. Nulla turpis elit, consequat eu eros ac, consectetur fringilla urna. Duis gravida ex pulvinar mauris ornare, eget porttitor enim vulputate. Mauris hendrerit, massa nec aliquam cursus, ex elit euismod lorem, vehicula rhoncus nisl dui sit amet eros. Nulla turpis lorem, dignissim a sapien eget, ultrices venenatis dolor. Curabitur vel turpis at magna elementum hendrerit vel id dui. Curabitur a ex ullamcorper, ornare velit vel, tincidunt ipsum. </div>
              <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab"> Cras ut ipsum ornare, aliquam ipsum non, posuere elit. In hac habitasse platea dictumst. Aenean elementum leo augue, id fermentum risus efficitur vel. Nulla iaculis malesuada scelerisque. Praesent vel ipsum felis. Ut molestie, purus aliquam placerat sollicitudin, mi ligula euismod neque, non bibendum nibh neque et erat. Etiam dignissim aliquam ligula, aliquet feugiat nibh rhoncus ut. Aliquam efficitur lacinia lacinia. Morbi ac molestie lectus, vitae hendrerit nisl. Nullam metus odio, malesuada in vehicula at, consectetur nec justo. Quisque suscipit odio velit, at accumsan urna vestibulum a. Proin dictum, urna ut varius consectetur, sapien justo porta lectus, at mollis nisi orci et nulla. Donec pellentesque tortor vel nisl commodo ullamcorper. Donec varius massa at semper posuere. Integer finibus orci vitae vehicula placerat. </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


</x-app-layout>
