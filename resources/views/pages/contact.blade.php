@extends('layouts.site')

@section('title', 'Contact | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container">
            <p class="eyebrow">Get in touch</p>

            <h1>We would love to hear from you.</h1>

            <p class="page-intro">
                Have a question about a cake or an upcoming pet celebration?
                Reach out to Coco Cakes and we will be happy to help.
            </p>

            <div class="contact-grid">
                <article class="contact-card">
                    <h2>Location</h2>
                    <p>Barangay 144, Philippines</p>
                </article>

                <article class="contact-card">
                    <h2>Email</h2>
                    <p>
                        <a href="mailto:castrojhannasofhia@gmail.com">
                            castrojhannasofhia@gmail.com
                        </a>
                    </p>
                </article>

                <article class="contact-card">
                    <h2>Order inquiries</h2>
                    <p>
                        Ready to plan a celebration? Visit our
                        <a href="{{ route('order.create') }}">Order page</a>
                        to send a cake request.
                    </p>
                </article>
            </div>
        </div>
    </section>
@endsection