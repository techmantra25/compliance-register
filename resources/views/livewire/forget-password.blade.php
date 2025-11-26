<div class="auth-page min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-6 p-5 bg-white">
                            @if (session('success'))
                                <div class="alert alert-success mt-2">{{ session('success') }}</div>
                            @endif

                            <form wire:submit.prevent="forgetPassword">

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" wire:model="email" class="form-control" placeholder="Enter your registered email">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>New Password</label>
                                    <input type="password" wire:model="password" class="form-control" placeholder="Enter your password">
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Confirm Password</label>
                                    <input type="password" wire:model="password_confirmation" class="form-control" placeholder="Confirm your password">
                                </div>

                                <button class="btn btn-primary">
                                    Reset Password
                                </button>
                            </form>
                        </div>

                        <div class="col-md-6 d-none d-md-block position-relative" 
                             style="background: url('{{ asset('assets/img/logo-background.jpg') }}') center/cover no-repeat;">
                            <div class="overlay position-absolute top-0 start-0 w-100 h-100" 
                                 style="background-color: #8359599c">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            window.addEventListener('toastr:success', event => {
                toastr.success(event.detail.message);
            });
        </script>
    @endpush
</div>



