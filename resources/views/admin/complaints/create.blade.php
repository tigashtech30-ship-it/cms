<x-app-layout>
    <x-slot name="header">Register New Complaint</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('admin.complaints.index') }}"
               class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back
            </a>

            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-clipboard-plus" style="font-size:32px;"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">New Complaint</h5>
                            <small class="opacity-75">
                                Customer ID automatically becomes Tracking Number
                            </small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.complaints.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="p-4">
                    @csrf

                    {{-- Customer Info --}}
                    <div class="p-3 rounded-3 mb-4"
                         style="background:#f0f9ff;border:1px solid #bae6fd;">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-person-badge me-2"></i>
                            Customer Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    Customer ID / Account No
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="bi bi-hash"></i>
                                    </span>
                                    <input type="text" name="customer_id"
                                           value="{{ old('customer_id') }}"
                                           class="form-control @error('customer_id') is-invalid @enderror"
                                           placeholder="eg: 2024001234">
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text text-primary fw-semibold">
                                    <i class="bi bi-info-circle me-1"></i>
                                    இந்த ID-யே Tracking Number ஆகும்!
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    Customer Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="customer_name"
                                       value="{{ old('customer_name') }}"
                                       class="form-control @error('customer_name') is-invalid @enderror"
                                       placeholder="eg: John Smith">
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Complaint Type --}}
<div class="mb-4">
    <label class="form-label fw-semibold text-primary">
        Complaint Type <span class="text-danger">*</span>
    </label>
    <div class="d-flex gap-4 mt-2">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio"
                   name="complaint_type"
                   id="assessment_tax_payer"
                   value="assessment_tax_payer"
                   {{ old('complaint_type') == 'assessment_tax_payer' ? 'checked' : '' }}
                   required>
            <label class="form-check-label fw-semibold"
                   for="assessment_tax_payer"
                   style="color:#1e3a5f;">
                🏦 Assessment Tax Payer
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio"
                   name="complaint_type"
                   id="general_complaint"
                   value="general_complaint"
                   {{ old('complaint_type', 'general_complaint') == 'general_complaint' ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold"
                   for="general_complaint"
                   style="color:#1e3a5f;">
                📝 General Complaint
            </label>
                    </div>
                 </div>
                        @error('complaint_type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        </div>
                        </div>
                    </div>

                    {{-- Complaint Info --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Complaint Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title"
                               value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Brief complaint title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Description <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Describe the complaint in detail...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Category --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                Department / Category
                                <span class="text-danger">*</span>
                            </label>
                            <select name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Branch --}}
                        <div class="col-md-6">
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
                    </div>

                    {{-- Priority --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Priority <span class="text-danger">*</span>
                        </label>
                        <select name="priority"
                                class="form-select @error('priority') is-invalid @enderror">
                            <option value="">-- Select Priority --</option>
                            <option value="low"    {{ old('priority')=='low'    ?'selected':'' }}>🟢 Low (within 7 days)</option>
                            <option value="medium" {{ old('priority')=='medium' ?'selected':'' }}>🔵 Medium (within 4 days)</option>
                            <option value="high"   {{ old('priority')=='high'   ?'selected':'' }}>🟠 High (within 2 days)</option>
                            <option value="Immediate" {{ old('priority')=='Immediate' ?'selected':'' }}>🔴 Immediate (within 24 hours)</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- File Attachment --}}
                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-paperclip me-1"></i>Attachment (Optional)
                    </label>
                    <input type="file" name="attachment"
                        id="adminFileInput"
                        class="form-control @error('attachment') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.pdf"
                        onchange="previewAdminFile(this)">
                    <div class="form-text">JPG, PNG, PDF — Max 2MB</div>
                    @error('attachment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Preview Box --}}
                    <div id="adminPreviewBox" class="mt-2" style="display:none;">
                        <div class="p-2 rounded border" style="background:#f8f9fc;">
                            <img id="adminImagePreview" src="" alt=""
                                class="img-fluid rounded"
                                style="max-height:200px;display:none;">
                            <div id="adminPdfPreview"
                                class="d-flex align-items-center gap-2"
                                style="display:none!important;">
                                <i class="bi bi-file-earmark-pdf text-danger"
                                style="font-size:30px;"></i>
                                <span id="adminFileName" class="fw-semibold small"></span>
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- Admin Note --}}
                    <div class="mb-4">
                        <label class="form-label">Admin Note (Optional)</label>
                        <textarea name="admin_note" rows="2"
                                  class="form-control"
                                  placeholder="Special instructions...">{{ old('admin_note') }}</textarea>
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-clipboard-plus me-2"></i>
                        Register Complaint
                    </button>
                    <script>
                    function previewAdminFile(input) {
                        const file = input.files[0];
                        if (!file) return;

                        const previewBox   = document.getElementById('adminPreviewBox');
                        const imgPreview   = document.getElementById('adminImagePreview');
                        const pdfPreview   = document.getElementById('adminPdfPreview');
                        const fileNameSpan = document.getElementById('adminFileName');

                        previewBox.style.display = 'block';

                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = e => {
                                imgPreview.src = e.target.result;
                                imgPreview.style.display = 'block';
                                pdfPreview.style.display = 'none';
                            };
                            reader.readAsDataURL(file);
                        } else {
                            imgPreview.style.display = 'none';
                            pdfPreview.style.display = 'flex';
                            fileNameSpan.textContent = file.name;
                        }
                    }
                    </script>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>