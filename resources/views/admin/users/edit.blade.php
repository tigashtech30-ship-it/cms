<x-app-layout>
    <x-slot name="header">Edit User</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <a href="{{ route('admin.users.index') }}"
               class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>

            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="branch-avatar"
                             style="width:48px;height:48px;font-size:18px;background:rgba(255,255,255,0.2);color:white;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $user->name }}</h5>
                            <small class="opacity-75">{{ $user->email }}</small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.users.update', $user) }}"
                      method="POST" class="p-4">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">
                            Full Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               value="{{ old('name', $user->name) }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email"
                               value="{{ old('email', $user->email) }}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Assign Branch <span class="text-danger">*</span>
                        </label>
                        <select name="branch_id"
                                class="form-select @error('branch_id') is-invalid @enderror">
                            <option value="">-- Select Branch --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                        {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }} ({{ $branch->branch_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password (Optional) --}}
                    <div class="p-3 rounded-3 mb-4" style="background:#f8f9fa;border:1px dashed #dee2e6;">
                        <p class="text-muted small mb-3">
                            <i class="bi bi-info-circle me-1"></i>
                            Password மாத்த வேண்டும் என்றால் மட்டும் fill செய்யுங்க.
                            இல்லன்னா blank-ஆ விடுங்க.
                        </p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Min 6 characters">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                       class="form-control"
                                       placeholder="Repeat password">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-check-lg me-2"></i> Update User
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>