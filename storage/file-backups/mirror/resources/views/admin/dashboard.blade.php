@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd !important;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted mb-1 small text-uppercase fw-semibold">Total Orders</p>
                    <h3 class="mb-0 fw-bold">{{ $totalOrders }}</h3>
                </div>
                <div class="rounded-3 p-3" style="background: #0d6efd15;">
                    <i class="fas fa-shopping-cart fa-2x" style="color: #0d6efd;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted mb-1 small text-uppercase fw-semibold">Total Revenue</p>
                    <h3 class="mb-0 fw-bold">{{ currency_format($totalRevenue) }}</h3>
                </div>
                <div class="rounded-3 p-3" style="background: #19875415;">
                    <i class="fas fa-dollar-sign fa-2x" style="color: #198754;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #fd7e14 !important;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted mb-1 small text-uppercase fw-semibold">Total Products</p>
                    <h3 class="mb-0 fw-bold">{{ $totalProducts }}</h3>
                </div>
                <div class="rounded-3 p-3" style="background: #fd7e1415;">
                    <i class="fas fa-box fa-2x" style="color: #fd7e14;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0dcaf0 !important;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted mb-1 small text-uppercase fw-semibold">Total Customers</p>
                    <h3 class="mb-0 fw-bold">{{ $totalCustomers }}</h3>
                </div>
                <div class="rounded-3 p-3" style="background: #0dcaf015;">
                    <i class="fas fa-users fa-2x" style="color: #0dcaf0;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc3545 !important;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted mb-1 small text-uppercase fw-semibold">Pending Orders</p>
                    <h3 class="mb-0 fw-bold">{{ $pendingOrders }}</h3>
                </div>
                <div class="rounded-3 p-3" style="background: #dc354515;">
                    <i class="fas fa-clock fa-2x" style="color: #dc3545;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>Recent Orders</h5>
                <a href="{{ url('/admin/orders') }}" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Order Number</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="pe-3">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td class="ps-3 fw-semibold">{{ $order->order_number }}</td>
                                <td>{{ $order->user->name ??  'N/A' }}</td>
                                <td>{{ currency_format($order->total_amount) }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($order->status) {
                                            'pending' => 'bg-light text-warning border border-warning-subtle',
                                            'processing' => 'bg-light text-info border border-info-subtle',
                                            'shipped' => 'bg-primary text-white',
                                            'delivered' => 'bg-light text-success border border-success-subtle',
                                            'cancelled' => 'bg-light text-danger border border-danger-subtle',
                                            default => 'bg-secondary text-white',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} rounded-pill">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="pe-3 text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No orders yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2"></i>Orders by Status</h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 300px;">
                @if($ordersByStatus->isEmpty())
                    <p class="text-muted mb-0">No orders found</p>
                @else
                    <div style="position: relative; width: 100%; max-width: 280px;">
                        <canvas id="ordersByStatusChart"></canvas>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2"></i>Monthly Revenue</h5>
            </div>
            <div class="card-body" style="min-height: 300px;">
                @if($monthlyRevenue->isEmpty())
                    <p class="text-muted mb-0 text-center pt-5">No revenue data yet</p>
                @else
                    <canvas id="monthlyRevenueChart" style="width: 100%;"></canvas>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ordersData = @json($ordersByStatusJson);
    var revenueData = @json($monthlyRevenueJson);

    var statusColors = {
        pending:    { bg: '#ffc107', border: '#ffca2c' },
        processing: { bg: '#0dcaf0', border: '#31d2f2' },
        shipped:    { bg: '#0d6efd', border: '#4285f4' },
        delivered:  { bg: '#198754', border: '#20c997' },
        cancelled:  { bg: '#dc3545', border: '#e55353' },
        completed:  { bg: '#6f42c1', border: '#8b5cf6' },
        returned:   { bg: '#6c757d', border: '#89939e' }
    };

    @php
        $cur = session('currency', 'USD');
        $curSymbol = config('currencies.'.$cur.'.symbol', '$');
    @endphp
    var currencySymbol = '{{ $curSymbol }}';

    if (document.getElementById('ordersByStatusChart') && Object.keys(ordersData).length > 0) {
        var labels = Object.keys(ordersData).map(function(s) { return s.charAt(0).toUpperCase() + s.slice(1); });
        var counts = Object.values(ordersData);
        var total = counts.reduce(function(a, b) { return a + b; }, 0);
        var colors = Object.keys(ordersData).map(function(s) { return (statusColors[s] || statusColors.pending).bg; });
        var borders = Object.keys(ordersData).map(function(s) { return (statusColors[s] || statusColors.pending).border; });

        new Chart(document.getElementById('ordersByStatusChart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: colors,
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverBorderColor: '#fff',
                    hoverBorderWidth: 4,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 16,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 12, weight: '500' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e1e2d',
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) {
                                var pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                                return ' ' + ctx.label + ': ' + ctx.parsed + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            },
            plugins: [{
                id: 'centerText',
                beforeDraw: function(chart) {
                    var width = chart.width, height = chart.height, ctx = chart.ctx;
                    ctx.restore();
                    ctx.font = '700 28px Inter, sans-serif';
                    ctx.textBaseline = 'middle';
                    ctx.textAlign = 'center';
                    ctx.fillStyle = '#1e1e2d';
                    ctx.fillText(total, width / 2, height / 2 - 8);
                    ctx.font = '500 12px Inter, sans-serif';
                    ctx.fillStyle = '#6c757d';
                    ctx.fillText('Total Orders', width / 2, height / 2 + 16);
                    ctx.save();
                }
            }]
        });
    }

    if (document.getElementById('monthlyRevenueChart') && Object.keys(revenueData).length > 0) {
        var monthLabels = Object.keys(revenueData).map(function(m) {
            var parts = m.split('-');
            var date = new Date(parts[0], parts[1] - 1);
            return date.toLocaleString('en', { month: 'short' }) + ' ' + parts[0].slice(2);
        });
        var revenueValues = Object.values(revenueData).map(function(v) { return parseFloat(v); });

        var ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(25, 135, 84, 0.85)');
        gradient.addColorStop(1, 'rgba(25, 135, 84, 0.35)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Revenue',
                    data: revenueValues,
                    backgroundColor: gradient,
                    borderColor: '#198754',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, weight: '500' }, color: '#6c757d' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#e9ecef' },
                        ticks: {
                            font: { size: 11 },
                            color: '#6c757d',
                            callback: function(value) {
                                if (value >= 100000) return currencySymbol + (value / 100000).toFixed(1) + 'L';
                                if (value >= 1000) return currencySymbol + (value / 1000).toFixed(1) + 'K';
                                return currencySymbol + value;
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e1e2d',
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) {
                                return ' Revenue: ' + currencySymbol + ctx.parsed.y.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
