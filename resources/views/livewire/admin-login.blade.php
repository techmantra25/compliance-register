<div class="auth-page min-vh-100 d-flex align-items-center justify-content-center bg-light">
    {{-- {{dd('hixsds')}} --}}
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg overflow-hidden">
                    <div class="row g-0">
                        
                        <!-- Left Side (Form) -->
                        <div class="col-md-6 p-5 bg-white">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" height="50">
                                <h3 class="mt-3 fw-semibold">Welcome Back!</h3>
                                <p class="text-muted">Sign in to continue to us.</p>
                            </div>

                            @if ($errors->has('email'))
                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                            @endif

                            <form wire:submit.prevent="login">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input wire:model.defer="email" type="email" id="email" class="form-control" placeholder="Enter email">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input wire:model.defer="password" type="password" id="password" class="form-control" placeholder="Enter password">
                                        <span class="input-group-text bg-transparent">
                                            <i class="bi bi-eye"></i>
                                        </span>
                                    </div>
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input wire:model="remember" type="checkbox" class="form-check-input" id="remember">
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                    <a href="javascript:void(0)" class="text-decoration-none text-muted small">Forgot your password?</a>
                                </div>

                                <button type="submit" class="btn w-100 text-white py-2" style="background-color: #438a7a;">
                                    Log In
                                </button>
                            </form>
                        </div>

                        <!-- Right Side (Image) -->
                        <div class="col-md-6 d-none d-md-block position-relative" 
                             style="background: url('{{ asset('assets/img/logo-background.jpg') }}') center/cover no-repeat;">
                            <div class="overlay position-absolute top-0 start-0 w-100 h-100" 
                                 style="background-color: rgba(67, 138, 122, 0.8);"></div>
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
