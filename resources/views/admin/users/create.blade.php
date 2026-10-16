<x-app-layout>
    <x-slot name="header">Add New User</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <a href="{{ route('admin.users.index') }}"
               class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>

            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-person-plus" style="font-size:32px;"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">New Branch User</h5>
                            <small class="opacity-75">Create a user and assign to a branch</small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" class="p-4">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Full Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="eg: John Smith">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="eg: john@office.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Branch --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Assign Branch <span class="text-danger">*</span>
                        </label>
                        <select name="branch_id"
                                class="form-select @error('branch_id') is-invalid @enderror">
                            <option value="">-- Select Branch --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }} ({{ $branch->branch_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min 6 characters">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                Confirm Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Repeat password">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-person-plus me-2"></i> Create User
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>