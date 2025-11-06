<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Component
{
    public $filter = 'today'; // today, month, year, custom
    public $stats = [];
    public $latestInvoices = [];

    public function mount()
    {
        // $this->loadDashboard();
    }

    public function updatedFilter()
    {
        // $this->loadDashboard();
    }

//    public function loadDashboard()
//     {
//         $invoiceQuery = Invoice::query();
//         $receiptQuery = PaymentReceipt::query();

//         // 🗓️ Apply Date Filter
//         switch ($this->filter) {
//             case 'yesterday':
//                 $invoiceQuery->whereDate('created_at', now()->subDay());
//                 $receiptQuery->whereDate('created_at', now()->subDay());
//                 break;

//             case 'last_week':
//                 $invoiceQuery->whereBetween('created_at', [
//                     now()->subWeek()->startOfWeek(),
//                     now()->subWeek()->endOfWeek()
//                 ]);
//                 $receiptQuery->whereBetween('created_at', [
//                     now()->subWeek()->startOfWeek(),
//                     now()->subWeek()->endOfWeek()
//                 ]);
//                 break;

//             case 'month':
//                 $invoiceQuery->whereMonth('created_at', now()->month);
//                 $receiptQuery->whereMonth('created_at', now()->month);
//                 break;

//             case 'year':
//                 $invoiceQuery->whereYear('created_at', now()->year);
//                 $receiptQuery->whereYear('created_at', now()->year);
//                 break;

//             case 'today':
//             default:
//                 $invoiceQuery->whereDate('created_at', today());
//                 $receiptQuery->whereDate('created_at', today());
//                 break;
//         }

//         // 💰 Totals based on filtered invoices
//         $paidAmount = (clone $invoiceQuery)->where('status', 'Paid')->sum('amount');
//         $pendingAmount = (clone $invoiceQuery)->where('status', 'Pending')->sum('amount');

//         $this->stats = [
//             'vendors'           => User::count(),
//             'pending_invoices'  => (clone $invoiceQuery)->where('status', 'Pending')->count(),
//             'paid_invoices'     => (clone $invoiceQuery)->where('status', 'Paid')->count(),
//             'payment_receipts'  => (clone $receiptQuery)->count(),
//             'paid_amount'       => $paidAmount,
//             'unpaid_amount'     => $pendingAmount,
//         ];

//         // 🧾 Latest Invoices (always show recent)
//         $this->latestInvoices = (clone $invoiceQuery)->with('vendor')
//             ->latest()
//             ->take(10)
//             ->get(['id', 'vendor_id', 'invoice_number', 'amount', 'status', 'created_at']);
//     }



    public function render()
    {
        return view('livewire.admin-dashboard')->layout('layouts.admin');
    }
}
