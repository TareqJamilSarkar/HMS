@extends('template.master')
@section('title', 'Settings')
@section('content')
    <div id="settings" class="fade-in">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 text-gradient mb-1">Settings</h1>
                        <p class="text-muted mb-0">Manage your account settings and preferences</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 mb-4">
                <div class="card card-lh">
                    <div class="card-body">
                        <div class="nav flex-column nav-pills">
                            <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile"
                               role="tab">
                                <i class="fas fa-user me-2"></i>Profile Settings
                            </a>
                            <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password"
                               role="tab">
                                <i class="fas fa-lock me-2"></i>Change Password
                            </a>
                            <a class="nav-link" id="preferences-tab" data-bs-toggle="tab" href="#preferences"
                               role="tab">
                                <i class="fas fa-sliders-h me-2"></i>Preferences
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="col-lg-9">
                <div class="tab-content">
                    <!-- Profile Settings Tab -->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel">
                        <div class="card card-lh">
                            <div class="card-header">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    Profile Settings
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('settings.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">Full Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email"
                                               value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label fw-bold">Phone Number</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                               id="phone" name="phone"
                                               value="{{ old('phone', $user->phone ?? '') }}" placeholder="+1 (555) 123-4567">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-bold">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror"
                                                  id="address" name="address" rows="3"
                                                  placeholder="Street address">{{ old('address', $user->address ?? '') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Role</label>
                                        <input type="text" class="form-control" value="{{ $user->role }}" readonly>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="fas fa-redo me-2"></i>Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password Tab -->
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <div class="card card-lh">
                            <div class="card-header">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-lock text-primary me-2"></i>
                                    Change Password
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('settings.updatePassword') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="alert alert-info" role="alert">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Please enter your current password and then your new password.
                                    </div>

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label fw-bold">Current Password</label>
                                        <input type="password"
                                               class="form-control @error('current_password') is-invalid @enderror"
                                               id="current_password" name="current_password" required>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-bold">New Password</label>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password" required minlength="8">
                                        <small class="form-text text-muted">
                                            Password must be at least 8 characters long.
                                        </small>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label fw-bold">Confirm New
                                            Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                               name="password_confirmation" required minlength="8">
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="fas fa-redo me-2"></i>Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Preferences Tab -->
                    <div class="tab-pane fade" id="preferences" role="tabpanel">
                        <div class="card card-lh">
                            <div class="card-header">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-sliders-h text-primary me-2"></i>
                                    Preferences
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Timezone -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold mb-3">
                                                    <i class="fas fa-globe me-2 text-primary"></i>Timezone
                                                </h6>
                                                <p class="text-muted mb-2">Your current timezone</p>
                                                <div class="form-text bg-white p-2 rounded border">
                                                    <strong>Asia/Dhaka</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Currency -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold mb-3">
                                                    <i class="fas fa-dollar-sign me-2 text-primary"></i>Currency
                                                </h6>
                                                <p class="text-muted mb-2">Your default currency</p>
                                                <div class="form-text bg-white p-2 rounded border">
                                                    <strong>Bangladeshi Taka (৳)</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Language -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold mb-3">
                                                    <i class="fas fa-language me-2 text-primary"></i>Language
                                                </h6>
                                                <p class="text-muted mb-2">Your preferred language</p>
                                                <div class="form-text bg-white p-2 rounded border">
                                                    <strong>English</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Version -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold mb-3">
                                                    <i class="fas fa-code-branch me-2 text-primary"></i>System Version
                                                </h6>
                                                <p class="text-muted mb-2">Current application version</p>
                                                <div class="form-text bg-white p-2 rounded border">
                                                    <strong>v1.0.0</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info mt-4" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Note:</strong> Additional preferences like notifications, email settings, and
                                    theme preferences can be managed here.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
