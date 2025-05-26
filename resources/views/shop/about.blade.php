@extends('shop.layouts.app')
@section('title','about')
@section('content')
    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="about-card">
                        <h2 class="about-title">Our Story</h2>
                        <p class="about-subtitle">Founded in 2020, ShopEase was born with a vision to make online shopping seamless, affordable, and enjoyable. We started as a small team passionate about delivering quality products and exceptional customer service. Today, we’re proud to serve thousands of customers worldwide, offering a curated selection of electronics, fashion, and home essentials.</p>
                        <p class="about-subtitle">Our commitment to innovation and customer satisfaction drives everything we do, from sourcing sustainable products to ensuring fast and reliable delivery.</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="about-img-container">
                        <img src="https://images.unsplash.com/photo-1556740738-6b4a6d8b8b83?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Our Story">
                    </div>
                </div>
            </div>

            <!-- Mission Section -->
            <div class="row g-4 align-items-center mt-5">
                <div class="col-lg-6 order-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="about-card">
                        <h2 class="about-title">Our Mission</h2>
                        <p class="about-subtitle">At ShopEase, our mission is to empower customers with choice, quality, and convenience. We strive to provide a shopping experience that is not only efficient but also delightful, with a focus on sustainability and community impact.</p>
                        <p class="about-subtitle">We believe in building trust through transparency, offering competitive prices, and supporting eco-friendly practices in our supply chain.</p>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <div class="about-img-container">
                        <img src="https://images.unsplash.com/photo-1516321318423-7d6c536f8852?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Our Mission">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="about-section bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-in">
                <h2 class="about-title">Meet Our Team</h2>
                <p class="about-subtitle">Our dedicated team is the heart of ShopEase, working tirelessly to bring you the best shopping experience.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-card">
                        <div class="team-img-container">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Team Member">
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">John Doe</h3>
                            <p class="team-role">Founder & CEO</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-card">
                        <div class="team-img-container">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Team Member">
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Jane Smith</h3>
                            <p class="team-role">Head of Marketing</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-card">
                        <div class="team-img-container">
                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Team Member">
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Mike Johnson</h3>
                            <p class="team-role">Chief Technology Officer</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="team-card">
                        <div class="team-img-container">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Team Member">
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Sarah Lee</h3>
                            <p class="team-role">Customer Support Lead</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="text-center" data-aos="fade-in">
                <h2 class="cta-title">Join the ShopEase Family</h2>
                <p class="cta-subtitle">Explore our products and experience shopping like never before.</p>
                <a href="products.html" class="btn btn-primary-custom">Shop Now</a>
            </div>
        </div>
    </section>



@endsection
