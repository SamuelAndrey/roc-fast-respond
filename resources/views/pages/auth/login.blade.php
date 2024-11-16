<!DOCTYPE html>
<html lang="en">

@include('themes.head', ['title' => 'login'])

<body>

<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="/" class="logo d-flex align-items-center w-auto">
                                <img src="{{ asset('assets/img/logo-telkom.png') }}" alt="">
                                <span class="d-none d-lg-block">ROC Fast Respond</span>
                            </a>
                        </div><!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                    <p class="text-center small">Enter your username & password to login</p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }} <br>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form class="row g-3 needs-validation" method="post" action="/auth/login">
                                    @csrf
                                    <div class="col-12">
{{--                                        <label for="yourEmailOrUsername" class="form-label">Email Or Username</label>--}}
                                        <div class="input-group has-validation">
                                            <input type="text" name="email_or_username" class="form-control border-danger shadow-sm"
                                                   id="yourEmailOrUsername" required value="{{ old('email_or_username') }}"

                                                    placeholder="Email or username">
                                            <div class="invalid-feedback">Please enter your email or username.</div>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-2">
{{--                                        <label for="yourPassword" class="form-label">Password</label>--}}
                                        <input type="password" name="password" class="form-control border-danger shadow-sm" id="yourPassword"
                                               required placeholder="Password">
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check text-danger">
                                            <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe" value="1">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-danger w-100" type="submit">Login</button>
                                    </div>
                                    <div class="col-12 text-center">
                                        <div class="d-flex align-items-center">
                                            <hr class="flex-grow-1">
                                            <span class="px-2">Or</span>
                                            <hr class="flex-grow-1">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-outline-dark w-100" type="button">
                                            <i class="bi bi-google"></i> Login With Google
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

@include('themes.vendor')

</body>
</html>
