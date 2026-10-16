<x-app-layout>
    <x-slot name="header">Edit Complaint</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('admin.complaints.index') }}"
               class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back to Complaints
            </a>

            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-pencil-square" style="font-size:32px;"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Edit Complaint</h5>
                            <small class="opacity-75">Update complaint details or status</small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.complaints.update', $complaint) }}"
                      method="POST" class="p-4">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">
                            Complaint Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title"
                               value="{{ old('title', $complaint->title) }}"
                               class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Description <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $complaint->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                Branch <span class="text-danger">*</span>
                            </label>
                            <select name="branch_id"
                                    class="form-select @error('branch_id') is-invalid @enderror">
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                            {{ old('branch_id', $complaint->branch_id) == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }} ({{ $branch->branch_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                Priority <span class="text-danger">*</span>
                            </label>
                            <select name="priority" class="form-select">
                                <option value="low"    {{ old('priority',$complaint->priority)=='low'    ?'selected':'' }}>🟢 Low</option>
                                <option value="medium" {{ old('priority',$complaint->priority)=='medium' ?'selected':'' }}>🔵 Medium</option>
                                <option value="high"   {{ old('priority',$complaint->priority)=='high'   ?'selected':'' }}>🟠 High</option>
                                <option value="urgent" {{ old('priority',$complaint->priority)=='Immediate' ?'selected':'' }}>🔴 Urgent</option>
                            </select>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending"     {{ old('status',$complaint->status)=='pending'     ?'selected':'' }}>⏳ Pending</option>
                            <option value="assigned"    {{ old('status',$complaint->status)=='assigned'    ?'selected':'' }}>📌 Assigned</option>
                            <option value="in_progress" {{ old('status',$complaint->status)=='in_progress' ?'selected':'' }}>🔄 In Progress</option>
                            <option value="resolved"    {{ old('status',$complaint->status)=='resolved'    ?'selected':'' }}>✅ Resolved</option>
                            <option value="closed"      {{ old('status',$complaint->status)=='closed'      ?'selected':'' }}>🔒 Closed</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Admin Note</label>
                        <textarea name="admin_note" rows="2"
                                  class="form-control">{{ old('admin_note', $complaint->admin_note) }}</textarea>
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-check-lg me-2"></i> Update Complaint
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>