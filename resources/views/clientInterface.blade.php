@extends('customer_include.main')

@section('pageSpecificStyles')
<style>
    .section-inner {
        background: #fce4ec !important;
    }
    .welcome-box h3, .title-block h2, .about-contentbox h2, .fw-bold, .title-block span, .about-contentbox span, .count-number {
        color: #4a148c !important;
    }
    .welcome-box p, .about-contentbox p, .card p, .contact-row {
        color: #4a148c !important;
    }
    .counter-box i, .card-body i, .contact-row i, .scroll-down span {
        color: #7b1fa2 !important;
    }
    .card {
        border-color: #fce4ec !important;
    }
    .preloader-bounce span {
        background-color:  #fce4ec  !important;
    }
    .preloader {
        background-color: #fce4ec !important;
    }
</style>
@endsection

@section('pageSpecificContent')

<div id="video">

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-bounce">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    
    <div style="position: fixed; top: 20px; left: 20px; z-index: 1000;">
        <img src="{{ asset('assets/images/scissor.png') }}" width="130" alt="">
    </div>

    <!-- Full Page -->
    <div id="fullpage" class="fullpage-default">

        <!-- Slide 01 -->
        <div class="section animated-row" data-section="slide01">
            <div class="section-inner">

                <div class="welcome-box text-center">

                    <h3 class="animate" data-animate="fadeInUp" style="color: #4a148c; margin-bottom: 20px; font-size: 3rem; font-weight: bold;">
                        Welcome to Saloon Sandaliya
                    </h3>

                    <p class="animate" data-animate="fadeInUp" style="color: #4a148c;">
                        
                        "At Sandaliya, we believe that true beauty is more than just a look — it is a feeling, a confidence, a statement. Our expert stylists are dedicated to crafting a personalized experience tailored to every individual who walks through our doors. 
                        From precision cuts to luxurious treatments, we combine artistry with care to ensure you leave not just looking your best, but feeling absolutely extraordinary.
                         Welcome to a place where style meets sophistication. Welcome to saloon Sandaliya"





                    </p>

                    <div class="scroll-down next-section animate" data-animate="fadeInUp">
            
                        <span>Scroll Down</span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Slide 02 -->
        <div class="section animated-row" data-section="slide02">
            <div class="section-inner">

                <div class="about-section">
                    <div class="row justify-content-center">

                        <div class="col-lg-8 wide-col-laptop">
                            <div class="row">

                                <!-- About Content -->
                                <div class="col-md-6">
                                    <div class="about-contentbox">

                                        <div class="animate" data-animate="fadeInUp">
                                            <span>About Us</span>

                                            <h2>Who we are?</h2>

                                            <p>Sandaliya is a best beauty saloon helping you look and feel your absolute best.Our professional team 
                                                brings your satisfaction ,They help you for your absolute beauty.
                                                
                                            
                                            
                                            
                                            .
                                            </p>
                                        </div>

                                        <!-- Facts Slider -->
                                        <div class="facts-list owl-carousel">

                                            <div class="item animate" data-animate="fadeInUp">
                                                <div class="counter-box">
                                                    <i class="fa fa-trophy counter-icon" aria-hidden="true"></i>
                                                    <span class="count-number">98%</span>
                                                    clientSatisfaction Rate 
                                                </div>
                                            </div>

                                            <div class="item animate" data-animate="fadeInUp">
                                                <div class="counter-box">
                                                    <i class="fa fa-smile-o counter-icon" aria-hidden="true"></i>
                                                    <span class="count-number">more than 1000</span>
                                                    Happy Clients
                                                </div>
                                            </div>

                                            <div class="item animate" data-animate="fadeInUp">
                                                <div class="counter-box">
                                                    <i class="fa fa-desktop counter-icon" aria-hidden="true"></i>
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

        <!-- Slide 03 -->
        <div class="section animated-row" data-section="slide03">
            <div class="section-inner">

                <div class="row justify-content-center">

                    <div class="col-md-10 wide-col-laptop">

                        <!-- Title -->
                        <div class="title-block text-center animate" data-animate="fadeInUp">
                            <span>Services</span>
                            <h2>What We Do?</h2>
                        </div>

                        <!-- Services -->
                        <section id="services-section">

                            <div class="container">

                                <div class="row mt-5">

                                    <!-- Card 1 -->
                                    <div class="col-md-4 mb-4">
                                        <div class="card bg-transparent border-light text-center p-4 h-100" style="color: #4a148c;">

                                            <div class="card-body">

                                                <i class="fas fa-cut fa-2x mb-3" style="color: #7b1fa2;"></i>

                                                <h5 class="fw-bold">
                                                    Hair Cutting
                                                </h5>

                                                <p>
                                                    Professional haircuts for men, women and kids.
                                                    Style that suits your personality.
                                                </p>

                                            </div>

                                        </div>
                                    </div>

                                    <!-- Card 2 -->
                                    <div class="col-md-4 mb-4">
                                        <div class="card bg-transparent border-light text-center p-4 h-100" style="color: #4a148c;">

                                            <div class="card-body">

                                                <i class="fas fa-female fa-2x mb-3" style="color: #7b1fa2;"></i>

                                                <h5 class="fw-bold">
                                                    Dressing & Hair Coloring
                                                </h5>

                                                <p>
                                                    Bridal & normal dressings with professional
                                                    hair coloring services.
                                                </p>

                                            </div>

                                        </div>
                                    </div>

                                    <!-- Card 3 -->
                                    <div class="col-md-4 mb-4">
                                        <div class="card bg-transparent border-light text-center p-4 h-100" style="color: #4a148c;">

                                            <div class="card-body">

                                                <i class="fas fa-spa fa-2x mb-3" style="color: #7b1fa2;"></i>

                                                <h5 class="fw-bold">
                                                    Facial & More
                                                </h5>

                                                <p>
                                                    Relaxing facials and other beauty treatments
                                                    for a complete makeover.
                                                </p>

                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>

                        </section>

                    </div>

                </div>

            </div>
        </div>

        <!-- Slide 07 -->
        <div class="section animated-row" data-section="slide07">

            <div class="section-inner">

                <div class="row justify-content-center">

                    <div class="col-md-7 wide-col-laptop">

                        <!-- Title -->
                        <div class="title-block animate" data-animate="fadeInUp">
                            <span>Contact</span>
                            <h2>Get In Touch!</h2>
                        </div>

                        <!-- Contact Section -->
                        <div class="contact-section">

                            <div class="row">

                                <div class="col-md-12 animate" data-animate="fadeInUp">

                                    <div class="contact-box">

                                        <div class="contact-row">
                                            <i class="fa fa-map-marker"></i>
                                            Diyons Upstair, Ingiriya Road, Padukka
                                        </div>

                                        <div class="contact-row">
                                            <i class="fa fa-phone"></i>
                                            0770270452
                                        </div>

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
@endsection