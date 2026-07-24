@extends('customer_include.main')

<!-- ================================= -->
<!-- Customer Home Page -->
<!-- ================================= -->

@section('pageSpecificStyles')

<!-- Custom Page Styles -->
<style>

    /* Section Background */
    .section-inner {
        background: #fce4ec !important;
    }

    /* Heading Colors */
    .welcome-box h3,
    .title-block h2,
    .about-contentbox h2,
    .fw-bold,
    .title-block span,
    .about-contentbox span,
    .count-number {
        color: #4a148c !important;
    }

    /* Paragraph Text Colors */
    .welcome-box p,
    .about-contentbox p,
    .card p,
    .contact-row {
        color: #4a148c !important;
    }

    /* Icon Colors */
    .counter-box i,
    .card-body i,
    .contact-row i,
    .scroll-down span {
        color: #7b1fa2 !important;
    }

    /* Card Border */
    .card {
        border-color: #fce4ec !important;
    }

    /* Preloader Animation */
    .preloader-bounce span {
        background-color: #fce4ec !important;
    }

    /* Preloader Background */
    .preloader {
        background-color: #fce4ec !important;
    }

</style>

@endsection

@section('pageSpecificContent')

<div id="video">

    <!-- Page Loading Animation -->
    <div class="preloader">
        <div class="preloader-bounce">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <!-- Salon Logo -->
    <div style="position: fixed; top:20px; left:20px; z-index:1000;">
        <img src="{{ asset('assets/images/scissor.png') }}" width="130" alt="Salon Logo">
    </div>

    <!-- Full Page Sections -->
    <div id="fullpage" class="fullpage-default">

        <!-- ================= Welcome Section ================= -->
        <div class="section animated-row" data-section="slide01">

            <div class="section-inner">

                <div class="welcome-box text-center">

                    <!-- Welcome Heading -->
                    <h3 class="animate"
                        data-animate="fadeInUp"
                        style="color:#4a148c; margin-bottom:20px; font-size:3rem; font-weight:bold;">

                        Welcome to Saloon Sandaliya

                    </h3>

                    <!-- Welcome Description -->
                    <p class="animate" data-animate="fadeInUp">

                        "At Sandaliya, we believe that true beauty is more than just a look — it is a feeling, a confidence, a statement.
                        Our expert stylists are dedicated to crafting a personalized experience tailored to every individual who walks through our doors.
                        From precision cuts to luxurious treatments, we combine artistry with care to ensure you leave not just looking your best,
                        but feeling absolutely extraordinary. Welcome to a place where style meets sophistication."

                    </p>

                    <!-- Scroll Indicator -->
                    <div class="scroll-down next-section animate"
                         data-animate="fadeInUp">

                        <span>Scroll Down</span>

                    </div>

                </div>

            </div>

        </div>

        <!-- ================= About Us Section ================= -->
        <div class="section animated-row" data-section="slide02">

            <div class="section-inner">

                <div class="about-section">

                    <div class="row justify-content-center">

                        <div class="col-lg-8 wide-col-laptop">

                            <div class="row">

                                <!-- About Content -->
                                <div class="col-md-6">

                                    <div class="about-contentbox">

                                        <div class="animate"
                                             data-animate="fadeInUp">

                                            <span>About Us</span>

                                            <h2>Who We Are?</h2>

                                            <p>
                                                Sandaliya is a professional beauty salon dedicated to helping every client
                                                look and feel their best through quality beauty services and customer care.
                                            </p>

                                        </div>

                                        <!-- Salon Statistics -->
                                        <div class="facts-list owl-carousel">

                                            <!-- Satisfaction Rate -->
                                            <div class="item animate" data-animate="fadeInUp">

                                                <div class="counter-box">

                                                    <i class="fa fa-trophy counter-icon"></i>

                                                    <span class="count-number">98%</span>

                                                    Client Satisfaction Rate

                                                </div>

                                            </div>

                                            <!-- Happy Clients -->
                                            <div class="item animate" data-animate="fadeInUp">

                                                <div class="counter-box">

                                                    <i class="fa fa-smile-o counter-icon"></i>

                                                    <span class="count-number">1000+</span>

                                                    Happy Clients

                                                </div>

                                            </div>

                                            <!-- Available Services -->
                                            <div class="item animate" data-animate="fadeInUp">

                                                <div class="counter-box">

                                                    <i class="fa fa-desktop counter-icon"></i>

                                                    <span class="count-number">15+</span>

                                                    Services Offered

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ================= Services Section ================= -->
        <div class="section animated-row" data-section="slide03">

            <div class="section-inner">

                <div class="row justify-content-center">

                    <div class="col-md-10 wide-col-laptop">

                        <!-- Section Title -->
                        <div class="title-block text-center animate"
                             data-animate="fadeInUp">

                            <span>Services</span>

                            <h2>What We Do?</h2>

                        </div>

                        <!-- Service Cards -->
                        <section id="services-section">

                            <div class="container">

                                <div class="row mt-5">

                                    <!-- Hair Cutting -->
                                    <!-- Service Card 01 -->

                                    <!-- Dressing & Hair Coloring -->
                                    <!-- Service Card 02 -->

                                    <!-- Facial & Beauty Treatments -->
                                    <!-- Service Card 03 -->

                                </div>

                            </div>

                        </section>

                    </div>

                </div>

            </div>

        </div>

        <!-- ================= Contact Section ================= -->
        <div class="section animated-row" data-section="slide07">

            <div class="section-inner">

                <div class="row justify-content-center">

                    <div class="col-md-7 wide-col-laptop">

                        <!-- Contact Title -->
                        <div class="title-block animate"
                             data-animate="fadeInUp">

                            <span>Contact</span>

                            <h2>Get In Touch!</h2>

                        </div>

                        <!-- Contact Information -->
                        <div class="contact-section">

                            <div class="row">

                                <div class="col-md-12 animate"
                                     data-animate="fadeInUp">

                                    <div class="contact-box">

                                        <!-- Address -->
                                        <div class="contact-row">
                                            <i class="fa fa-map-marker"></i>
                                            Diyons Upstair, Ingiriya Road, Padukka
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="contact-row">
                                            <i class="fa fa-phone"></i>
                                            0770270452
                                        </div>

                                        <!-- Email Address -->
                                        <div class="contact-row">
                                            <i class="fa fa-envelope"></i>
                                            saloonSandaliya@gmail.com
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@section('pageSpecificScript')

<!-- Page Specific JavaScript -->

@endsection

<!-- ================================= -->
<!-- End Customer Home Page -->
<!-- ================================= -->