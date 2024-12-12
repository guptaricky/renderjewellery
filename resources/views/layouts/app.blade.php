<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/codemirror/codemirror.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/codemirror/theme/monokai.css') }}">
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <!-- Page Content -->
        <div class="wrapper">
            <!-- Include Navbar -->
            @include('layouts.navigation')
            <!-- Include Sidebar -->
            @include('layouts.sidebar')

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="{{ asset('dist/img/logo-rj.png') }}" alt="Rendering..." height="60" width="60">
            </div>

            {{ $slot }}

            <!-- Include footer -->
            @include('layouts.footer')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
        <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
        <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
        <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('plugins/codemirror/codemirror.js') }}"></script>
        <script src="{{ asset('plugins/codemirror/mode/css/css.js') }}"></script>
        <script src="{{ asset('plugins/codemirror/mode/xml/xml.js') }}"></script>
        <script src="{{ asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
        <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('dist/js/adminlte.js') }}"></script>
        <script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
        <script src="{{ asset('plugins/filterizr/jquery.filterizr.min.js') }}"></script>
        <script src="{{ asset('dist/js/demo.js') }}"></script>
        <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

        <script>
            $(document).ready(function () {
                // Initialize Summernote
                $('#summernote').summernote({
                    height: 300, // Set editor height
                    placeholder: 'Write something amazing...',
                },
                );

                // Initialize CodeMirror
                if (document.getElementById("codeMirrorDemo")) {
                    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                        mode: "htmlmixed",
                        theme: "monokai"
                    });
                }
            });
        </script>
        <script>
            $(document).ready(function() {
              $('.product-image-thumb').on('click', function () {
                var $image_element = $(this).find('img')
                $('.product-image').prop('src', $image_element.attr('src'))
                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
              });

              function updateCartCount() {
                    $.ajax({
                        url: "{{ route('cart.count') }}",
                        type: "GET",
                        success: function (response) {
                            $('#cart-count').text(response.count);
                        },
                        error: function () {
                            console.error('Failed to fetch cart count.');
                        }
                    });
                }

                updateCartCount();

                $(document).on('click', '#add-to-cart-btn', function () {
                    updateCartCount();
                });

            
            $("#checkoutButton").on("click", function () {
            const orderData = {
                user_id: {{ Auth::user()->id}},
                payment_method: "razorpay"
            };

            fetch('{{ route('orders.create') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',  // Include CSRF token
            },
            body: JSON.stringify(orderData)  // Pass the order data as a JSON string
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to the order summary page (or payment page) after order creation
                    window.location.href = '/orders/order-summary/' + data.order_number;
                } else {
                    alert('Failed to create order: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the order.');
            });
            });
            })
          </script>
          <script>
            $(document).ready(function () {
                $('#add-to-cart-btn').click(function () {
                    const productId = $('#product-id').val();
                    const quantity = $('#quantity').val();
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
                    // AJAX request
                    $.ajax({
                        url: '/cart/add',
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        data: { product_id: productId, quantity: quantity },
                        success: function (response) {
                            alert(response.message);
                        },
                        error: function (xhr) {
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                });
            });
            </script>
            <script>
                $(document).on('click', '.approve-product', function (e) {
                    e.preventDefault();
                    let $button = $('#approve-btn');
                    let productId = $(this).data('id');
                    let status = $(this).data('status');

                    $.ajax({
                        url: "{{ route('products.approval') }}",
                        type: "PATCH",
                        data: {
                            id: productId,
                            status: status,
                            _token: "{{ csrf_token() }}" 
                        },
                        success: function (response) {
                            if(response.status == 'success'){
                                $('#modal-sm').modal('hide');
                                $button.prop('disabled', true).text('Approved');
                            }
                        },
                        error: function (xhr) {
                            alert('An error occurred: ' + xhr.responseText);
                        }
                    });
                });

                $(document).on('click', '.comment-on-product', function (e) {
                    e.preventDefault();
                    let $button = $('#comment-btn');
                    let comment = $('#comment').val();
                    let productId = $(this).data('id');
                    let status = $(this).data('status');

                    alert(comment);
                    $.ajax({
                        url: "{{ route('products.approval') }}",
                        type: "PATCH",
                        data: {
                            id: productId,
                            status: status,
                            comment: comment,
                            _token: "{{ csrf_token() }}" 
                        },
                        success: function (response) {
                            if(response.status == 'success'){
                                $('#modal-lg').modal('hide');
                                $button.prop('disabled', true).text('Rejected');
                            }
                        },
                        error: function (xhr) {
                            alert('An error occurred: ' + xhr.responseText);
                        }
                    });
                });
            </script>
    </body>
</html>