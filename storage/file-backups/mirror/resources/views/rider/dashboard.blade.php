@extends('layouts.app')
@section('title', 'Rider Dashboard - StAutoparts')
@section('content')

<!-- Banner Hero Section -->
<section class="gs-breadcrumb-section" style="background-image: url('{{ asset('assets/images/1724480495Imagexxxxxpng.png') }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="content-wrapper">
      <h2 class="breadcrumb-title">Rider Dashboard</h2>
      <ul class="bread-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="#">Rider Dashboard</a></li>
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
        <ul class="gs-dashboard-user-sidebar-wrapper nav flex-column shadow-sm rounded border-0" id="riderTabs" role="tablist" style="list-style: none;">
          <li class="nav-item mb-2">
            <a class="nav-link active d-flex align-items-center gap-2" id="r-dashboard-tab" data-bs-toggle="tab" href="#r-dashboard-pane" role="tab" style="text-decoration: none; border-radius: 6px; font-weight: 500;">
              <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
          </li>
          <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center gap-2" id="r-deliveries-tab" data-bs-toggle="tab" href="#r-deliveries-pane" role="tab" style="text-decoration: none; border-radius: 6px; font-weight: 500;">
              <i class="fas fa-truck-loading"></i> <span>Delivery List</span>
            </a>
          </li>
          <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center gap-2" id="r-profile-tab" data-bs-toggle="tab" href="#r-profile-pane" role="tab" style="text-decoration: none; border-radius: 6px; font-weight: 500;">
              <i class="fas fa-user-cog"></i> <span>Profile Settings</span>
            </a>
          </li>
          <li class="nav-item mt-4">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="nav-link w-100 text-start d-flex align-items-center gap-2 border-0 bg-transparent text-danger steve-btn" style="border-radius: 6px; font-weight: 500;">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
              </button>
            </form>
          </li>
        </ul>
      </div>

      <!-- Content Column -->
      <div class="col-lg-9">
        <div class="tab-content gs-dashboard-user-content-wrapper bg-white p-4 rounded shadow-sm">
          
          <!-- Tab 1: Rider Dashboard -->
          <div class="tab-pane fade show active" id="r-dashboard-pane" role="tabpanel" aria-labelledby="r-dashboard-tab">
            <div class="ud-page-title-box border-bottom pb-3 mb-4">
              <h3 style="color: #1f0300; font-weight: 600;">Hello, {{ $profile['name'] }}!</h3>
              <p class="text-muted mb-0">Track your active deliveries and earnings.</p>
            </div>

            <div class="row g-4 mb-4">
              <div class="col-md-4 col-12">
                <div class="gs-single-statatics first-child p-4 text-center rounded">
                  <i class="fas fa-route fa-2x mb-2 text-primary"></i>
                  <h5 style="color: #1f0300; font-weight: 600;">{{ $total_deliveries }}</h5>
                  <p class="text-muted" style="font-size: 14px;">Total Deliveries</p>
                </div>
              </div>
              <div class="col-md-4 col-12">
                <div class="gs-single-statatics second-child p-4 text-center rounded">
                  <i class="fas fa-bicycle fa-2x mb-2 text-success"></i>
                  <h5 style="color: #1f0300; font-weight: 600;">{{ $active_deliveries }}</h5>
                  <p class="text-muted" style="font-size: 14px;">Active Deliveries</p>
                </div>
              </div>
              <div class="col-md-4 col-12">
                <div class="gs-single-statatics third-child p-4 text-center rounded">
                  <i class="fas fa-wallet fa-2x mb-2 text-info"></i>
                  <h5 style="color: #1f0300; font-weight: 600;">{{ currency_format($earnings) }}</h5>
                  <p class="text-muted" style="font-size: 14px;">Earnings</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Tab 2: Delivery List -->
          <div class="tab-pane fade" id="r-deliveries-pane" role="tabpanel" aria-labelledby="r-deliveries-tab">
            <div class="ud-page-title-box border-bottom pb-3 mb-4">
              <h3 style="color: #1f0300; font-weight: 600;">Delivery Assignments</h3>
              <p class="text-muted mb-0">Accept or complete deliveries assigned to you.</p>
            </div>

            <div class="table-responsive">
              <table class="table table-hover recent-orders-table">
                <thead class="table-light">
                  <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($orders as $order)
                  <tr>
                    <td class="align-middle"><strong>{{ $order['id'] }}</strong></td>
                    <td class="align-middle" style="font-size: 13px;">
                      {{ $order['customer_name'] }}<br>
                      <span class="text-secondary">{{ $order['customer_phone'] }}</span>
                    </td>
                    <td class="align-middle">
                      @foreach($order['items'] as $item)
                        <div style="font-size: 13px;">{{ $item['name'] }} <span class="text-secondary">x{{ $item['qty'] }}</span></div>
                      @endforeach
                    </td>
                    <td class="align-middle font-weight-bold">{{ currency_format($order['total']) }}</td>
                    <td class="align-middle">
                      @if($order['status'] === 'Pending')
                        <span class="badge bg-warning text-dark p-2">Pending</span>
                      @elseif($order['status'] === 'Delivering')
                        <span class="badge bg-primary p-2">Delivering</span>
                      @else
                        <span class="badge bg-success p-2">Completed</span>
                      @endif
                    </td>
                    <td class="align-middle table-action-col">
                      @if($order['status'] === 'Pending')
                        <form action="{{ route('rider.order.update', ['order_id' => $order['id']]) }}" method="POST" class="d-inline">
                          @csrf
                          <input type="hidden" name="action" value="accept">
                          <button type="submit" class="btn btn-sm btn-primary steve-btn">Accept</button>
                        </form>
                      @elseif($order['status'] === 'Delivering')
                        <form action="{{ route('rider.order.update', ['order_id' => $order['id']]) }}" method="POST" class="d-inline">
                          @csrf
                          <input type="hidden" name="action" value="complete">
                          <button type="submit" class="btn btn-sm btn-success steve-btn">Mark Completed</button>
                        </form>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No deliveries assigned yet.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <!-- Tab 3: Profile Settings -->
          <div class="tab-pane fade" id="r-profile-pane" role="tabpanel" aria-labelledby="r-profile-tab">
            <div class="ud-page-title-box border-bottom pb-3 mb-4">
              <h3 style="color: #1f0300; font-weight: 600;">Profile Settings</h3>
              <p class="text-muted mb-0">Update your personal and vehicle information.</p>
            </div>
            <form action="{{ route('rider.profile.update') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Full Name</label>
                  <input type="text" name="name" class="form-control" value="{{ $profile['name'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Email</label>
                  <input type="email" name="email" class="form-control" value="{{ $profile['email'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Phone</label>
                  <input type="tel" name="phone" class="form-control" inputmode="numeric" value="{{ $profile['phone'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Vehicle</label>
                  <input type="text" name="vehicle" class="form-control" value="{{ $profile['vehicle'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">Country</label>
                  <input type="text" name="country" class="form-control" value="{{ $profile['country'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="font-weight: 500; font-size: 14px;">City</label>
                  <input type="text" name="city" class="form-control" value="{{ $profile['city'] }}" required>
                </div>
              </div>
              <button type="submit" class="template-btn mt-3 steve-btn" style="background-color: var(--primary); border-color: var(--primary); color: #fff; border: none; padding: 10px 24px; border-radius: 4px; font-weight: 600; text-transform: uppercase;">
                Save Changes
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
