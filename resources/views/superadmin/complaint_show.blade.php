<x-app-layout>
    <x-slot name="header">Complaint Details — Monitor</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <a href="{{ route('superadmin.complaints') }}"
               class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back
            </a>

            <div class="table-card">
                <div class="p-4"
                     style="background:linear-gradient(135deg,#1a1a2e,#4e9af1);">
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
                        <span class="badge {{ $priorityClass }} fs-6">
                            {{ ucfirst($complaint->priority) }}
                        </span>
                    </div>
                </div>

                <div class="p-4">

                    {{-- Details --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="p-3 rounded-3" style="background:#f8f9fc;">
                                <small class="text-muted d-block">Branch</small>
                                <span class="fw-semibold">{{ $complaint->branch->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3" style="background:#f8f9fc;">
                                <small class="text-muted d-block">Category</small>
                                <span class="fw-semibold">
                                    {{ $complaint->category->name ?? '—' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3" style="background:#f8f9fc;">
                                <small class="text-muted d-block">Status</small>
                                <span class="fw-semibold">
                                    {{ ucfirst(str_replace('_',' ',$complaint->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3" style="background:#f8f9fc;">
                                <small class="text-muted d-block">Date</small>
                                <span class="fw-semibold">
                                    {{ $complaint->created_at->format('d M Y') }}
                                </span>
                            </div>
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

                    {{-- Admin Attachment --}}
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
                                <img src="{{ Storage::url($complaint->attachment) }}"
                                     class="img-fluid rounded mb-2"
                                     style="max-height:250px;cursor:pointer;"
                                     onclick="openImageModal('{{ Storage::url($complaint->attachment) }}')">
                            @else
                                <div class="d-flex align-items-center gap-3 p-3"
                                     style="background:#fff3cd;border-radius:8px;">
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

                    {{-- Branch Attachment --}}
                    @if($complaint->branch_attachment)
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted">
                            <i class="bi bi-paperclip me-1"></i>Branch Attachment
                        </label>
                        <div class="p-3 rounded-3 border"
                             style="background:#f0f9ff;border-color:#bae6fd !important;">
                            @php
                                $bext = pathinfo($complaint->branch_attachment, PATHINFO_EXTENSION);
                                $bIsImage = in_array(strtolower($bext), ['jpg','jpeg','png']);
                            @endphp
                            @if($bIsImage)
                                <img src="{{ Storage::url($complaint->branch_attachment) }}"
                                     class="img-fluid rounded mb-2"
                                     style="max-height:250px;cursor:pointer;"
                                     onclick="openImageModal('{{ Storage::url($complaint->branch_attachment) }}')">
                            @else
                                <div class="d-flex align-items-center gap-3 p-3"
                                     style="background:#e0f2fe;border-radius:8px;">
                                    <i class="bi bi-file-earmark-pdf text-danger"
                                       style="font-size:36px;"></i>
                                    <span class="fw-semibold">Branch PDF Document</span>
                                </div>
                            @endif
                            <div class="mt-2 d-flex gap-2">
                                @if($bIsImage)
                                <button onclick="openImageModal('{{ Storage::url($complaint->branch_attachment) }}')"
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> View
                                </button>
                                @endif
                                <a href="{{ Storage::url($complaint->branch_attachment) }}"
                                   download class="btn btn-sm btn-success">
                                    <i class="bi bi-download me-1"></i> Download
                                </a>
                            </div>
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
    </script>
</x-app-layout>