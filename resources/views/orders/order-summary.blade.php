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
                <li class="breadcrumb-item active">Order Summary</li>
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
             
              <div class="col-8 col-sm-8">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        Order Summary
                      </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <p>Order Number: {{ $order->order_number }}</p>
                        <p>Total Amount: ₹{{ $order->total_amount }}</p>
                        
                        <!-- Razorpay Payment Button -->
                        <a href="javascript:void(0)" class="btn btn-block btn-success" id="razorpayPaymentButton">Pay Now</a>
                        
                        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                        <script>
                            document.getElementById("razorpayPaymentButton").addEventListener("click", function () {
                                const options = {
                                    key: "{{ env('RAZORPAY_KEY') }}", // Replace with your Razorpay key
                                    amount: {{ $order->total_amount }} * 100, // Amount in paise
                                    currency: "INR",
                                    name: "Render Jewellery",
                                    description: "Order Payment",
                                    order_id: "{{ $order->order_number }}", // The same order_number stored in the DB
                                    handler: function (response) {
                                        // console.log(">>>>>>>>>>>>>>",response);
                                        // Handle the payment success here
                                        verifyPayment(response);
                                    },
                                    prefill: {
                                        name: "{{ $order->user->name }}", // Replace with user data
                                        email: "{{ $order->user->email }}", // Replace with user data
                                        //contact: "8602308752", // Replace with user data
                                    },
                                    theme: {
                                        color: "#3399cc",
                                    }
                                };
                        
                                const rzp = new Razorpay(options);
                                rzp.open();
                            });
                        
                            function verifyPayment(paymentResponse) {
                                // Call your backend to verify payment
                                fetch("/orders/verify-payment", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        razorpay_order_id: paymentResponse.razorpay_order_id,
                                        razorpay_payment_id: paymentResponse.razorpay_payment_id,
                                        razorpay_signature: paymentResponse.razorpay_signature,
                                        receipt: "{{ $order->order_number }}" // Pass order number to backend for verification
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log(">>>>>>>>>>>>>",data)
                                    if (data.success) {
                                        alert("Payment successful! Order completed.");
                                        window.location.href = "/order-success"; // Redirect to a success page
                                    } else {
                                        alert("Payment verification failed.");
                                    }
                                })
                                .catch(error => {
                                    alert("Payment verification error.");
                                });
                            }
                        </script>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  
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
  