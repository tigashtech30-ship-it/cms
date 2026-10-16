<x-app-layout>
    <x-slot name="header">Complaint Categories</x-slot>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4">
            <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Filter by Branch --}}
    <div class="table-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-funnel me-2"></i>Filter by Branch
            </h6>
        </div>
        <div class="p-3">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <select name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }} ({{ $branch->branch_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark">All Categories</h5>
                <small class="text-muted">
                    @if(request('branch_id'))
                        Filtered by branch —
                        <strong>{{ $branches->find(request('branch_id'))->name ?? '' }}</strong>
                    @else
                        All branches
                    @endif
                    | Total: {{ $categories->count() }}
                </small>
            </div>
            <a href="{{ route('admin.categories.create') }}"
               class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add Category
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Branch</th>
                        <th>Category Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Complaints</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>
                            @if($category->branch)
                                <span class="branch-code-badge">
                                    <i class="bi bi-building me-1"></i>
                                    {{ $category->branch->name }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td>
                            <span class="branch-code-badge">
                                {{ $category->code }}
                            </span>
                        </td>
                        <td class="text-muted small">
                            {{ $category->description ?? '—' }}
                        </td>
                        <td>
                            <span class="badge bg-primary rounded-pill">
                                {{ $category->complaints_count }}
                            </span>
                        </td>
                        <td>
                            @if($category->is_active)
                                <span class="badge-active">● Active</span>
                            @else
                                <span class="badge-inactive">● Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-tags text-muted" style="font-size:40px;"></i>
                            <p class="text-muted mt-2">No categories found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>