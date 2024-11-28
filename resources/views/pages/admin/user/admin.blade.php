<!DOCTYPE html>
<html lang="en">

@include('pages.admin.user.components.head', ['title' => 'Agent'])

<body>

@include('themes.header')

@include('themes.sidebar')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>User Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">User</li>
                <li class="breadcrumb-item active">Admin</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-danger btn-sm my-4" data-bs-toggle="modal"
                                data-bs-target="#addModal">Create admin
                        </button>

                        @include('alerts.error')
                        @include('alerts.success')

                        <!-- Table -->
                        <table id="user-table" class="table table-borderless responsive table-hover" style="width:100%">
                            <thead class="table-secondary">
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
                            @foreach($admins as $admin)
                                <tr>
                                    <td class="text-primary">#{{ $admin->id }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td class="fw-medium">{{ $admin->username }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td class="fw-medium text-primary">
                                        {{ $admin->role }}
                                    </td>
                                    <td>
                                        <span class="d-flex align-items-center">
                                            <span class="rounded-circle me-2" style="width: 10px; height: 10px; background-color: {{ $admin->is_active ? '#28a745' : '#6c757d' }};"></span>
                                            <span>{{ $admin->is_active ? 'Active' : 'Inactive' }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#"
                                           class="text-reset text-decoration-none me-3 edit-agent"
                                           data-id="{{ $admin->id }}"
                                           data-name="{{ $admin->name }}"
                                           data-username="{{ $admin->username }}"
                                           data-email="{{ $admin->email }}"
                                           data-role="{{ $admin->role }}"
                                           data-is_active="{{ $admin->is_active }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="#" class="text-reset text-decoration-none delete-agent"
                                           data-id="{{ $admin->id }}"
                                           data-name="{{ $admin->name }}">
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

@include('pages.admin.user.components.modal', ['role' => 'admin'])

@include('themes.footer')

@include('pages.admin.user.components.script')

</body>
</html>
