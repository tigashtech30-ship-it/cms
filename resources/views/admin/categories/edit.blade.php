<x-app-layout>
    <x-slot name="header">Edit Category</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back
            </a>

            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-pencil-square" style="font-size:32px;"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $category->name }}</h5>
                            <small class="opacity-75">Code: {{ $category->code }}</small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.categories.update', $category) }}"
                      method="POST" class="p-4">
                    @csrf
                    @method('PUT')

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
                                    {{ old('branch_id', $category->branch_id) == $branch->id
                                        ? 'selected' : '' }}>
                                    {{ $branch->name }} ({{ $branch->branch_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               value="{{ old('name', $category->name) }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Category Code <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="code"
                               value="{{ old('code', $category->code) }}"
                               class="form-control @error('code') is-invalid @enderror">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3"
                                  class="form-control">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="is_active" value="1" id="active"
                                       {{ $category->is_active ? 'checked' : '' }}>
                                <label class="form-check-label text-success fw-semibold"
                                       for="active">● Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="is_active" value="0" id="inactive"
                                       {{ !$category->is_active ? 'checked' : '' }}>
                                <label class="form-check-label text-danger fw-semibold"
                                       for="inactive">● Inactive</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-check-lg me-2"></i> Update Category
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>