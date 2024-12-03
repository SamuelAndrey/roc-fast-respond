<!-- Pickup Modal -->
<div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="pickupModalLabel">Pickup Request?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-4">
                <span>Are you sure want to pickup this request: </span>
                <h5 id="pickup-ticket" class="fw-bold"></h5>
            </div>
            <div class="modal-body">
                <form id="pickupForm"  method="POST" action="{{ route('closing.pickup') }}">

                    @method('PUT')
                    @csrf

                    <input type="hidden" id="pickup-id" name="closing_id">

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


<!-- Action Modal -->
<div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="pickupModalLabel">Action Closing Request</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-4">
                <span>Are you sure want to pickup this request: </span>
                <h5 id="pickup-ticket" class="fw-bold"></h5>
            </div>
            <div class="modal-body">
                <form id="pickupForm"  method="POST" action="{{ route('closing.close') }}">

                    @method('PUT')
                    @csrf

                    <input type="hidden" id="pickup-id" name="closing_id">

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
