<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="addModalLabel">Create {{ $role }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="col-form-label fw-semibold">Full Name</label>
                        <input type="text" class="form-control border-danger shadow-sm" id="name" name="name"
                               placeholder="{{ ucwords($role) }} name" required>
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

                    <input type="hidden" id="role" name="role" value="{{ $role }}">

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
                <h1 class="modal-title fs-5 fw-bold" id="editModalLabel">Edit {{ $role }}</h1>
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
                               required placeholder="{{ ucwords($role) }} name">
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
                <h1 class="modal-title fs-5 fw-bold" id="deleteModalLabel">Delete {{ $role }}?</h1>
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

