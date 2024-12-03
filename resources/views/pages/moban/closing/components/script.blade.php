<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/datatables.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#closing-table').DataTable({
            responsive: true,
            ordering: false,
            paging: false,
            info: false,
        });

        // Pickup closing modal
        $(document).on('click', '.pickup-request', function (e) {
            e.preventDefault();

            const id = $(this).data('id');
            const ticket = $(this).data('ticket');

            $('#pickup-id').val(id);
            $('#pickup-ticket').text(ticket);

            $('#pickupModal').modal('show');
        });
    });
</script>
