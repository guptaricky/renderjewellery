<x-app-layout>
  <style>
    /* General carousel styles */
    .carousel {
      position: relative;
      max-width: 600px;
      margin: auto;
      overflow: hidden;
      border-radius: 10px;
    }

    .carousel-slides {
      display: flex;
      transition: transform 0.5s ease-in-out;
    }

    .carousel img {
      width: 100%;
      display: block;
      border-radius: 10px;
    }

    /* Carousel navigation buttons */
    .carousel-controls {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
      z-index: 1;
    }

    .prev,
    .next {
      background-color: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      cursor: pointer;
      padding: 15px;
      border-radius: 50%;
      font-size: 24px;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .prev:hover,
    .next:hover {
      background-color: rgba(0, 0, 0, 0.7);
      transform: scale(1.1);
    }

    /* Action buttons styling */
    .action-buttons {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
      padding-top: 20px;
    }

    .action-buttons button {
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      border-radius: 8px;
      transition: transform 0.2s ease;
    }

    .approve-btn {
      background-color: #28a745;
      color: white;
    }
    .view-btn {
      background-color: #007bff;
      color: white;
    }

    .approve-btn:hover {
      background-color: #218838;
      transform: scale(1.05);
    }
    .view-btn:hover {
      background-color: #007bff;
      transform: scale(1.05);
    }

    .reject-btn {
      background-color: #dc3545;
      color: white;
    }

    .reject-btn:hover {
      background-color: #c82333;
      transform: scale(1.05);
    }

    /* Info box styling */
    .info-box {
      border-radius: 10px;
      margin-bottom: 15px;
      padding: 15px;
      background-color: #f8f9fa;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease;
    }

    .info-box:hover {
      transform: translateY(-5px);
    }

    .info-box .info-box-content {
      text-align: center;
    }

    .info-box .info-box-number {
      font-size: 20px;
      font-weight: bold;
      color: #495057;
    }

    /* General text styles */
    .text-muted {
      color: #6c757d;
    }

    .text-primary {
      color: #007bff;
    }

    /* Breadcrumbs styling */
    .breadcrumb-item a {
      color: #007bff;
      text-decoration: none;
    }

    .breadcrumb-item a:hover {
      text-decoration: underline;
    }
  </style>

  <div class="wrapper">
    <div class="content-wrapper">
      <!-- Page Header -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><b>Product Details</b></h1>
            </div>
            <div class="col-sm-6">
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
              <!-- Product Details Section -->
              <div class="col-12 col-md-8">
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <div class="info-box">
                      <div class="info-box-content">
                        <span class="info-box-text">Expected Price</span>
                        <span class="info-box-number">{{ $products->price }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <div class="info-box">
                      <div class="info-box-content">
                        <span class="info-box-text">Total Sales</span>
                        <span class="info-box-number">2000</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <div class="info-box">
                      <div class="info-box-content">
                        <span class="info-box-text">Designed By</span>
                        <span class="info-box-number">{{ $products->designer_name }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Carousel Section -->
                <div class="row">
                  <div class="col-12">
                    <div class="carousel">
                      <div class="carousel-controls">
                        <button class="prev" onclick="prevSlide()">&#10094;</button>
                        <button class="next" onclick="nextSlide()">&#10095;</button>
                      </div>
                      <div class="carousel-slides">
                        @foreach ($products->productdesign as $design)
                        <img src="{{ Vite::asset('storage/app/public/' . $design['file_path']) }}" class="img-fluid active" alt="Product Image">
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Sidebar Section -->
              <div class="col-12 col-md-4">
                <h3 class="text-primary">Description</h3>
                <p class="text-muted">{{ substr($products->description, 0, 300) }}...</p>
                <br>
                <p class="text-sm">Status <b>{{ $products->statusMsg }}</b></p>
                <p class="text-sm">Category <b>{{ $products->category->name }}</b></p>
                <p class="text-sm">Product Title <b>{{ $products->title }}</b></p>

                <h5 class="mt-5 text-muted">Product Files</h5>
                <ul class="list-unstyled">
                  @foreach ($products->productdesign as $design)
                  <li>
                    <a href="#" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> {{ $design['file_name'] }}</a>
                  </li>
                  @endforeach
                </ul>

                <!-- Action Buttons -->
                <div class="action-buttons">

                  @if($products->status != 1)
                  <a href="{{ route('products.approval', ['id' => $products->id, 'status' => 1]) }}">
                    <button type="button" class="approve-btn">Approve</button>
                  </a>
                  @endif
                  <a href="{{ route('products.approval',  ['id' => $products->id, 'status' => 3]) }}">
                    <button type="button" class="reject-btn">Reject</button>
                  </a>
                  <!-- @if($products->status == 1)
                  <a href="{{ route('products.approval',  ['id' => $products->id, 'status' => 3]) }}">
                    <button type="button" class="view-btn">view comments</button>
                  </a>
                  @endif -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <script>
    let currentIndex = 0;

    function showSlide(index) {
      const slides = document.querySelectorAll('.carousel-slides img');
      const totalSlides = slides.length;

      if (index < 0) {
        currentIndex = totalSlides - 1;
      } else if (index >= totalSlides) {
        currentIndex = 0;
      } else {
        currentIndex = index;
      }

      slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === currentIndex);
      });

      const offset = -currentIndex * 100;
      document.querySelector('.carousel-slides').style.transform = `translateX(${offset}%)`;
    }

    function nextSlide() {
      showSlide(currentIndex + 1);
    }

    function prevSlide() {
      showSlide(currentIndex - 1);
    }

    showSlide(0);
  </script>
</x-app-layout>