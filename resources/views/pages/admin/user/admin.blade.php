<!DOCTYPE html>
<html lang="en">

@include('themes.head', ['title' => 'Dashboard'])

<body>

@include('themes.header')

@include('themes.sidebar')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>User Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
                        <a href="">
                            <h5 class="card-title mb-4">Admin <i class="bi bi-person-plus-fill"></i></h5>
                        </a>


                        <!-- Table with stripped rows -->
                        <table id="example" class="table table-borderless responsive" style="width:100%">
                            <thead class="table-secondary">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td class="text-primary">#{{ $admin->id }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td class="fw-semibold">{{ $admin->username }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td class="text-primary fw-semibold">{{ $admin->role }}</td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

@include('themes.footer')

@include('themes.vendor')

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
        });
    });
</script>

</body>
</html>
