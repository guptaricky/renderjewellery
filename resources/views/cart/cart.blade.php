<x-app-layout>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="d-inline-block">Shopping cart</h3>
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
              <div class="col-8 col-sm-8">
                
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title"><i class="fas fa-arrow-left"></i>&nbsp; Back to Shopping</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                        <thead>
                          <tr>
                            <th colspan="2" style="width: 60%">Items</th>
                            <th style="width: 20%">Quantity</th>
                            <th style="text-align: right;">Price</th>
                          </tr>
                        </thead>
                        <tbody>
                            {{-- @php
                                print_r($cart->product);
                            @endphp --}}
                            @foreach ($cart as $item)
                                <tr>
                                    <td>
                                        <img src="../../dist/img/default-150x150.png" />
                                    </td>
                                    <td>
                                        <div class="attachment-pushed">
                                            <h4 class="attachment-heading"><a href="#">{{ $item->product->title }}</a></h4>
                            
                                            <div class="attachment-text">
                                                Description about the attachment can be placed here.
                                            </div>
                                            <!-- /.attachment-text -->
                                            </div>
                                            <!-- /.attachment-pushed -->
                                    </td>
                                    <td>
                                        {{ $item->quantity}}
                                    </td>
                                    <td style="text-align: right;">{{ $item->product->price }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" style="text-align: right;"><h4>Total: {{ $total }}</h4></td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                </div>
              </div>

              <div class="col-4 col-sm-4">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        
                        Order Summary
                      </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <ul class="nav flex-column">
                        <li class="nav-item">
                          <span class="nav-link">
                            <strong>Sub Total <span class="float-right">&#8377;{{ $total }}</span></strong>
                          </span>
                        </li>
                        <li class="nav-item">
                          <span class="nav-link">
                            Discount <span class="float-right"><strong>- &#8377;0</strong></span>
                          </span>
                        </li>
                        <li class="nav-item">
                          <span class="nav-link">
                            GST <span class="float-right"><strong>+ &#8377;0</strong></span>
                          </span>
                        </li>
                        <li class="nav-item bg-warning">
                            <span class="nav-link">
                                <strong>Final Price <span class="float-right">&#8377;{{ $total }}</span></strong>
                            </span>
                        </li>
                      </ul>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <a href="javascript:void(0)" class="btn btn-block btn-primary" id="checkoutButton">Continue to Checkout</a>
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
  