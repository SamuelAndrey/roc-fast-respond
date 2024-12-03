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
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="actionModalLabel">Action Closing Request</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>Action for this request:</span>

                <h5 id="action-ticket" class="fw-bold"></h5>
                <pre id="action-message" class="pre-normal mb-0"></pre>

                <span>Timestamp:</span><br>
                <span id="action-created" class="fw-bold"></span>

                <form id="actionForm"  method="POST" action="{{ route('closing.close') }}" class="mt-3">

                    @method('PUT')
                    @csrf

                    <input type="hidden" id="action-id" name="closing_id">
                    <div class="mb-3">
                        <label for="messageArea" class="form-label">Reply Request</label>
                        <textarea class="form-control border-danger shadow-sm" id="messageArea" rows="3"
                                  placeholder="Done bro..." name="action"></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">Reply Request!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
