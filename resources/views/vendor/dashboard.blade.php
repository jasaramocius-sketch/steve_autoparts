@extends('layouts.app')
@section('title', 'Vendor Dashboard - StAutoparts')
@section('content')

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('{{ asset('assets/images/1724480495Imagexxxxxpng.png') }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">Vendor Dashboard</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="#">Vendor Dashboard</a></li>
      </ul>
    </div>
  </div>
</section>

<!-- Dashboard Section -->
<section class="gs-dashboard-section py-5">
  <div class="container">
    <div class="row">
      <!-- Sidebar Column -->
      <div class="col-lg-3 mb-4">
        <ul class="gs-dashboard-user-sidebar-wrapper nav flex-column shadow-sm rounded border-0" id="vendorTabs" role="tablist" style="list-style: none;">
          <li class="nav-item mb-2">
            <a class="nav-link active d-flex align-items-center gap-2" id="v-dashboard-tab" data-bs-toggle="tab" href="#v-dashboard-pane" role="tab" style="text-decoration: none; border-radius: 6px; font-weight: 500;">
              <i class="fas fa-chart-line"></i> <span>Dashboard</span>
            </a>
          </li>
          <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center gap-2" id="v-products-tab" data-bs-toggle="tab" href="#v-products-pane" role="tab" style="text-decoration: none; border-radius: 6px; font-weight: 500;">
              <i class="fas fa-boxes"></i> <span>Manage Products</span>
            </a>
          </li>
          <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center gap-2" id="v-orders-tab" data-bs-toggle="tab" href="#v-orders-pane" role="tab" style="text-decoration: none; border-radius: 6px; font-weight: 500;">
              <i class="fas fa-receipt"></i> <span>All Orders</span>
            </a>
          </li>
          <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center gap-2" id="v-settings-tab" data-bs-toggle="tab" href="#v-settings-pane" role="tab" style="text-decoration: none; border-radius: 6px; font-weight: 500;">
              <i class="fas fa-store-alt"></i> <span>Shop Settings</span>
            </a>
          </li>
          <li class="nav-item mt-4">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="nav-link w-100 text-start d-flex align-items-center gap-2 border-0 bg-transparent text-danger" style="border-radius: 6px; font-weight: 500;">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
              </button>
            </form>
          </li>
        </ul>
      </div>

      <!-- Content Column -->
      <div class="col-lg-9">
        <div class="tab-content gs-dashboard-user-content-wrapper bg-white p-4 rounded shadow-sm">
          
          <!-- Tab 1: Dashboard Home -->
          <div class="tab-pane fade show active" id="v-dashboard-pane" role="tabpanel" aria-labelledby="v-dashboard-tab">
            <div class="ud-page-title-box border-bottom pb-3 mb-4">
              <h3 style="color: #1f0300; font-weight: 600;">Shop Overview: {{ $profile['shop_name'] }}</h3>
              <p class="text-muted mb-0">Track your product inventory, vendor sales, and earnings status.</p>
            </div>

            <!-- Stats Grid -->
            <div class="row g-4 mb-4">
              <div class="col-md-3 col-6">
                <div class="gs-single-statatics first-child p-4 text-center rounded">
                  <i class="fas fa-truck-loading fa-2x mb-2 text-primary"></i>
                  <h5 style="color: #1f0300; font-weight: 600;">{{ $total_sales }}</h5>
                  <p class="text-muted" style="font-size: 14px;">Total Sales</p>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="gs-single-statatics second-child p-4 text-center rounded">
                  <i class="fas fa-hand-holding-usd fa-2x mb-2 text-success"></i>
                  <h5 style="color: #1f0300; font-weight: 600;">{{ currency_format($total_earnings) }}</h5>
                  <p class="text-muted" style="font-size: 14px;">Total Earnings</p>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="gs-single-statatics third-child p-4 text-center rounded">
                  <i class="fas fa-box fa-2x mb-2 text-warning"></i>
                  <h5 style="color: #1f0300; font-weight: 600;">{{ $total_products }}</h5>
                  <p class="text-muted" style="font-size: 14px;">Total Products</p>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="gs-single-statatics fourth-child p-4 text-center rounded">
                  <i class="fas fa-calendar-check fa-2x mb-2 text-info"></i>
                  <h5 style="color: #1f0300; font-weight: 600;">{{ $successful_sales }}</h5>
                  <p class="text-muted" style="font-size: 14px;">Successful Sales</p>
                </div>
              </div>
            </div>

            <!-- Vendor Owner Info -->
            <div class="acc-info-wrapper rounded p-4" style="background-color: #fcfbfb; border: 1px solid #eee;">
              <h4 style="color: #1f0300; font-weight: 600;" class="mb-3">Shop Details</h4>
              <div class="list-wrapper">
                <div class="row w-100">
                  <div class="col-md-6">
                    <ul class="list-unstyled d-flex flex-column gap-2">
                      <li><strong class="text-secondary" style="font-size: 14px;">Shop Name:</strong> <span style="font-weight: 500;">{{ $profile['shop_name'] }}</span></li>
                      <li><strong class="text-secondary" style="font-size: 14px;">Owner Name:</strong> <span style="font-weight: 500;">{{ $profile['owner_name'] }}</span></li>
                      <li><strong class="text-secondary" style="font-size: 14px;">Shop Email:</strong> <span style="font-weight: 500;">{{ $profile['email'] }}</span></li>
                    </ul>
                  </div>
                  <div class="col-md-6">
                    <ul class="list-unstyled d-flex flex-column gap-2">
                      <li><strong class="text-secondary" style="font-size: 14px;">Shop Address:</strong> <span style="font-weight: 500;">{{ $profile['address'] }}</span></li>
                      <li><strong class="text-secondary" style="font-size: 14px;">City:</strong> <span style="font-weight: 500;">{{ $profile['city'] }}</span></li>
                      <li><strong class="text-secondary" style="font-size: 14px;">Country:</strong> <span style="font-weight: 500;">{{ $profile['country'] }}</span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tab 2: Manage Products -->
          <div class="tab-pane fade" id="v-products-pane" role="tabpanel" aria-labelledby="v-products-tab">
            <div class="ud-page-title-box border-bottom pb-3 mb-4 d-flex justify-content-between align-items-center">
              <div>
                <h3 style="color: #1f0300; font-weight: 600; margin: 0;">My Catalog</h3>
                <p class="text-muted mb-0">View, manage, and add new products to your seller catalog.</p>
              </div>
              <button class="template-btn" data-bs-toggle="collapse" data-bs-target="#addProductForm" style="background-color: var(--primary); border-color: var(--primary); color: #fff; border: none; padding: 8px 16px; border-radius: 4px; font-weight: 600;">
                + Add Product
              </button>
            </div>

            <!-- Collapse Add Product Form -->
            <div class="collapse mb-4" id="addProductForm">
              <div class="card card-body border-light shadow-sm p-4 bg-light">
                <h5 style="color: #1f0300; font-weight: 600;" class="mb-3">Add New Product</h5>
                <form action="{{ route('vendor.product.store') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label" style="font-size: 13px; font-weight: 500;">Product Name *</label>
                      <input type="text" name="name" class="form-control" placeholder="e.g. Premium Disc Brake Rotor" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label" style="font-size: 13px; font-weight: 500;">Category *</label>
                      <select name="category" class="form-select" required>
                        <option value="Engine Parts">Engine Parts</option>
                        <option value="Body & Exterior">Body & Exterior</option>
                        <option value="Interior Parts">Interior Parts</option>
                        <option value="Electrical & Lighting">Electrical & Lighting</option>
                        <option value="Brakes & Brake Parts">Brakes & Brake Parts</option>
                        <option value="Transmission & Drivetrain">Transmission & Drivetrain</option>
                        <option value="Suspension & Steering">Suspension & Steering</option>
                      </select>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label" style="font-size: 13px; font-weight: 500;">Price ($) *</label>
                      <input type="number" step="0.01" name="price" class="form-control" placeholder="e.g. 59.99" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label" style="font-size: 13px; font-weight: 500;">Stock Quantity *</label>
                      <input type="number" name="stock" class="form-control" placeholder="e.g. 50" required>
                    </div>
                  </div>
                  <button type="submit" class="template-btn" style="background-color: var(--primary); border-color: var(--primary); color: #fff; border: none; padding: 10px 24px; border-radius: 4px; font-weight: 600;">
                    Save Product
                  </button>
                </form>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-hover recent-orders-table">
                <thead class="table-light">
                  <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($products as $product)
                  <tr>
                    <td class="align-middle"><strong>#PROD-0{{ $product['id'] }}</strong></td>
                    <td class="align-middle" style="font-weight: 500;">{{ $product['name'] }}</td>
                    <td class="align-middle text-muted">{{ $product['category'] }}</td>
                    <td class="align-middle font-weight-bold">{{ currency_format($product['price']) }}</td>
                    <td class="align-middle">
                      <span class="badge bg-secondary p-2">{{ $product['stock'] }} in stock</span>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No products cataloged yet.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <!-- Tab 3: All Orders -->
          <div class="tab-pane fade" id="v-orders-pane" role="tabpanel" aria-labelledby="v-orders-tab">
            <div class="ud-page-title-box border-bottom pb-3 mb-4">
              <h3 style="color: #1f0300; font-weight: 600;">Order Log</h3>
              <p class="text-muted mb-0">Monitor and fulfill customer sales orders.</p>
            </div>

            <div class="table-responsive">
              <table class="table table-hover recent-orders-table">
                <thead class="table-light">
                  <tr>
                    <th>Order ID</th>
                    <th>Customer Details</th>
                    <th>Items Purchased</th>
                    <th>Total Received</th>
                    <th>Order Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($orders as $order)
                  <tr>
                    <td class="align-middle"><strong>{{ $order['id'] }}</strong></td>
                    <td class="align-middle" style="font-size: 13px;">
                      <strong>{{ $order['customer_name'] }}</strong><br>
                      <span class="text-secondary">{{ $order['customer_phone'] }}</span><br>
                      <span class="text-muted" style="font-size:11px;">{{ $order['address'] }}</span>
                    </td>
                    <td class="align-middle">
                      @foreach($order['items'] as $item)
                        <div style="font-size: 13px;">{{ $item['name'] }} <span class="text-secondary">x{{ $item['qty'] }}</span></div>
                      @endforeach
                    </td>
                    <td class="align-middle font-weight-bold">{{ currency_format($order['total']) }}</td>
                    <td class="align-middle">
                      @if($order['status'] === 'Completed')
                        <span class="badge bg-success p-2">Completed</span>
                      @elseif($order['status'] === 'Delivering')
                        <span class="badge bg-primary p-2">Delivering</span>
                      @else
                        <span class="badge bg-warning text-dark p-2">Pending</span>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No sales orders received yet.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <!-- Tab 4: Shop Settings -->
          <div class="tab-pane fade" id="v-settings-pane" role="tabpanel" aria-labelledby="v-settings-tab">
            <div class="ud-page-title-box border-bottom pb-3 mb-4">
              <h3 style="color: #1f0300; font-weight: 600;">Shop Configuration</h3>
              <p class="text-muted mb-0">Update your seller profile details and business location info.</p>
            </div>

            <form action="{{ route('vendor.profile.update') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Shop Name *</label>
                  <input type="text" name="shop_name" class="form-control" value="{{ $profile['shop_name'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Owner / Contact Person *</label>
                  <input type="text" name="owner_name" class="form-control" value="{{ $profile['owner_name'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Business Email *</label>
                  <input type="email" name="email" class="form-control" value="{{ $profile['email'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Shop Hotline *</label>
                  <input type="text" name="phone" class="form-control" value="{{ $profile['phone'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Country *</label>
                  <input type="text" name="country" class="form-control" value="{{ $profile['country'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">City *</label>
                  <input type="text" name="city" class="form-control" value="{{ $profile['city'] }}" required>
                </div>
                <div class="col-12 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Shop Address *</label>
                  <input type="text" name="address" class="form-control" value="{{ $profile['address'] }}" required>
                </div>
              </div>
              <button type="submit" class="template-btn mt-3" style="background-color: var(--primary); border-color: var(--primary); color: #fff; border: none; padding: 10px 24px; border-radius: 4px; font-weight: 600; text-transform: uppercase;">
                Save Shop Config
              </button>
            </form>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>

<style>
  .gs-dashboard-user-sidebar-wrapper li a {
    color: #1f0300 !important;
    background: #ffffff !important;
    transition: all 0.3s ease;
  }
  .gs-dashboard-user-sidebar-wrapper li a:hover,
  .gs-dashboard-user-sidebar-wrapper li a.active {
    background: var(--primary) !important;
    color: #ffffff !important;
  }
  .gs-single-statatics {
    box-shadow: 0px 4px 15px rgba(0,0,0,0.02);
    transition: transform 0.3s ease;
  }
  .gs-single-statatics:hover {
    transform: translateY(-5px);
  }
</style>

@endsection
