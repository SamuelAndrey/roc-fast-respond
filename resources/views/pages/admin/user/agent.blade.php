<!DOCTYPE html>
<html lang="en">

@include('themes.head', ['title' => 'Agent'])

<body>

@include('themes.header')

@include('themes.sidebar')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>User Agent</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">User</li>
                <li class="breadcrumb-item active">Agent</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-danger my-4 rounded-2" data-bs-toggle="modal"
                                data-bs-target="#addModal">
                            <i class="bi bi-person-plus-fill"></i> Create agent
                        </button>

                        @include('alerts.error')
                        @include('alerts.success')

                        <!-- Table -->
                        <table id="user-table" class="table table-borderless responsive table-hover" style="width:100%">
                            <thead class="table-danger">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($agents as $agent)
                                <tr>
                                    <td class="text-primary">#{{ $agent->id }}</td>
                                    <td>{{ $agent->name }}</td>
                                    <td class="fw-semibold">{{ $agent->username }}</td>
                                    <td>{{ $agent->email }}</td>
                                    <td class="fw-semibold text-primary">
                                        {{ $agent->role }}
                                    </td>
                                    <td>
                                        <span class="d-flex align-items-center">
                                            <span class="rounded-circle me-2" style="width: 10px; height: 10px; background-color: {{ $agent->is_active ? '#28a745' : '#6c757d' }};"></span>
                                            <span>{{ $agent->is_active ? 'Active' : 'Inactive' }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#"
                                           class="text-reset text-decoration-none me-3 edit-agent"
                                           data-id="{{ $agent->id }}"
                                           data-name="{{ $agent->name }}"
                                           data-username="{{ $agent->username }}"
                                           data-email="{{ $agent->email }}"
                                           data-role="{{ $agent->role }}"
                                           data-is_active="{{ $agent->is_active }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="#" class="text-reset text-decoration-none delete-agent"
                                           data-id="{{ $agent->id }}"
                                           data-name="{{ $agent->name }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <!-- End Table -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

@include('pages.admin.user.components.modal', ['role' => 'agent'])

@include('themes.footer')

@include('themes.vendor')

@include('pages.admin.user.components.script')

</body>
</html>
