@extends('layouts.app')

@section('title', 'Contact' . ' - ' . config('app.name', 'StAutoparts'))

@section('content')

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1>Contact</h1>
            <p class="text-muted">
                Have questions? We'd love to hear from you.
            </p>
        </div>

        <div class="row g-4">

            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <form action="route('contact.store')" method="POST">
        @csrf

        <input type="text" name="name" class="form-control mb-3" placeholder="Name">

        <input type="email" name="email" class="form-control mb-3" placeholder="Email Address">

        <input type="text" name="phone" class="form-control mb-3" placeholder="Phone">

        <input type="text" name="subject" class="form-control mb-3" placeholder="Subject">

        <textarea name="message" class="form-control mb-3" rows="5" placeholder="Message"></textarea>

        <button type="submit" class="btn btn-primary">
            Submit
        </button>
    </form>

                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h4 class="mb-4">Contact Information</h4>

                        <div class="mb-4">
                            <strong>Address</strong>
                            <p class="text-muted mb-0">
                                123 Business Street,<br>
                                Ahmedabad, Gujarat, India
                            </p>
                        </div>

                        <div class="mb-4">
                            <strong>Phone</strong>
                            <p class="text-muted mb-0">
                                +91 98765 43210
                            </p>
                        </div>

                        <div class="mb-4">
                            <strong>Email Address</strong>
                            <p class="text-muted mb-0">
                                info@example.com
                            </p>
                        </div>

                        <div>
                            <strong>Working Hours</strong>
                            <p class="text-muted mb-0">
                                Mon - Sat: 9:00 AM - 6:00 PM
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Google Map -->
        <div class="mt-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <iframe
                        src="https://www.google.com/maps/embed?pb="
                        width="100%"
                        height="400"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection