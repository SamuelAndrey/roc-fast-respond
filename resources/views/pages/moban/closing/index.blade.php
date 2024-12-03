<!DOCTYPE html>
<html lang="en">

@include('themes.head.head-min', ['title' => 'Closing'])

<body>

@include('themes.header')

@include('themes.sidebar')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Closing</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Closing</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Recent Closure</h5>

                        @include('alerts.error')
                        @include('alerts.success')
                        <!-- Table -->
                        <table id="closing-table" class="table responsive table-striped nowrap" style="width:100%">
                            <thead class="table-secondary">
                            <tr>
                                <th>Ticket ID</th>
                                <th>Category</th>
                                <th>Message</th>
                                <th>Reason</th>
                                <th>Ticket</th>
                                <th>Status</th>
                                <th class="no-wrap-disable">Pickup By</th>
                                <th>Created</th>
                                <th>Channel</th>
                                <th>Witel</th>
                                <th>Requester</th>
                                <th>Approval</th>
                                <th>Solved</th>
                                <th>Duration (Min)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($closings as $closing)
                                <tr>
                                    <td>{{ $closing->ticket_id }}</td>
                                    <td class="fw-bolder text-danger">{{ strtoupper($closing->category) }}</td>
                                    <td>
                                        <pre class="pre-table form-control">{{ $closing->message }}</pre>
                                    </td>
                                    <td>
                                        <pre class="pre-table">{{ $closing->reason }}</pre>
                                    </td>
                                    <td>
                                        <pre class="pre-table">{{ $closing->ticket }}</pre>
                                    </td>
                                    <td>
                                        @if($closing->status == 0)
                                            <span class="btn btn-sm btn-danger rounded-0"><i
                                                    class="bi bi-hourglass"></i> Awaiting</span>
                                        @elseif($closing->status == 1)
                                            <span class="btn btn-sm btn-warning rounded-0"><i
                                                    class="bi bi-arrow-repeat"></i> OGP</span>
                                        @elseif($closing->status == 2)
                                            <span class="btn btn-sm btn-success rounded-0"><i
                                                    class="bi bi-check-all"></i> Done</span>
                                        @endif
                                    </td>
                                    <td class="no-wrap-disable">
                                        @if(empty($closing->solver))
                                            <span
                                                class="btn btn-sm btn-success rounded-0 fw-bolder shadow-sm pickup-request"
                                                style="cursor: pointer;"
                                                data-ticket="{{ $closing->ticket_id }}"
                                                data-id="{{ $closing->id }}">
                                                <i class="bi bi-box-arrow-in-right"></i> Take
                                            </span>
                                        @else
                                            {{ strtoupper($closing->solver) }}
                                        @endif
                                    </td>
                                    <td>{{ $closing->created_at }}</td>
                                    <td>{{ $closing->channel }}</td>
                                    <td>{{ $closing->witel }}</td>
                                    <td>
                                        <pre class="pre-table">{{ $closing->requester_identity }}</pre>
                                    </td>
                                    <td>
                                        <pre class="pre-table">{{ $closing->approval_identity }}</pre>
                                    </td>
                                    <td>{{ $closing->solved_at }}</td>
                                    <td>{{ $closing->duration }}</td>
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

@include('pages.moban.closing.components.modal', ['role' => 'admin'])

@include('themes.footer')

@include('pages.moban.closing.components.script')

</body>
</html>
