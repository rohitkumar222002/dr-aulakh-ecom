@extends('admin.layouts.app')
@section('content')
@push('styles')
<style>
    @media (max-width: 768px) {
    .card-body {
        height: 100vh !important; /* Full height on mobile */
        max-height: none !important; /* Remove max-height */
    }
}
</style>
@endpush
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!--<div class="row">-->
                    <!--    <div class="col-12">-->
                    <!--        <div class="page-title-box d-flex align-items-center justify-content-between">-->
                    <!--            <h4 class="mb-sm-0">Home</h4>-->
                    <!--            <div class="page-title-right">-->
                    <!--                <ol class="breadcrumb m-0">-->
                    <!--                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>-->
                    <!--                    <li class="breadcrumb-item active">Advertiser</li>-->
                    <!--                </ol>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <div class="row">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif
                        <div class="col-12">
                            <div class="card"> 
                                <div id="cardHeader" class="card-header bg-primary d-flex justify-content-between align-items-center position-sticky top-0  shadow" style="z-index: 0;">
                              
                                <h4 class="card-title">Advertiser</h4>
                                <div class="d-flex justify-content-end">

                                <form action="{{ route('admin.clients') }}" method="GET" class="d-flex justify-content-end">
                                <input type="text" name="search" class="form-control me-2" placeholder="Search ..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-light me-2">Search</button>
                                <a href="{{ route('admin.clients') }}" class="btn btn-danger pt-2 me-2">Reset</a>
                            </form>
                                <a href="{{ route('admin.download.advertisers') }}" class="btn btn-dark  pt-2">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                </div>
                            </div>        
                                                    <div class="card-body" style="max-height: 400px; overflow-y: auto;>

                                    <div class="table-responsive">
                                        
                                    <table id="datatable-row-callback"
                                        class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Package</th>
                                                <th>Proirity </th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Store <br><small>(Enabled/Disabled)</small></th>
                                                <th>Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($clients as $index => $client)
                                                <tr>
                                                    <td>
                                                    {{ $index + 1 + ($clients->currentPage() - 1) * $clients->perPage() }}

                                                    </td>
                                                    <td> <strong>{{ $client->name }}</strong>
                                                        <br>
                                                        @isset($client->store->store_name)
                                                            <a href="{{ route('store.detail', $client->store->store_slug) }}"
                                                                target="_blank">
                                                                <span>{{ Str::limit($client->store->store_name, 40, '...') ?? 'N/A' }}</span>
                                                            </a>
                                                        @endisset

                                                    </td>
                                                    <td>{{ $client->phone }}</td>

                                                    <td>
                                                        @php
                                                            $latestPackageOrder = App\Models\Packages\PackageOrder::where(
                                                                'guard',
                                                                'advertiser',
                                                            )
                                                                ->where('user_id', $client->id)
                                                                ->where('package_status', 1)
                                                                ->latest()
                                                                ->first();
                                                        @endphp

                                                        @if ($latestPackageOrder)
                                                            <strong class="badge bg-warning">
                                                                {{ $latestPackageOrder->package_name ?? 'N/A' }}</strong>
                                                        @else
                                                            No package order found.
                                                        @endif
                                                    </td>


                                                    <td>
                                                        @if (isset($client->store->priority))
                                                            <span
                                                                class="badge bg-info">{{ $client->store->priority }}</span>
                                                        @else
                                                            <span>N/A</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($client->status == 1)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>

                                                    <td>{{ $client->created_at->format('d-M-Y') }}</td>

                                                   
                                                    <td>
    @if ($client->store)
        <button id="status-button-{{ $client->store->id }}"
                class="btn btn-sm {{ $client->store->status == 1 ? 'btn-success' : 'btn-danger' }}"
                onclick="toggleStoreStatus({{ $client->store->id }})">
            {{ $client->store->status == 1 ? 'ON' : 'OFF' }}
        </button>
    @else
        <span class="text-muted">No Store</span>
    @endif
</td>

                            </td>
                                                                        <td>
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editClientModal{{ $client->id }}"> <i
                                                                class="fas fa-pencil-alt"></i></button>

                                                        <!-- <button type="button" class="btn btn-danger  delete-btn"
                                                            data-id="{{ $client->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button> -->

                                                        <a href="{{ route('admin.client.view', $client->id) }}"
                                                            target="blank" class="btn btn-info"><i
                                                                class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>

                                                <!-- Edit Client Modal -->
                                                <div class="modal fade" id="editClientModal{{ $client->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="editClientModalLabel{{ $client->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editClientModalLabel{{ $client->id }}">Edit
                                                                    Advertiser</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('admin.clients.update', $client->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="exampleFormControlInput1"
                                                                                class="form-label">Status<span
                                                                                    class="text-danger">*</span></label>
                                                                            <select name="status" class="form-control">
                                                                                <option value="1"
                                                                                    {{ old('status', $client->status) == '1' ? 'selected' : '' }}>
                                                                                    Active</option>
                                                                                <option value="0"
                                                                                    {{ old('status', $client->status) == '0' ? 'selected' : '' }}>
                                                                                    In-Active
                                                                                </option>
                                                                            </select>
                                                                            @error('status')
                                                                                <span class="text-danger" role="alert">
                                                                                    <strong>{{ ucwords($message) }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="name" class="form-label">Store
                                                                                Proirity ( 1 to 1000 )</label>
                                                                            <input type="text" name="priority"
                                                                                class="form-control"
                                                                                value="{{ $client->store->priority ?? '' }}">
                                                                            @error('priority')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>


                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="name">Agent Code</label>
                                                                            <input type="text" name="agent_code"
                                                                                class="form-control"
                                                                                value="{{ $client->agent_code }}">
                                                                            @error('agent_code')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="col-md-6 mb-3">
                                                                            <label>Agent Status Code</label>
                                                                            <select name="agent_code_status"
                                                                                class="form-control">
                                                                                <option value="1"
                                                                                    {{ old('agent_code_status', $client->agent_code_status) == '1' ? 'selected' : '' }}>
                                                                                    Publish</option>
                                                                                <option value="0"
                                                                                    {{ old('agent_code_status', $client->agent_code_status) == '0' ? 'selected' : '' }}>
                                                                                    Draft
                                                                                </option>
                                                                            </select>
                                                                        </div>



                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="name">Name</label>
                                                                            <input type="text" name="name"
                                                                                class="form-control"
                                                                                value="{{ $client->name }}">
                                                                            @error('name')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="email">Email</label>
                                                                            <input type="email" name="email"
                                                                                class="form-control"
                                                                                value="{{ $client->email }}">
                                                                            @error('email')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="phone">Phone</label>
                                                                            <input type="text" name="phone"
                                                                                class="form-control"
                                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                                                maxlength="10"
                                                                                value="{{ $client->phone }}">
                                                                            @error('phone')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="phone_2">Alternate Phone</label>
                                                                            <input type="text" name="phone_2"
                                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                                                maxlength="10" class="form-control"
                                                                                value="{{ $client->phone_2 }}">
                                                                            @error('phone_2')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-12 mb-3">
                                                                            <label for="address">Address</label>
                                                                            <textarea name="address" class="form-control" rows="2">{{ $client->address }}</textarea>
                                                                            @error('address')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-dark"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-success">Save
                                                                        Changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Edit Client Modal -->
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $clients->links('pagination::bootstrap-5') }} 
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    function toggleStoreStatus(storeId) {
        // Send an AJAX request to the backend to toggle the status
        fetch(`/admin/stores/${storeId}/toggle-status`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
        store_id: storeId
    })
})

        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the button appearance based on the new status
                const button = document.getElementById(`status-button-${storeId}`);
                if (data.new_status == 1) {
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-success');
                    button.textContent = 'ON';
                } else {
                    button.classList.remove('btn-success');
                    button.classList.add('btn-danger');
                    button.textContent = 'OFF';
                }
            } else {
                alert('Failed to update store status.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
@endpush