<x-app-layout>
    <x-slot name="header">Admin Dashboard</x-slot>

    {{-- Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card stat-card-1">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total Branches</div>
                        <div class="number">{{ \App\Models\Branch::count() }}</div>
                    </div>
                    <i class="bi bi-building icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total Users</div>
                        <div class="number">{{ \App\Models\User::where('role','user')->count() }}</div>
                    </div>
                    <i class="bi bi-people icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total Complaints</div>
                        <div class="number">{{ \App\Models\Complaint::count() }}</div>
                    </div>
                    <i class="bi bi-clipboard-data icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background:linear-gradient(135deg,#4facfe,#00f2fe);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Resolved</div>
                        <div class="number">{{ \App\Models\Complaint::whereIn('status',['resolved','closed'])->count() }}</div>
                    </div>
                    <i class="bi bi-check-circle icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Access Cards --}}
    <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('admin.branches.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-3 h-100 p-3"
                     style="transition:0.2s;cursor:pointer;"
                     onmouseover="this.style.transform='translateY(-3px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-building text-primary" style="font-size:40px;"></i>
                        <h5 class="mt-3 fw-bold text-dark">Branch Management</h5>
                        <p class="text-muted small">Manage all 27 branches</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-3 h-100 p-3"
                     style="transition:0.2s;cursor:pointer;"
                     onmouseover="this.style.transform='translateY(-3px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-people text-success" style="font-size:40px;"></i>
                        <h5 class="mt-3 fw-bold text-dark">User Management</h5>
                        <p class="text-muted small">Manage branch users</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.complaints.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-3 h-100 p-3"
                     style="transition:0.2s;cursor:pointer;"
                     onmouseover="this.style.transform='translateY(-3px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-clipboard-data text-warning" style="font-size:40px;"></i>
                        <h5 class="mt-3 fw-bold text-dark">Complaints</h5>
                        <p class="text-muted small">Register & manage complaints</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>