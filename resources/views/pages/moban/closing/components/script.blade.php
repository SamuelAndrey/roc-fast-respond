<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/datatables.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
    $(document).ready(function () {
        const baseUrl = @json(url('/users'));

        $('#closing-table').DataTable({
            responsive: true,
            ordering: false
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
        $(document).on('click', '.pickup-request', function (e) {
            e.preventDefault();

            const id = $(this).data('id');
            const ticket = $(this).data('ticket');

            $('#pickup-id').val(id);
            $('#pickup-ticket').text(ticket);

            $('#pickupForm').attr('action', `${baseUrl}/${id}`);

            $('#pickupModal').modal('show');
        });
    });
</script>
