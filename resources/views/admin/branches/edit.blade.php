<x-app-layout>
    <x-slot name="header">Edit Branch</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back to Branches
            </a>

            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-pencil-square" style="font-size:32px;"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $branch->name }}</h5>
                            <small class="opacity-75">Code: {{ $branch->branch_code }}</small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.branches.update', $branch) }}" method="POST" class="p-4">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $branch->name) }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Branch Code <span class="text-danger">*</span></label>
                        <input type="text" name="branch_code" value="{{ old('branch_code', $branch->branch_code) }}"
                               class="form-control @error('branch_code') is-invalid @enderror">
                        @error('branch_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" value="{{ old('location', $branch->location) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_active"
                                       value="1" id="active"
                                       {{ $branch->is_active ? 'checked' : '' }}>
                                <label class="form-check-label text-success fw-semibold" for="active">
                                    ● Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_active"
                                       value="0" id="inactive"
                                       {{ !$branch->is_active ? 'checked' : '' }}>
                                <label class="form-check-label text-danger fw-semibold" for="inactive">
                                    ● Inactive
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-check-lg me-2"></i> Update Branch
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>