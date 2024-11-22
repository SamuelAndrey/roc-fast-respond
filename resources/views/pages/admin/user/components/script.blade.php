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
