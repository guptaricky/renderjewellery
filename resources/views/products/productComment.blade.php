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
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>