<div class="container mt-1">

    <div class="row">
        
        <!-- Left Space -->
        <div class="col-md-1"></div>

        <!-- Content Area -->
        <div class="col-md-10">
                <h3>Change Password</h3>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body p-4">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="changePassword">

                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" wire:model.defer="current_password">
                            @error('current_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" wire:model.defer="new_password">
                            @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" wire:model.defer="new_password_confirmation">
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary px-4">
                                Update Password
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

        <!-- Right Space -->
        <div class="col-md-1"></div>

    </div>

</div>