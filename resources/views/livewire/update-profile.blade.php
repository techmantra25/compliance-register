<div class="container mt-4">

    <h3>Update Profile</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="updateProfile">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" wire:model.defer="name">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" wire:model.defer="email">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Mobile</label>
                <input type="text" class="form-control" wire:model.defer="mobile">
                @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Zones</label>
                <select wire:model.defer="zone_id" class="form-control">
                    <option value="">Select zone</option>
                    @foreach ($zoneList as $zone_item)
                        <option value="{{$zone_item->id}}">{{$zone_item->name}}</option>
                    @endforeach
                </select>
                @error('zone_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Role</label>
                <select class="form-control" wire:model.defer="role">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="user">User</option>
                </select>
                @error('role') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

        </div>

        <button class="btn btn-primary mt-3">Update Profile</button>

    </form>
</div>

