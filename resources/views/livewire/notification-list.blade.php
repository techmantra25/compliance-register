<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Notifications</h5>
        <input type="text" class="form-control w-auto" placeholder="Search..." wire:model.debounce.300ms="search" wire:keyup="filterData($event.target.value)">
    </div>

    <div class="card shadow-sm border-0 p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $key=> $notification)
                    <tr wire:click="markAsRead({{ $notification->id }})" style="cursor:pointer;" wire:key="item-{{ $notification->id }}">
                        <td>{{ $key + 1 }}</td>

                        <td>
                            {{ $notification->title }}
                        </td>

                        <td>
                            @if($notification->is_read)
                                <span class="badge bg-success">Read</span>
                            @else
                                <span class="badge bg-warning text-dark">Unread</span>
                            @endif
                        </td>

                        <td>{{ $notification->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No notifications found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 d-flex justify-content-end">
            {{ $notifications->links('pagination.custom') }}
        </div>
    </div>
</div>