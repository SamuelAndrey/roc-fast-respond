<!DOCTYPE html>
<html lang="en">

@include('themes.head', ['title' => 'User Agent'])

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

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="addModalLabel">Create agent</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="col-form-label fw-semibold">Full Name</label>
                        <input type="text" class="form-control border-danger shadow-sm" id="name" name="name"
                               placeholder="Agent name" required>
                    </div>

                    <div class="mb-2">
                        <label for="username" class="col-form-label fw-semibold">Username</label>
                        <input type="text" class="form-control border-danger shadow-sm" id="username" name="username"
                               placeholder="Username" required>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="col-form-label fw-semibold">Email</label>
                        <input type="email" class="form-control border-danger shadow-sm" id="email" name="email"
                               placeholder="Email" required>
                    </div>

                    <div class="mb-2">
                        <label for="password" class="col-form-label fw-semibold">Password</label>
                        <input type="password" class="form-control border-danger shadow-sm" id="password"
                               name="password" placeholder="Password" required>
                    </div>

                    <input type="hidden" id="role" name="role" value="agent">

                    <div class="mb-2">
                        <label class="col-form-label fw-semibold">Status</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="active" value="1" checked>
                                <label class="form-check-label" for="active">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0">
                                <label class="form-check-label" for="inactive">Inactive</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="editModalLabel">Edit agent</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">

                    @method('PUT')
                    @csrf

                    <input type="hidden" id="edit-id" name="id">

                    <div class="mb-2">
                        <label for="edit-name" class="col-form-label fw-semibold">Full Name</label>
                        <input type="text" class="form-control border-danger shadow-sm" id="edit-name" name="name"
                               required placeholder="Agent name">
                    </div>

                    <div class="mb-2">
                        <label for="edit-username" class="col-form-label fw-semibold">Username</label>
                        <input type="text" class="form-control border-danger shadow-sm" id="edit-username"
                               name="username" required placeholder="Username">
                    </div>

                    <div class="mb-2">
                        <label for="edit-email" class="col-form-label fw-semibold">Email</label>
                        <input type="email" class="form-control border-danger shadow-sm" id="edit-email" name="email"
                               required placeholder="Email">
                    </div>

                    <div class="mb-2">
                        <label for="password" class="col-form-label fw-semibold">Replace Password</label>
                        <input type="password" class="form-control border-danger shadow-sm" id="password"
                               name="password" value="">
                    </div>

                    <div class="mb-2">
                        <label class="col-form-label fw-semibold">Status</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="edit-active" value="1">
                                <label class="form-check-label" for="edit-active">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="edit-inactive" value="0">
                                <label class="form-check-label" for="edit-inactive">Inactive</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="deleteModalLabel">Delete agent?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>Are you sure you want to delete user </span>
                <span id="delete-name"></span>
            </div>
            <div class="modal-body">
                <form id="deleteForm"  method="POST">

                    @method('DELETE')
                    @csrf

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">No, Keep
                            It.
                        </button>
                        <button type="submit" class="btn btn-danger">Yes, Delete!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('themes.footer')

@include('themes.vendor')

<script>
    $(document).ready(function () {
        const baseUrl = @json(url('/users'));

        $('#user-table').DataTable({
            responsive: true,
        });

        // Edit agent modal
        $(document).on('click', '.edit-agent', function (e) {
            e.preventDefault();

            const id = $(this).data('id');
            const name = $(this).data('name');
            const username = $(this).data('username');
            const email = $(this).data('email');
            const role = $(this).data('role');
            const isActive = $(this).data('is_active');

            $('#edit-id').val(id);
            $('#edit-name').val(name);
            $('#edit-username').val(username);
            $('#edit-email').val(email);
            $('#edit-role').val(role);

            if (isActive === 1) {
                $('#edit-active').prop('checked', true);
            } else {
                $('#edit-inactive').prop('checked', true);
            }

            $('#editForm').attr('action', `${baseUrl}/${id}`);

            $('#editModal').modal('show');
        });

        // Delete agent modal
        $(document).on('click', '.delete-agent', function (e) {
            e.preventDefault();

            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#delete-id').val(id);
            $('#delete-name').text(name + "?");

            $('#deleteForm').attr('action', `${baseUrl}/${id}`);

            $('#deleteModal').modal('show');
        });
    });


</script>

</body>
</html>
