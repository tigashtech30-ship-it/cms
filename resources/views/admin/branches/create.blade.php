<x-app-layout>
    <x-slot name="header">Add New Branch</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back to Branches
            </a>

            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-building-add" style="font-size:32px;"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">New Branch</h5>
                            <small class="opacity-75">Fill in the details to create a branch</small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.branches.store') }}" method="POST" class="p-4">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="eg: Colombo Main Branch">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Branch Code <span class="text-danger">*</span></label>
                        <input type="text" name="branch_code" value="{{ old('branch_code') }}"
                               class="form-control @error('branch_code') is-invalid @enderror"
                               placeholder="eg: BR001">
                        <div class="form-text">Must be unique. eg: BR001, BR002</div>
                        @error('branch_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" value="{{ old('location') }}"
                                   class="form-control" placeholder="eg: Colombo 03">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="form-control" placeholder="eg: 011-2345678">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom mt-2">
                        <i class="bi bi-building-add me-2"></i> Create Branch
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>