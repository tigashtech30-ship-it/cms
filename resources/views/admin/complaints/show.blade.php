<x-app-layout>
    <x-slot name="header">Complaint Details</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <a href="{{ route('admin.complaints.index') }}"
               class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back
            </a>

            <div class="table-card">
                {{-- Header --}}
                <div class="p-4"
                     style="background:linear-gradient(135deg,#1e3a5f,#4e9af1);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="mb-1">
                                <span class="badge bg-white text-primary fw-bold px-3 py-2">
                                    #{{ $complaint->tracking_number ?? $complaint->id }}
                                </span>
                            </div>
                            <h4 class="text-white fw-bold mb-1">
                                {{ $complaint->title }}
                            </h4>
                            <small class="text-white opacity-75">
                                {{ $complaint->customer_name ?? '' }}
                                @if($complaint->customer_id)
                                    | ID: {{ $complaint->customer_id }}
                                @endif
                                | {{ $complaint->created_at->format('d M Y, h:i A') }}
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
                            {{ ucfirst($complaint->priority) }}
                        </span>
                    </div>
                </div>

                <div class="p-4">

                    {{-- Status Progress --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted">Status Progress</label>
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

                    {{-- Details Grid --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="p-3 rounded-3" style="background:#f8f9fc;">
                                <small class="text-muted d-block mb-1">Branch</small>
                                <span class="fw-semibold">{{ $complaint->branch->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3" style="background:#f8f9fc;">
                                <small class="text-muted d-block mb-1">Category</small>
                                <span class="fw-semibold">
                                    {{ $complaint->category->name ?? '—' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3" style="background:#f8f9fc;">
                                <small class="text-muted d-block mb-1">Registered By</small>
                                <span class="fw-semibold">{{ $complaint->creator->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3" style="background:#f8f9fc;">
                                <small class="text-muted d-block mb-1">Date</small>
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

                    {{-- Admin Note --}}
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
                                {{-- Image Preview --}}
                                <div class="mb-2">
                                    <img src="{{ Storage::url($complaint->attachment) }}"
                                         alt="Attachment"
                                         class="img-fluid rounded"
                                         style="max-height:300px;cursor:pointer;"
                                         onclick="openImageModal('{{ Storage::url($complaint->attachment) }}')">
                                </div>
                            @else
                                {{-- PDF Icon --}}
                                <div class="d-flex align-items-center gap-3 p-3 rounded"
                                     style="background:#fff3cd;">
                                    <i class="bi bi-file-earmark-pdf text-danger"
                                       style="font-size:40px;"></i>
                                    <div>
                                        <div class="fw-semibold">PDF Document</div>
                                        <small class="text-muted">Click download to view</small>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-2 d-flex gap-2">
                                @if($isImage)
                                <button onclick="openImageModal('{{ Storage::url($complaint->attachment) }}')"
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> View Full
                                </button>
                                @endif
                                <a href="{{ Storage::url($complaint->attachment) }}"
                                   download
                                   class="btn btn-sm btn-success">
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
                                <div class="mb-2">
                                    <img src="{{ Storage::url($complaint->branch_attachment) }}"
                                         alt="Branch Attachment"
                                         class="img-fluid rounded"
                                         style="max-height:300px;cursor:pointer;"
                                         onclick="openImageModal('{{ Storage::url($complaint->branch_attachment) }}')">
                                </div>
                            @else
                                <div class="d-flex align-items-center gap-3 p-3 rounded"
                                     style="background:#e0f2fe;">
                                    <i class="bi bi-file-earmark-pdf text-danger"
                                       style="font-size:40px;"></i>
                                    <div>
                                        <div class="fw-semibold">Branch PDF Document</div>
                                        <small class="text-muted">Uploaded by branch</small>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-2 d-flex gap-2">
                                @if($bIsImage)
                                <button onclick="openImageModal('{{ Storage::url($complaint->branch_attachment) }}')"
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> View Full
                                </button>
                                @endif
                                <a href="{{ Storage::url($complaint->branch_attachment) }}"
                                   download
                                   class="btn btn-sm btn-success">
                                    <i class="bi bi-download me-1"></i> Download Branch File
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.complaints.print', $complaint) }}"
                           target="_blank" class="btn btn-success">
                            <i class="bi bi-printer me-1"></i> Print Slip
                        </a>
                        <a href="{{ route('admin.complaints.edit', $complaint) }}"
                           class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.complaints.destroy', $complaint) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this complaint?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
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