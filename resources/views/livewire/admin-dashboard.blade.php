<div>
    <div class="row g-4 mb-4">
        <!-- ðŸŸ© Stats Overview -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-semibold text-dark mb-1">Dashboard Overview</h5>
                        <!--<p class="text-muted mb-0">A quick insight into your vendors, invoices, and payments.</p>-->
                    </div>

                    <div class="d-flex gap-2 mt-3 mt-md-0">
                        <select wire:model="filter" 
                                class="form-select form-select-sm border-theme text-theme" 
                                style="width:180px;">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last_week">Last Week</option>
                            <option value="month">This Month</option>
                            <option value="year">This Year</option>
                        </select>

                        <button class="btn text-white" style="background-color: #438a7a;" wire:click="loadDashboard">
                            <i class="bi bi-funnel-fill me-1"></i> Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ðŸŸ¢ Stat Cards -->
        {{-- <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="fw-bold text-theme fs-4">{{ $stats['vendors'] ?? 0 }}</div>
                <small class="text-muted">Vendors</small>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="fw-bold text-warning fs-4">{{ $stats['pending_invoices'] ?? 0 }}</div>
                <small class="text-muted">Pending Invoices</small>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="fw-bold text-primary fs-4">{{ $stats['paid_invoices'] ?? 0 }}</div>
                <small class="text-muted">Paid Invoices</small>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="fw-bold text-info fs-4">{{ $stats['payment_receipts'] ?? 0 }}</div>
                <small class="text-muted">Payment Receipts</small>
            </div>
        </div> --}}
    </div>

    <!-- ðŸ’³ Payment Activity & Latest Invoices -->
    <div class="row g-4">
        <!-- ðŸ“Š Payment Overview -->
        {{-- <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Invoice Trail</h6>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span>Paid: <strong>â‚¹{{ number_format($stats['paid_amount'] ?? 0, 2) }}</strong></span>
                        <span>Pending: <strong>â‚¹{{ number_format($stats['unpaid_amount'] ?? 0, 2) }}</strong></span>
                    </div>

                    @php
                        $total = ($stats['paid_amount'] ?? 0) + ($stats['unpaid_amount'] ?? 0);
                        $paidPercent = $total > 0 ? (($stats['paid_amount'] / $total) * 100) : 0;
                    @endphp

                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ $paidPercent }}%; background-color:#438a7a;">
                        </div>
                    </div>
                </div>

            </div>
        </div> --}}

        <!-- ðŸ§¾ Latest Invoices -->
        {{-- <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Latest 10 Invoices</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Vendor</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestInvoices as $key=> $invoice)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $invoice->vendor->name ?? 'N/A' }}</td>
                                        <td>{{ $invoice->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if ($invoice->status === 'Paid')
                                                <span class="badge bg-primary-subtle text-primary">Paid</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>â‚¹{{ number_format($invoice->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No invoices found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
