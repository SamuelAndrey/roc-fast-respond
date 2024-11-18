<!DOCTYPE html>
<html lang="en">

@include('themes.head', ['title' => 'Profile'])

<body>

@include('themes.header')

@include('themes.sidebar')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img
                            src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? ""  }}&bold=true&background=0D8ABC&color=fff&size=128"
                            alt="Profile" class="rounded-circle">
                        <h2> {{ auth()->user()->name }} </h2>
                        <h3> {{ auth()->user()->username }} | <span class="text-primary fw-bold">{{ auth()->user()->role }}</span> </h3>
                        <div class="social-links mt-2">
{{--                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>--}}
{{--                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>--}}
{{--                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>--}}
{{--                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>--}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">
                                    Overview
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">
                                    Change Password
                                </button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            @include('alerts.success')

                            @include('alerts.error')

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">About</h5>
                                <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores
                                    cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure
                                    rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at
                                    unde.</p>

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8"> {{ ucwords(auth()->user()->name) }} </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Username</div>
                                    <div class="col-lg-9 col-md-8">{{ auth()->user()->username ?? "" }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ auth()->user()->email ?? "" }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Role</div>
                                    <div class="col-lg-9 col-md-8">{{ strtoupper(auth()->user()->role ?? "") }}</div>
                                </div>

                            </div>


                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form class="needs-validation" action="{{ route('profile.new.password') }}"
                                      method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-7">
                                            <input name="current_password" type="password" class="form-control"
                                                   id="currentPassword" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-7">
                                            <input name="new_password" type="password" class="form-control"
                                                   id="newPassword" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-7">
                                            <input name="renew_password" type="password" class="form-control"
                                                   id="renewPassword" required>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-danger">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

@include('themes.footer')

@include('themes.vendor')

<script>
    const newPassword = document.getElementById("newPassword")
        , renewPassword = document.getElementById("renewPassword")

    function validatePassword() {
        if (newPassword.value !== renewPassword.value) {
            renewPassword.setCustomValidity("Passwords Don't Match");
            invalidPassword.innerHTML = "no match";
        } else {
            renewPassword.setCustomValidity('');
        }
    }

    newPassword.onchange = validatePassword;
    renewPassword.onkeyup = validatePassword;
</script>

</body>
</html>
