<x-app-layout>
    <x-slot name="header">Complaint Details</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('user.dashboard') }}"
               class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back
            </a>

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-3">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-card">
                {{-- Header --}}
                <div class="p-4"
                     style="background:linear-gradient(135deg,#1e3a5f,#4e9af1);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge bg-white text-primary fw-bold px-3 py-2 mb-2">
                                #{{ $complaint->tracking_number ?? $complaint->id }}
                            </span>
                            <h4 class="text-white fw-bold mb-1">{{ $complaint->title }}</h4>
                            <small class="text-white opacity-75">
                                {{ $complaint->customer_name ?? '' }}
                                @if($complaint->customer_id)
                                    | ID: {{ $complaint->customer_id }}
                                @endif
                            </small>
                        </div>
                        @php
                            $priorityClass = [
                                'low'    => 'bg-secondary',
                                'medium' => 'bg-info text-dark',
                                'high'   => 'bg-warning text-dark',
                                'urgent' => 'bg-danger',
                            ][$complaint->priority] ?? 'bg-secondary';
                        @endphp
                        <span class="badge {{ $priorityClass }} fs-6 px-3 py-2">
                            {{ ucfirst($complaint->priority) }} Priority
                        </span>
                    </div>
                </div>

                <div class="p-4">

                    {{-- Status Progress --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted">Status</label>
                        @php
                            $steps = ['pending','assigned','in_progress','resolved','closed'];
                            $currentIndex = array_search($complaint->status, $steps);
                        @endphp
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach($steps as $i => $step)
                                <div class="d-flex align-items-center gap-1">
                                    <span class="badge rounded-pill px-3 py-2"
                                          style="{{ $i <= $currentIndex
                                            ? 'background:#1e3a5f;color:white;'
                                            : 'background:#e9ecef;color:#6c757d;' }}">
                                        {{ ucfirst(str_replace('_',' ',$step)) }}
                                    </span>
                                    @if(!$loop->last)
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted">Description</label>
                        <div class="p-3 rounded-3 border" style="background:#fafafa;">
                            {{ $complaint->description }}
                        </div>
                    </div>

                    {{-- Notes --}}
                    @if($complaint->admin_note)
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted">Notes</label>
                        <div class="p-3 rounded-3"
                             style="background:#fffbeb;border:1px solid #fde68a;white-space:pre-line;">
                            {{ $complaint->admin_note }}
                        </div>
                    </div>
                    @endif

                    {{-- Admin Attachment (View + Download) --}}
                    @if($complaint->attachment)
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted">
                            <i class="bi bi-paperclip me-1"></i>Admin Attachment
                        </label>
                        <div class="p-3 rounded-3 border">
                            @php
                                $ext = pathinfo($complaint->attachment, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($ext), ['jpg','jpeg','png']);
                            @endphp
                            @if($isImage)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($complaint->attachment) }}"
                                         alt="Attachment"
                                         class="img-fluid rounded"
                                         style="max-height:250px;cursor:pointer;"
                                         onclick="openImageModal('{{ Storage::url($complaint->attachment) }}')">
                                </div>
                            @else
                                <div class="d-flex align-items-center gap-3 p-3 rounded"
                                     style="background:#fff3cd;">
                                    <i class="bi bi-file-earmark-pdf text-danger"
                                       style="font-size:36px;"></i>
                                    <span class="fw-semibold">PDF Document</span>
                                </div>
                            @endif
                            <div class="mt-2 d-flex gap-2">
                                @if($isImage)
                                <button onclick="openImageModal('{{ Storage::url($complaint->attachment) }}')"
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> View
                                </button>
                                @endif
                                <a href="{{ Storage::url($complaint->attachment) }}"
                                   download class="btn btn-sm btn-success">
                                    <i class="bi bi-download me-1"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Branch Attachment (Already uploaded) --}}
                    @if($complaint->branch_attachment)
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted">
                            <i class="bi bi-paperclip me-1"></i>Your Branch Attachment
                        </label>
                        <div class="p-3 rounded-3 border"
                             style="background:#f0f9ff;border-color:#bae6fd !important;">
                            @php
                                $bext = pathinfo($complaint->branch_attachment, PATHINFO_EXTENSION);
                                $bIsImage = in_array(strtolower($bext), ['jpg','jpeg','png']);
                            @endphp
                            @if($bIsImage)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($complaint->branch_attachment) }}"
                                         alt="Branch Attachment"
                                         class="img-fluid rounded"
                                         style="max-height:250px;cursor:pointer;"
                                         onclick="openImageModal('{{ Storage::url($complaint->branch_attachment) }}')">
                                </div>
                            @else
                                <div class="d-flex align-items-center gap-3 p-3 rounded"
                                     style="background:#e0f2fe;">
                                    <i class="bi bi-file-earmark-pdf text-danger"
                                       style="font-size:36px;"></i>
                                    <span class="fw-semibold">Branch PDF Document</span>
                                </div>
                            @endif
                            <div class="mt-2">
                                <a href="{{ Storage::url($complaint->branch_attachment) }}"
                                   download class="btn btn-sm btn-success">
                                    <i class="bi bi-download me-1"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Update Status Form --}}
                    @if(!in_array($complaint->status, ['resolved','closed']))
                    <div class="p-4 rounded-3"
                         style="background:#f0f9ff;border:1px solid #bae6fd;">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-arrow-up-circle me-1"></i>Update Status
                        </h6>
                        <form action="{{ route('user.complaint.status', $complaint) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            {{-- Status --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    New Status <span class="text-danger">*</span>
                                </label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                               name="status" value="in_progress"
                                               id="inprogress"
                                               {{ $complaint->status == 'in_progress' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold text-info"
                                               for="inprogress">
                                            🔄 In Progress
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                               name="status" value="resolved"
                                               id="resolved">
                                        <label class="form-check-label fw-semibold text-success"
                                               for="resolved">
                                            ✅ Resolved
                                        </label>
                                    </div>
                                </div>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Note --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Note (Optional)</label>
                                <textarea name="note" rows="3"
                                          class="form-control"
                                          placeholder="Describe what action was taken..."></textarea>
                            </div>

                            {{-- Branch Attachment Upload --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-paperclip me-1"></i>
                                    Attach File (Optional)
                                </label>
                                <input type="file" name="branch_attachment"
                                       id="branchFileInput"
                                       class="form-control @error('branch_attachment') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       onchange="previewBranchFile(this)">
                                <div class="form-text">
                                    JPG, PNG, PDF — Max 2MB
                                </div>
                                @error('branch_attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Preview Box --}}
                                <div id="branchPreviewBox" class="mt-2" style="display:none;">
                                    <div class="p-2 rounded border"
                                         style="background:#f0f9ff;">
                                        <img id="branchImagePreview"
                                             src="" alt=""
                                             class="img-fluid rounded"
                                             style="max-height:200px;display:none;">
                                        <div id="branchPdfPreview"
                                             class="d-flex align-items-center gap-2"
                                             style="display:none!important;">
                                            <i class="bi bi-file-earmark-pdf text-danger"
                                               style="font-size:30px;"></i>
                                            <span id="branchFileName"
                                                  class="fw-semibold small"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Update Status
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="alert alert-success d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        <div>
                            This complaint is <strong>{{ ucfirst($complaint->status) }}</strong>.
                            No further action needed.
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- Image Modal --}}
    <div id="imageModal"
         style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
                background:rgba(0,0,0,0.85);z-index:9999;
                align-items:center;justify-content:center;">
        <div style="position:relative;max-width:90%;max-height:90vh;">
            <img id="modalImage" src="" alt=""
                 style="max-width:100%;max-height:90vh;border-radius:8px;">
            <button onclick="closeImageModal()"
                    style="position:absolute;top:-15px;right:-15px;
                           background:#fff;border:none;border-radius:50%;
                           width:32px;height:32px;font-size:16px;
                           cursor:pointer;font-weight:bold;">✕</button>
        </div>
    </div>

    <script>
        // Image Modal
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').style.display = 'flex';
        }
        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) closeImageModal();
        });

        // Branch File Preview
        function previewBranchFile(input) {
            const file = input.files[0];
            if (!file) return;

            const previewBox   = document.getElementById('branchPreviewBox');
            const imgPreview   = document.getElementById('branchImagePreview');
            const pdfPreview   = document.getElementById('branchPdfPreview');
            const fileNameSpan = document.getElementById('branchFileName');

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
</x-app-layout>