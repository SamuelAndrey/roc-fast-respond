<!DOCTYPE html>
<html lang="en">

@include('themes.head', ['title' => '500 Server Error'])

<body>

<main>
    <div class="container">

        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h1 class="text-danger">500</h1>
            <h2>Server error.</h2>
            <a class="btn bg-danger" href="/">Back to home</a>
            <img src="{{ asset('assets/img/not-found.svg') }}" class="py-5" alt="Page Not Found">
        </section>

    </div>
</main>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('themes.vendor')

</body>
</html>
