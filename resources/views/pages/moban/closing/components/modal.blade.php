<!-- Pickup Modal -->
<div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="pickupModalLabel">Pickup Request?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-4">
                <span>Are you sure you want to pickup this request: </span>
                <h5 id="pickup-ticket" class="fw-bold"></h5>
            </div>
            <div class="modal-body">
                <form id="pickupForm"  method="POST">

                    @method('PUT')
                    @csrf

                    <input type="hidden" value="" name="closing_id">

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">Yes, Pickup!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
