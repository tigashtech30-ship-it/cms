<x-app-layout>
    <x-slot name="header">Add Category</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back
            </a>

            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-tags" style="font-size:32px;"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">New Category</h5>
                            <small class="opacity-75">
                                Branch select செய்து category சேருங்க
                            </small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.categories.store') }}"
                      method="POST" class="p-4">
                    @csrf

                    {{-- Branch --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Branch <span class="text-danger">*</span>
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

                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="eg: Technical Department">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Code --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Category Code <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="code" value="{{ old('code') }}"
                               class="form-control @error('code') is-invalid @enderror"
                               placeholder="eg: TECH"
                               style="text-transform:uppercase;">
                        <div class="form-text">Short code eg: TECH, HR, FIN</div>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3"
                                  class="form-control"
                                  placeholder="Brief description...">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-tags me-2"></i> Create Category
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>