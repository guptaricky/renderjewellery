<x-app-layout>
  <style>
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

    .carousel-controls {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
      z-index: 1;
    }

    .prev, .next {
      background-color: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      cursor: pointer;
      padding: 15px;
      border-radius: 50%;
      font-size: 24px;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .prev:hover, .next:hover {
      background-color: rgba(0, 0, 0, 0.7);
      transform: scale(1.1);
    }

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

    .approve-btn:hover {
      background-color: #218838;
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

    .text-muted {
      color: #6c757d;
    }

    .text-primary {
      color: #007bff;
    }

    .card-body {
      padding: 30px;
    }

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

      <section class="content">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-md-8">
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <div class="info-box">
                      <div class="info-box-content">
                        <span class="info-box-text">Product Price</span>
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
                        <span class="info-box-text">Designed By -> </span>
                        <span class="info-box-number">{{ $products->designer_name }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="carousel">
                      <div class="carousel-controls">
                        <button class="prev" onclick="prevSlide()">&#10094;</button>
                        <button class="next" onclick="nextSlide()">&#10095;</button>
                      </div>
                      <div class="carousel-slides">
                        @foreach ($products->productdesign as $design)
                        <img src="{{ Vite::asset('storage/app/public/').$design['file_path'] }}" class="img-fluid active" alt="Product Image">
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-md-4">
                <h3 class="text-primary">Description</h3>
                <p class="text-muted">{{ substr($products->description, 0, 300) }}...</p>
                <br>
                <p class="text-sm">Designed By  
                  <b>{{ $products->designer_name }}</b>
                </p>
                <p class="text-sm">Category  
                  <b>{{ $products->category->name }}</b>
                </p>

                <h5 class="mt-5 text-muted">Product Files</h5>
                <ul class="list-unstyled">
                  @foreach ($products->productdesign as $design)
                  <li>
                    <a href="#" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> {{ $design['file_name'] }}</a>
                  </li>
                  @endforeach
                </ul>

                <div class="action-buttons">
                  <a href="{{ route('products.detail',[1]) }}">
                    <button type="button" class="approve-btn">Approve</button>
                  </a>
                  <a href="{{ route('products.detail',[1]) }}">
                    <button type="button" class="reject-btn">Reject</button>
                  </a>
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
