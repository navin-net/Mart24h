@extends('shop.layouts.app')
@section('title','about')
@section('content')
    <div class="contact-header">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">{{__('contact')}}</h1>
            <p class="lead">We'd love to hear from you. Get in touch with our team.</p>
        </div>
    </div>
   <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="row g-4">
                <!-- Contact Form -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card">
                        <h2 class="contact-title">Get in Touch</h2>
                        <p class="contact-subtitle">We'd love to hear from you! Fill out the form below, and we'll get back to you as soon as possible.</p>
                        <form class="contact-form">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" placeholder="Your Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Your Message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100">Send Message</button>
                        </form>
                    </div>
                </div>
                <!-- Contact Info and Map -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-info">
                        <h2 class="contact-title">Contact Information</h2>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-info-text">
                                <h4>Address</h4>
                                <p>123 ShopEase Street, Commerce City, USA</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-info-text">
                                <h4>Phone</h4>
                                <p>+1 (123) 456-7890</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info-text">
                                <h4>Email</h4>
                                <p>support@shopease.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="map-container" data-aos="fade-up" data-aos-delay="300">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d-122.4194156846814!3d37.77492977975971!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808c1d6b1d7b%3A0x9c5a1c7e7f1b2d0b!2sSan%20Francisco%2C%20CA%2C%20USA!5e0!3m2!1sen!2sus!4v1697051234567!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
