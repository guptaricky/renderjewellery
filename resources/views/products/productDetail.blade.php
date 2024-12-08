<x-app-layout>
    
    <style>
        .carousel {
  position: relative;
  max-width: 600px;
  margin: auto;
  overflow: hidden;
}

.carousel-slides {
  display: flex;
  transition: transform 0.5s ease-in-out;
}

.carousel img {
  width: 100%;
  display: block;
}

.prev, .next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  cursor: pointer;
  padding: 10px;
}

.prev {
  left: 10px;
}

.next {
  right: 10px;
}

.active {
  opacity: 1;
}

.carousel img:not(.active) {
  opacity: 0;
}
    </style>
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Profile Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">User Details </li>
                  
                  </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->
      
          <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Projects Detail</h3>
          </div>
          {{-- {{$products}} --}}
          {{-- @foreach ($products as $product) --}}
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                      <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Product Price</span>
                        <span class="info-box-number text-center text-muted mb-0">{{ $products->price }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                      <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Total Sales</span>
                        <span class="info-box-number text-center text-muted mb-0">2000</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                      <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Designed By</span>
                        <span class="info-box-number text-center text-muted mb-0">{{ $products->designer_name }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                      <div class="post">
                        <div class="carousel">
                            <button class="prev" onclick="prevSlide()">&#10094;</button>
                            <div class="carousel-slides">
                                @foreach ($products->productdesign as $design)
                                    <img src="{{ Vite::asset('storage/app/public/').$design['file_path'] }}" class="img-fluid mb-2 active" alt="black sample">
                                @endforeach
                            </div>
                            <button class="next" onclick="nextSlide()">&#10095;</button>
                          </div>
                      </div>
  
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                <h3 class="text-primary"> Description</h3>
                <p class="text-muted">{{ substr($products->description,0,300) }}...</p>
                <br>
                <div class="text-muted">
                  <p class="text-sm">Designed By
                    <b class="d-block">{{ $products->designer_name }}</b>
                  </p>
                  <p class="text-sm">Category
                    <b class="d-block">Necklace</b>
                  </p>
                </div>
  
                <h5 class="mt-5 text-muted">Product files</h5>
                <ul class="list-unstyled">
                    @foreach ($products->productdesign as $design)
                        <li>
                            <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> {{ $design['file_name']}}</a>
                        </li>
                    @endforeach
                 
                </ul>
                {{-- <div class="text-center mt-5 mb-3">
                  <a href="#" class="btn btn-sm btn-primary">Add files</a>
                  <a href="#" class="btn btn-sm btn-warning">Report contact</a>
                </div> --}}
              </div>
            </div>
          </div>
          {{-- @endforeach --}}
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
        </div>
       
      </div>
    <script>
        let currentIndex = 0;

        function showSlide(index) {
        const slides = document.querySelectorAll('.carousel-slides img');
        const totalSlides = slides.length;

        // Wrap index to handle edge cases
        if (index < 0) {
            currentIndex = totalSlides - 1;
        } else if (index >= totalSlides) {
            currentIndex = 0;
        } else {
            currentIndex = index;
        }

        // Update slides
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === currentIndex);
        });

        const offset = -currentIndex * 100; // Move by 100% of the width
        document.querySelector('.carousel-slides').style.transform = `translateX(${offset}%)`;
        }

        function nextSlide() {
        showSlide(currentIndex + 1);
        }

        function prevSlide() {
        showSlide(currentIndex - 1);
        }

        // Initialize the first slide
        showSlide(0);
    </script>
</x-app-layout>
