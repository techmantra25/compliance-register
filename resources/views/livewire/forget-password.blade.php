<div class="auth-page min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-6 p-5 bg-white">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/img/FMLogo.png') }}" alt="Logo" style="width:180px;" >
                                <h3 class="mt-3 fw-semibold" style="color: #3e0b0f;">Forget Password</h3>
                                <!--<p class="text-muted">Sign in to continue to us.</p>-->
                            </div>
                            
                            @if (session('success'))
                                <div class="alert alert-success mt-2">{{ session('success') }}</div>
                            @endif

                            <form>

                                @if($step == 1)

                                <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" wire:model="email" class="form-control" placeholder="Enter your registered email address">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <button type="button" wire:click="sendOtp" class="btn btn-primary">
                                Send OTP
                                </button>

                                @endif


                                @if($step == 2)

                                <div class="mb-3">
                                <label class="form-label">Enter OTP</label>
                                <input type="text" wire:model="otp" class="form-control">
                                @error('otp') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <button type="button" wire:click="verifyOtp" class="btn btn-primary">
                                Verify OTP
                                </button>

                                @endif


                                @if($step == 3)

                                <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" wire:model="password" class="form-control">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" wire:model="password_confirmation" class="form-control">
                                </div>

                                <button type="button" wire:click="resetPassword" class="btn btn-success">
                                Reset Password
                                </button>

                                @endif

                            </form>
                        </div>

                        <div class="col-md-6 d-none d-md-block position-relative" 
                             style="background: url('{{ asset('assets/img/frame_2.webp') }}') center/cover no-repeat;">
                            <!--<div class="overlay position-absolute top-0 start-0 w-100 h-100" -->
                            <!--     style="background-color: #8359599c">-->
                            <!--</div>-->
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



