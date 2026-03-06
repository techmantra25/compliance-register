<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;
use Livewire\WithPagination;

class NotificationList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function filterData($value)
    {
        $this->search = $value;
        $this->resetPage();
    }
    // Mark notification as read
    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if ($notification && $notification->is_read == 0) {
            $notification->update(['is_read' => 1]);
        }
        // Optional: redirect to notification link
        return redirect()->to($notification->url);
    }

    public function render()
    {
        $notifications = Notification::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('livewire.notification-list', compact('notifications'))->layout('layouts.admin');
    }
}