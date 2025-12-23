<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=`device-width`, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!--=====TITLE=======-->
  <title>Bizzstats</title>

  <!--=====FAV ICON=======-->
  <link rel="shortcut icon" href="assets/images/logo/fav-logo.png">

  <!--=====CSS=======-->


  <link href="{{ asset('assets/css/plugins/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />


<!-- CSS Files -->
<link href="{{ asset('LandingPage/assets/css/plugins/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('LandingPage/assets/css/plugins/swiper.bundle.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('LandingPage/assets/css/plugins/fontawesome.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('LandingPage/assets/css/plugins/mobile.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('LandingPage/assets/css/plugins/magnific-popup.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('LandingPage/assets/css/plugins/slick-slider.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('LandingPage/assets/css/plugins/owlcarousel.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('LandingPage/assets/css/plugins/aos.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('LandingPage/assets/css/typography.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('LandingPage/assets/css/master.css') }}" rel="stylesheet" type="text/css">

<!-- JS Files -->
<script src="{{ asset('LandingPage/assets/js/plugins/jquery-3-6-0.min.js') }}"></script>
<style>


@media (min-width: 1400px) {
    .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
        max-width: 1429px !important;
    }
    .genaration2-section-area.sp3{
      padding-bottom: 0px !important;
    }
}
.footer2-section-area {
    position: relative;
    overflow: hidden;
    z-index: 1;
    padding: 0 0 14px 0;
}
.sp3 {
    padding: 100px 0 0px;
}
</style>
</head>

<body>
  <!--===== PRELOADER STARTS =======-->
  <div id="preloader">
    <div class="preloader"><span></span><span></span></div>
  </div>
 <!--===== PRELOADER ENDS =======-->
 
  <!--===== PAGE PROGRESS START=======-->
  <div class="paginacontainer">
    <div class="progress-wrap">
      <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
      </svg>
    </div>
  </div>
<!--===== PAGE PROGRESS END=======-->

  <!--=====HEADER START=======-->
  <header>
    <div class="header-area homepage2 header header-sticky d-none d-lg-block " id="header">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="header-elements">
              <div class="site-logo">
              <!-- <a href="index.html"><img src="{{ asset('LandingPage/assets/images/logo/logo1.png') }}" alt=""></a> -->

              </div>
              <div class="main-menu">
            
                <a href="/login" class="header-btn2">Login</a>
                <!-- <a href="signup.html" class="header-btn3">Sign Up Free</a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!--=====HEADER END =======-->

  <!--===== MOBILE HEADER STARTS =======-->
 <div class="mobile-header mobile-haeder2 d-block d-lg-none">
  <div class="container-fluid">
    <div class="col-12">
      <div class="mobile-header-elements">
        <div class="mobile-logo">
        <!-- <a href="index.html"><img src="{{ asset('LandingPage/assets/images/logo/logo1.png') }}" alt=""></a> -->
        </div>
        <div class="mobile-nav-icon dots-menu">
          <i class="fa-solid fa-bars"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="mobile-sidebar mobile-sidebar2">
  <div class="logosicon-area">
    <div class="logos">
    <!-- <img src="{{ asset('LandingPage/assets/images/logo/logo1.png') }}" alt=""> -->
    </div>
    <div class="menu-close">
      <i class="fa-solid fa-xmark"></i>
    </div>
   </div>
  <div class="mobile-nav mobile-nav2">
    <ul class="mobile-nav-list nav-list2">
      <li><a href="#" >Home </a>
        <ul class="sub-menu">
          <li><a href="#">Multiple Page</a>
          <ul class="sub-menu">
            <li><a href="index.html">Email Marketing</a></li>
            <li><a href="index2.html">Project Managment </a></li>
            <li><a href="index3.html">SEO Software</a></li>
            <li><a href="index4.html">Social Marketing</a></li>
            <li><a href="index5.html">Content Writer</a></li>
            <li><a href="rtl.html">RTL</a></li>
          </ul>
        </li>
        <li><a href="#">Landing Page</a>
          <ul class="sub-menu">
            <li><a href="single-index1.html">Email Marketing</a></li>
            <li><a href="single-index2.html">Project Managment </a></li>
            <li><a href="single-index3.html">SEO Software</a></li>
            <li><a href="single-index4.html">Social Marketing</a></li>
            <li><a href="single-index5.html">Content Writer</a></li>
          </ul>
        </li>
        </ul>
      </li>
      <li><a href="about.html">About</a></li>
      <li><a href="features.html">Features</a></li>
      <li><a href="#">Resource</a>
        <ul class="sub-menu">
          <li><a href="blogv1.html">Blog V1</a></li>
          <li><a href="blogv2.html">Blog V2</a></li>
          <li><a href="blog-left.html">Blog Left</a></li>
          <li><a href="blog-right.html">Blog Right</a></li>
          <li><a href="blog-details.html">Blog Single</a></li>
        </ul>
      </li>
      <li><a href="#">Pages</a>
        <ul class="sub-menu">
          <li><a href="pricing-plan.html">Pricing Plan</a></li>
          <li><a href="testimonial1.html">Testimonials 01</a></li>
          <li><a href="testimonial2.html">Testimonials 02</a></li>
          <li><a href="team.html">Team</a></li>
          <li><a href="login.html">Login</a></li>
          <li><a href="signup.html">Sign Up</a></li>
          <li><a href="forget.html">Forget Password</a></li>
          <li><a href="resetpass.html">Reset Password</a></li>
          <li><a href="verify.html">Verify Email</a></li>
          <li><a href="faq.html">FAQ</a></li>
          <li><a href="download.html">Download</a></li>
                      <li><a href="404.html">404</a></li>
        </ul>
      </li>
      <li><a href="contact.html">Contact</a></li>
    </ul>

    <div class="allmobilesection">
  <a href="/login" class="header-btn2 mobile-get">Login</a>

  <div class="single-footer">
    <h3>Contact Info</h3>
    <div class="footer4-contact-info">

      <!-- Phone Info -->
      <div class="contact-info-single">
        <div class="contact-info-icon">
          <i class="fa-solid fa-phone-volume mr-2"></i>
        </div>
        <div class="contact-info-text">
          <a href="tel:+966539477256">+966 53 947 7256</a>
        </div>
      </div>

      <!-- Email Info -->
      <div class="contact-info-single">
        <div class="contact-info-icon">
          <i class="fa-solid fa-envelope mr-2"></i>
        </div>
        <div class="contact-info-text">
          <a href="mailto:info@techcogg.com">info@techcogg.com</a>
        </div>
      </div>

      <!-- Location Info -->
      <div class="single-footer">
        <h3>Our Location</h3>
        <div class="contact-info-single">
          <div class="contact-info-icon">
            <i class="fa-solid fa-location-dot mr-2"></i>
          </div>
          <div class="contact-info-text">
            <p>
              Head Office:<br> 
              DHL Building # 02, Office Number 04, 2nd floor, Al Jubail, Saudi Arabia
            </p>
            <!--<p>-->
            <!--  Regional Office:<br> -->
            <!--  DHL Building # 02, Office Number 04, 2nd floor, Al Jubail, Saudi Arabia-->
            <!--</p>-->
          </div>
        </div>
      </div>

      <!-- Social Links -->
      <div class="single-footer">
        <h3>Social Links</h3>
        <div class="social-links-mobile-menu">
          <ul>
            <li>
              <a href="#" aria-label="LinkedIn" data-bs-toggle="tooltip" title="LinkedIn">
                <i class="fa-brands fa-linkedin"></i>
              </a>
            </li>
            <li>
              <a href="#" aria-label="Facebook" data-bs-toggle="tooltip" title="Facebook">
                <i class="fa-brands fa-facebook"></i>
              </a>
            </li>
            <li>
              <a href="#" aria-label="Instagram" data-bs-toggle="tooltip" title="Instagram">
                <i class="fa-brands fa-instagram"></i>
              </a>
            </li>
            <li>
              <a href="#" aria-label="TikTok" data-bs-toggle="tooltip" title="TikTok">
                <i class="fa-brands fa-tiktok"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

  </div>
</div>
  <!--===== MOBILE HEADER STARTS =======-->

<!--===== WELCOME STARTS =======-->
<div class="welcome2-section-area" style="background-image: url('{{ asset('\LandingPage/assets/images/background/header2-bg.png') }}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="welcome2-header heading3">
                    <!--<span data-aos="fade-up" data-aos-duration="600">Quad Email Marketing Software </span>-->
                    <h1 data-aos="fade-up" data-aos-duration="800">Unlock Smarter Management with Bizz Stats</h1>
                    <p data-aos="fade-up" data-aos-duration="1000">Manage inventory, track sales, and oversee business operations effortlessly.<br> Our integrated software suite brings precision and productivity to your fingertips!</p>
                    <div data-aos="fade-up" data-aos-duration="1200">
                    <!--  <a href="contact.html" class="header-btn2">Register Now </a>-->
                    <!--<a href="features.html" class="header-btn3">Book Demo</a>-->
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="header-images-area">
                    <div class="header-elements1 reveal">
                      <!--  <img src="#" alt="">-->
                    </div>
                    <div class="header-elements2" data-aos="zoom-out" data-aos-duration="1000">
                    <img src="{{ asset('LandingPage/assets/images/elements/bizzstats.png') }}" alt="" class="aniamtion-key-3">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== WELCOME ENDS =======-->

<!--===== OTHERS STARTS =======-->
<div class="brand2-section-area sp8">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="brand2-header text-center">
                    <h4 data-aos="fade-up" data-aos-duration="1000">Join 500,000 Customer Around the World Who Trust Bizz Stats</h4>
                </div>
            </div>
        </div>
        <div class="space30"></div>
        <div class="row">
        <div class="col-lg-12" data-aos="fade-left" data-aos-duration="1200">
    <div class="brand2-logos">
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo1.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo2.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo3.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo4.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo5.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo1.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo2.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo3.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo4.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo5.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo1.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo2.png') }}" alt="">
        </div>
        <div class="brand2-logo">
            <img src="{{ asset('LandingPage/assets/images/elements/brand2-logo3.png') }}" alt="">
        </div>
    </div>
</div>

        </div>
    </div>
</div>
<!--===== OTHERS ENDS =======-->

<!--===== GENERATION AREA STARTS =======-->
<div class="genaration2-section-area sp3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="genaration2-header text-center heading4">
                    <span data-aos="fade-up" data-aos-duration="800">Reasons to Choose Bizz Stats</span>
                    <h2 data-aos="fade-up" data-aos-duration="1000">Protecting Your Business Assets with Advanced SaaS Technology</h2>
                </div>
            </div>
        </div><!--
        <div class="space60"></div>
        <div class="col-lg-12 m-auto">
          <div class="tabs-area" data-aos="fade-up" data-aos-duration="1000">
            <ul class="nav nav-pills justify-center" id="pills-tab">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-email-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Cold Email Automation</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-hyper-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Hyper-Personalization</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-delivary-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Delivery Suite</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link m-0" id="pills-inbox-tab" data-bs-toggle="pill" data-bs-target="#pills-inbox" type="button" role="tab" aria-controls="pills-inbox" aria-selected="false">Unified Inbox</button>
              </li>
            </ul>
          </div>  -->
          <div class="space60"></div>
           <div class="tabs-content-area">
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" >
                <div class="tabs-contents">
                  <div class="row align-items-center">
                    <div class="col-lg-6">
                     <div class="tabs-images reveal">
                     <img src="{{ asset('LandingPage/assets/images/all-images/lcd-01.png') }}" alt="">

                     </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="tabs-text-area" data-aos="fade-up" data-aos-duration="800">
                        <div class="tabs-icon">
                        <img src="{{ asset('LandingPage/assets/images/icons/cloud-base.svg') }}" alt="">

                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Cloud Based</a>
                          <p>Our cloud-based system offers a secure SSL connection for easy, encrypted access from anywhere in the world. </p>
                        </div>
                      </div>
                      <div class="space20"> </div>
                      <div class="tabs-text-area" data-aos="fade-up" data-aos-duration="1000">
                        <div class="tabs-icon1">
                        <img src="{{ asset('LandingPage/assets/images/icons/integration.svg') }}" alt="">

                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Integrated Business Operations</a>
                          <p>Integrate your CRM with our ERP suite to save time, streamline POS, enhance Inventory Management, and drive seamless business flow.</p>
                        </div>
                      </div>
                      <div class="space20"></div>
                      <div class="tabs-text-area" data-aos="fade-up" data-aos-duration="1200">
                        <div class="tabs-icon2">
                        <img src="{{ asset('LandingPage/assets/images/icons/Data-protection.svg') }}" alt="">

                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Top Level Security</a>
                          <p>SSL technology for secure connectivity. The data centers that host your data are monitored seven days a week, 24 hours a day, each and every day of the year.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-profile" role="tabpanel" >
                <div class="tabs-contents">
                  <div class="row align-items-center">
                    <div class="col-lg-6">
                     <div class="tabs-images reveal">
                     <img src="{{ asset('LandingPage/assets/images/all-images/works-img1.png') }}" alt="">

                     </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="tabs-text-area">
                        <div class="tabs-icon">
                        <img src="{{ asset('LandingPage/assets/images/icons/service-icon1.svg') }}" alt="">

                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Automated Follow -Ups</a>
                          <p>Fueling our mission is a passion for innovation. We at the forefront of technology, consistently </p>
                        </div>
                      </div>
                      <div class="space20"> </div>
                      <div class="tabs-text-area">
                        <div class="tabs-icon1">
                        <img src="{{ asset('LandingPage/assets/images/icons/service-icon2.svg') }}" alt="">

                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Let the best copy win a-z</a>
                          <p>Unlock the full potential of your marketing strategy with our cutting-edge email marketing solutions. </p>
                        </div>
                      </div>
                      <div class="space20"></div>
                      <div class="tabs-text-area">
                        <div class="tabs-icon2">
                        <img src="{{ asset('LandingPage/assets/images/icons/service-icon3.svg') }}" alt="">

                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Verify Your email  by Sending</a>
                          <p>Whether you're a small business looking to connect with your audience or a seasoned marketer seeking </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <!--  <div class="tab-pane fade" id="pills-contact" role="tabpanel">
                <div class="tabs-contents">
                  <div class="row align-items-center">
                    <div class="col-lg-6">
                     <div class="tabs-images">
                      <img src="assets/images/all-images/service2-img1.png" alt="">
                     </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="tabs-text-area">
                        <div class="tabs-icon">
                          <img src="assets/images/icons/service-icon1.svg" alt="">
                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Automated Follow -Ups</a>
                          <p>Fueling our mission is a passion for innovation. We at the forefront of technology, consistently </p>
                        </div>
                      </div>
                      <div class="space20"> </div>
                      <div class="tabs-text-area">
                        <div class="tabs-icon1">
                          <img src="assets/images/icons/service-icon2.svg" alt="">
                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Let the best copy win a-z</a>
                          <p>Unlock the full potential of your marketing strategy with our cutting-edge email marketing solutions. </p>
                        </div>
                      </div>
                      <div class="space20"></div>
                      <div class="tabs-text-area">
                        <div class="tabs-icon2">
                          <img src="assets/images/icons/service-icon3.svg" alt="">
                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Verify Your email  by Sending</a>
                          <p>Whether you're a small business looking to connect with your audience or a seasoned marketer seeking </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-inbox" role="tabpanel" aria-labelledby="pills-inbox-tab" >
                <div class="tabs-contents">
                  <div class="row align-items-center">
                    <div class="col-lg-6">
                     <div class="tabs-images">
                      <img src="assets/images/all-images/works-img1.png" alt="">
                     </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="tabs-text-area">
                        <div class="tabs-icon">
                          <img src="assets/images/icons/service-icon1.svg" alt="">
                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Automated Follow -Ups</a>
                          <p>Fueling our mission is a passion for innovation. We at the forefront of technology, consistently </p>
                        </div>
                      </div>
                      <div class="space20"> </div>
                      <div class="tabs-text-area">
                        <div class="tabs-icon1">
                          <img src="assets/images/icons/service-icon2.svg" alt="">
                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Let the best copy win a-z</a>
                          <p>Unlock the full potential of your marketing strategy with our cutting-edge email marketing solutions. </p>
                        </div>
                      </div>
                      <div class="space20"></div>
                      <div class="tabs-text-area">
                        <div class="tabs-icon2">
                          <img src="assets/images/icons/service-icon3.svg" alt="">
                        </div>
                        <div class="tabs-text">
                          <a href="features.html">Verify Your email  by Sending</a>
                          <p>Whether you're a small business looking to connect with your audience or a seasoned marketer seeking </p>
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
</div>-->
<!--===== GENERATION AREA ENDS =======-->

<!--===== PROCESS AREA STARTS =======-->
<div class="process-section-area sp3">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
        <div class="process-header heading4 text-center">
          <span data-aos="fade-up" data-aos-duration="800">Process</span>
          <h2 data-aos="fade-up" data-aos-duration="1000">A Step-By-Step Guide About Bizzstats</h2>
        </div>
      </div>
    </div>
    <div class="space60"></div>
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="process-images reveal">
        <img src="{{ asset('LandingPage/assets/images/all-images/erp.png') }}" alt="">

        </div>
      </div>
      <div class="col-lg-6">
        <div class="process-images-content heading4">
          <span data-aos="fade-left" data-aos-duration="800">ERP</span>
          <h2 data-aos="fade-left" data-aos-duration="1000">Solutions for Growth</h2>
          <p data-aos="fade-left" data-aos-duration="1200">Bizz Stats offers a powerful ERP solution designed to streamline business operations, POS, and inventory management for real-time data access, improved productivity, and seamless workflow. Our cloud-based platform enhances security, scalability, and efficiency, giving businesses a comprehensive toolset to optimize every aspect of their operations.</p>
        </div>
      </div>
      <div class="process-section2">
      <img src="{{ asset('LandingPage/assets/images/elements/process-elements1.png') }}" alt="" class="process-elements1 d-lg-block d-none">
       <img src="{{ asset('LandingPage/assets/images/elements/process-elements2.png') }}" alt="" class="process-elements2 d-lg-block d-none">

        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="process-images-content heading4">
              <span data-aos="fade-right" data-aos-duration="800">POS</span>
              <h2 data-aos="fade-right" data-aos-duration="1000">POS that performs</h2>
              <p data-aos="fade-right" data-aos-duration="1200">Get speed and performance with Bizz Stats Point of Sale system. Easy to learn, fast to process an order. Extra performance at your fingertips. Everything is where you need it to be: from at-the-counter stock and customer look-ups to on-the-spot purchasing for backorders. Whatever the task, Bizz Stats POS delivers.</p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="process-images reveal">
            <img src="{{ asset('LandingPage/assets/images/all-images/pos-2.png') }}" alt="">

            </div>
          </div>
        </div>
      </div>

      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="process-images reveal">
          <img src="{{ asset('LandingPage/assets/images/all-images/inventry.png') }}" alt="">

          </div>
        </div>
        <div class="col-lg-6">
          <div class="process-images-content heading4">
            <span data-aos="fade-left" data-aos-duration="800">Inventory</span>
            <h2 data-aos="fade-left" data-aos-duration="1000">Advanced Inventory Management</h2>
            <p data-aos="fade-left" data-aos-duration="1200"> Bizz Stats efficiently manage  your inventory with our advanced Inventory Management system. Gain real-time visibility into stock levels, track product movement, and automate reordering processes for optimal efficiency. Streamline operations, reduce costs, and ensure inventory accuracy with our powerful solution.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== PROCESS AREA ENDS =======-->

<!--===== SERVICE AREA STARTS =======--><!--
<div class="service2-section-area sp3" style="background-image: url(assets/images/background/footer-bg2.png); background-repeat: no-repeat; background-size: cover;">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto">
        <div class="service2-header heading4 text-center">
          <span data-aos="fade-up" data-aos-duration="800">Why Choose Us</span>
          <h2 data-aos="fade-up" data-aos-duration="1000">Transform Your Marketing: The Quad Advantage</h2>
        </div>
        <div class="space60"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="service2-bg-area">
          <div class="row">
            <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-duration="1200">
              <div class="service2-box-area text-center">
                <div class="service2-icon">
                  <img src="assets/images/icons/service2-icon1.svg" alt="">
                </div>
                <div class="service2-content">
                  <a href="features.html">Social Media Integration</a>
                  <p>Seamlessly connect and amplify your marketing efforts with Quad’s powerful social media integration feature.</p>
                  <a href="#" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-down" data-aos-duration="1200">
              <div class="service2-box-area text-center">
                <div class="service2-icon1">
                  <img src="assets/images/icons/service2-icon2.svg" alt="">
                </div>
                <div class="service2-content">
                  <a href="features.html">Compliance and Security</a>
                  <p>At Quad we prioritize the security and privacy of your data. Our robust compliance and security measures are designed </p>
                  <a href="#" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-left" data-aos-duration="1200">
              <div class="service2-box-area text-center">
                <div class="service2-icon2">
                  <img src="assets/images/icons/service2-icon3.svg" alt="">
                </div>
                <div class="service2-content">
                  <a href="features.html">Personalised Campaigns</a>
                  <p>Elevate your engagement strategy with personalised campaigns through . We understand the power of tailored messaging</p>
                  <a href="#" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>-->
<!--===== SERVICE AREA ENDS =======-->

<!--===== TEMPLETE AREA STARTS =======-->
<!--<div class="templete1-section-area sp3">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto">
        <div class="templete-header text-center heading4">
          <span data-aos="fade-up" data-aos-duration="800">Email Template</span>
          <h2 data-aos="fade-up" data-aos-duration="1000">Quad Email Template</h2>
        </div>
      </div>
      <div class="space30"></div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="tabs-carousel-area" data-aos="fade-right" data-aos-duration="1000">
          <div class="align-items-start">
            <div class="nav nav-pills" id="v-pills-tab"  aria-orientation="vertical" role="tablist">
              <button class="nav-link active" id="v-pills-all-tab" data-bs-toggle="pill" data-bs-target="#v-pills-all" type="button" role="tab" aria-controls="v-pills-all" aria-selected="true">All</button>
              <button class="nav-link" id="v-pills-Holiday-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Holiday" type="button" role="tab" aria-controls="v-pills-Holiday" aria-selected="false">Holiday</button>
              <button class="nav-link" id="v-pills-Profits-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Profits" type="button" role="tab" aria-controls="v-pills-Profits" aria-selected="false">Non- Profits</button>
              <button class="nav-link" id="v-pills-Monthly-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Monthly" type="button" role="tab" aria-controls="v-pills-Monthly" aria-selected="false">Monthly Newsletter</button>
              <button class="nav-link" id="v-pills-Promo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Promo" type="button" role="tab" aria-controls="v-pills-Promo" aria-selected="false">Promo</button>
              <button class="nav-link" id="v-pills-Christmas-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Christmas" type="button" role="tab" aria-controls="v-pills-Christmas" aria-selected="false">Christmas</button>
            </div>
            <div class="space60"></div>
            <div class="tab-content" id="v-pills-tabContent" data-aos="fade-left" data-aos-duration="1200">
              <div class="tab-pane fade show active" id="v-pills-all" role="tabpanel" aria-labelledby="v-pills-all-tab">
                <div class="tab-carousel-section owl-carousel">
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="v-pills-Holiday" role="tabpanel" aria-labelledby="v-pills-Holiday-tab" >
                <div class="tab-carousel-section owl-carousel">
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="v-pills-Profits" role="tabpanel" aria-labelledby="v-pills-Profits-tab" >
                <div class="tab-carousel-section owl-carousel">
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="v-pills-Monthly" role="tabpanel" aria-labelledby="v-pills-Monthly-tab" >
                <div class="tab-carousel-section owl-carousel">
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="v-pills-Promo" role="tabpanel" aria-labelledby="v-pills-Promo-tab" >
                <div class="tab-carousel-section owl-carousel">
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="v-pills-Christmas" role="tabpanel" aria-labelledby="v-pills-Christmas-tab" >
                <div class="tab-carousel-section owl-carousel">
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img1.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img2.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img3.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
                    </div>
                  </div>
                  <div class="tabs-carousel-img">
                    <img src="assets/images/all-images/templete-img4.png" alt="">
                    <div class="tabs-morebtn">
                      <a href="#" class="header-btn2">Read More</a>
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
</div>-->
<!--===== TEMPLETE AREA ENDS =======-->

<!--===== COMPLAINT AREA STARTS =======-->
<div class="complaint-section-area sp3">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-5">
        <div class="complaint-header heading4">
          <span data-aos="fade-up" data-aos-duration="800">Support</span>
          <h2 data-aos="fade-up" data-aos-duration="1000">24/7 Customer Support</h2>
          <p data-aos="fade-up" data-aos-duration="1000">Our team of <b>Retail</b> and <b> Technical Domain</b> experts is <b> Available 24/7</b>, every day of the year, to empower retailers with support and strategies. We're here to help for your growth, streamline operations, and ensure your business reaches new heights with expert guidance around the clock.</p>
          <div class="complaint-list" data-aos="fade-up" data-aos-duration="1200">
            <ul>
              <li><a href="#"> <img src="{{ asset('LandingPage/assets/images/icons/check-icons1.svg') }}" alt="">World Wide </a></li>
              <li><a href="#"><img src="{{ asset('LandingPage/assets/images/icons/check-icons1.svg') }}" alt=""> Email Coordination</a></li>
            </ul>
            <ul>
              <li><a href="#"> <img src="{{ asset('LandingPage/assets/images/icons/check-icons1.svg') }}" alt="">Track Changes</a></li>
              <li><a href="#"> <img src="{{ asset('LandingPage/assets/images/icons/check-icons1.svg') }}" alt="">Fully Integrated</a></li>
            </ul>
          </div>
          <div class="div" data-aos="fade-up" data-aos-duration="1400">
            <a href="contact.html" class="header-btn2">Learn More</a>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="contact-mail">
          <div class="row">
            <div class="col-lg-6 d-lg-block d-none"></div>
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
              <div class="main-contact-box">
                <div class="main-contact-img d-lg-block d-none">
                  <img src="{{ asset('LandingPage/assets/images/elements/angle-border.png') }}" alt="" class="angle-border">
                  <div class="instagram-icon">
                    <img src="{{ asset('LandingPage/assets/images/icons/instagram.svg') }}" alt="">
                  </div>
                </div>
                <div class="main-contact-content">
                  <div class="mail-icon">
                    <img src="{{ asset('LandingPage/assets/images/icons/mail-img1.svg') }}" alt="">
                  </div>
                  <div class="mail-content">
                    <h3>Mail Support</h3>
                    <p>Benchmark Email makes the <br> tools you need simple</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="space50"></div>
            <div class="col-lg-1 d-lg-block d-none"></div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1200">
              <div class="main-contact-box box2">
                <div class="main-contact-content">
                  <div class="mail-icon">
                    <img src="{{ asset('LandingPage/assets/images/icons/location1.svg') }}" alt="">
                  </div>
                  <div class="mail-content">
                    <h3>Location Tracking</h3>
                    <p>Accelerating your business and <br> raising the bar.</p>
                  </div>
                </div>
                <div class="main-contact-img d-lg-block d-none">
                  <img src="{{ asset('LandingPage/assets/images/elements/angle-border2.png') }}" alt="" class="angle-border">
                  <div class="instagram-icon">
                    <img src="{{ asset('LandingPage/assets/images/icons/gmail.svg') }}" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-5 d-lg-block d-none"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--===== COMPLAINT AREA ENDS =======-->

<!--===== TESTIMONIAL AREA STARTS =======-->
<div class="testimonial2-section-area sp3">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
        <div class="testimonial2-header text-center heading4">
          <span data-aos="fade-up" data-aos-duration="800">Testimonials</span>
          <h2 data-aos="fade-up" data-aos-duration="1000">Our Satisfied Clients</h2>
        </div>
      </div>
    </div>
    <div class="space60"></div>
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="testimonials2-boxarea">
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="" alt="">

                  <div class="man-text">
                    <a href="#">Suncore Immigration Solution</a>
                    <span>info@suncoreimmigration.com</span>
                  </div>
                </div>
                <p class="pera">I've used several email marketing tools, but Bizz Stats has truly stood out for its versatility. The platform adapts to our evolving needs, whether it's a small campaign or a comprehensive series. </p>
                <a href="#">20:06 PM - Dec 23, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img2.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">waseem jewelers</a>
                    <span>Info@waseemjewellers.com</span>
                  </div>
                </div>
                <p class="pera">Our experience with BizzStats has been nothing short of exceptional. The intuitive interface makes it easy for our team to collaborate and create engaging campaigns.  </p>
                <a href="#">20:06 PM - Jan 13, 2024</a>
              </div>
              
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img3.png') }}" alt="">

                  <div class="man-text">
                    <a href="team.html">Aubrey Rice</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera"> We were looking for an email marketing solution that would grow with our startup, and Quad has exceeded our expectations. The responsive design ensures our emails.</p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img1.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Jon Bennet</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">I've used several email marketing tools, but Quad has truly stood out for its versatility. The ease of creating complex automation sequences is unmatched. The platform adapts to our evolving needs, whether it's a small campaign or a comprehensive series. </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img2.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Ralph Ritchie</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">Our experience with [Quad] has been nothing short of exceptional. The intuitive interface makes it easy for our team to collaborate and create engaging campaigns.  </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>
              
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img3.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Aubrey Rice</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera"> We were looking for an email marketing solution that would grow with our startup, and Quad has exceeded our expectations. The responsive design ensures our emails.</p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img1.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Jon Bennet</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">I've used several email marketing tools, but Quad has truly stood out for its versatility. The ease of creating complex automation sequences is unmatched. The platform adapts to our evolving needs, whether it's a small campaign or a comprehensive series. </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img2.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Ralph Ritchie</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">Our experience with [Quad] has been nothing short of exceptional. The intuitive interface makes it easy for our team to collaborate and create engaging campaigns.  </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>
              
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img3.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Aubrey Rice</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera"> We were looking for an email marketing solution that would grow with our startup, and Quad has exceeded our expectations. The responsive design ensures our emails.</p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="testimonials2-boxarea2">
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img4.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Meredith Huels</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">We've tried various email marketing platforms, but Quad stands out. The robust analytics provided insights we never had before, allowing us to fine-tune our campaigns for maximum impact. The automation workflows are a breeze to set up, making our marketing strategy more efficient and effective.  </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img5.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Edward Howe</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">I've been using Quad for my e-commerce business, and the results have been outstanding. The integration with our online store simplified the process. </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>
              
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img3.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Inez Raynor Jr.</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera"> I've been using Quad for my e-commerce business, and the results have been outstanding. The integration with our online store .</p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img4.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Meredith Huels</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">We've tried various email marketing platforms, but Quad stands out. The robust analytics provided insights we never had before, allowing us to fine-tune our campaigns for maximum impact. </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img5.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Edward Howe</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">I've been using Quad for my e-commerce business, and the results have been outstanding. The integration with our online store simplified the process.  </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>
              
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img3.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Inez Raynor Jr.</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera"> I've been using Quad for my e-commerce business, and the results have been outstanding. The integration with our online store.</p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img4.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Meredith Huels</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">We've tried various email marketing platforms, but Quad stands out. The robust analytics provided insights we never had before, allowing us to fine-tune our campaigns for maximum impact </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img5.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Edward Howe</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">I've been using Quad for my e-commerce business, and the results have been outstanding. The integration with our online store simplified the process.  </p>
                <a href="team.html">20:06 PM - June 01, 2023</a>
              </div>
              
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img3.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Inez Raynor Jr.</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera"> I've been using Quad for my e-commerce business, and the results have been outstanding. The integration with our online store simplified the process.</p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="testimonials2-boxarea">
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img7.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Sam Lindgren</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">I've used several email marketing tools, but Quad has truly stood out for its versatility. The ease of creating complex automation sequences is unmatched. The platform adapts to our evolving needs, whether it's a small campaign or a comprehensive series. </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img8.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Spencer Graham</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">Our experience with [Quad] has been nothing short of exceptional. The intuitive interface makes it easy for our team to collaborate and create engaging campaigns.  </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>
              
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img9.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Sidney Swift</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera"> We were looking for an email marketing solution that would grow with our startup, and Quad has exceeded our expectations. The responsive design ensures our emails. </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img7.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Sam Lindgren</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">I've used several email marketing tools, but Quad has truly stood out for its versatility. The ease of creating complex automation sequences is unmatched. The platform adapts to our evolving needs, whether it's a small campaign or a comprehensive series. </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img8.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Spencer Graham</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">Our experience with [Quad] has been nothing short of exceptional. The intuitive interface makes it easy for our team to collaborate and create engaging campaigns.  </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>
              
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img9.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Sidney Swift</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera"> We were looking for an email marketing solution that would grow with our startup, and Quad has exceeded our expectations. The responsive design ensures our emails. </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img7.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Sam Lindgren</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">I've used several email marketing tools, but Quad has truly stood out for its versatility. The ease of creating complex automation sequences is unmatched. The platform adapts to our evolving needs, whether it's a small campaign or a comprehensive series. </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>

              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img8.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Spencer Graham</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera">Our experience with [Quad] has been nothing short of exceptional. The intuitive interface makes it easy for our team to collaborate and create engaging campaigns.  </p>
                <a href="team.html">20:06 PM - June 01, 2023</a>
              </div>
              
              <div class="testimonial2-section-box">
                <div class="testimonials-man">
                <img src="{{ asset('assets/images/all-images/testimonials-img9.png') }}" alt="">
                <div class="man-text">
                    <a href="team.html">Sidney Swift</a>
                    <span>@mygreatinsa</span>
                  </div>
                </div>
                <p class="pera"> We were looking for an email marketing solution that would grow with our startup, and Quad has exceeded our expectations. The responsive design ensures our emails. </p>
                <a href="#">20:06 PM - June 01, 2023</a>
              </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== TESTIMONIAL AREA ENDS =======-->

<!--===== BLOG AREA STARTS =======--><!--
<div class="blog2-section-area sp4">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
        <div class="blog2-header text-center heading4">
          <span data-aos="fade-up" data-aos-duration="800">Blog</span>
          <h2 data-aos="fade-up" data-aos-duration="1000">Mastering Email Marketing: A Comprehensive Guide to Quad</h2>
        </div>
      </div>
    </div>
    <div class="space60"></div>
    <div class="row">
      <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-duration="800">
        <div class="blog-box-area2">
          <div class="blog2-img">
            <img src="assets/images/all-images/blog2-img1.png" alt="">
          </div>
          <div class="blog-all-boxarea">
            <div class="blog-tags-area">
              <a href="blog-details.html">Email Marketing</a>
              <div class="date">
                <a href="#"><img src="assets/images/icons/clock-img1.svg" alt="">Oct 15,2023</a>
              </div>
            </div>
            <div class="blog2-content">
              <a href="blog-details.html">The Power of Email Marketing</a>
              <p>Explain the significance of email marketing in building and ...</p>
              <a href="#" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-duration="1000">
        <div class="blog-box-area2">
          <div class="blog2-img">
            <img src="assets/images/all-images/blog2-img2.png" alt="">
          </div>
          <div class="blog-all-boxarea">
            <div class="blog-tags-area">
              <a href="blog-details.html">Email Marketing</a>
              <div class="date">
                <a href="#"><img src="assets/images/icons/clock-img1.svg" alt="">Oct 15,2023</a>
              </div>
            </div>
            <div class="blog2-content">
              <a href="blog-details.html">Unique Features</a>
              <p>Dive into the unique features that make Quad  stand out discuss customisation...</p>
              <a href="#" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-duration="1200">
        <div class="blog-box-area2">
          <div class="blog2-img">
            <img src="assets/images/all-images/blog2-img3.png" alt="">
          </div>
          <div class="blog-all-boxarea">
            <div class="blog-tags-area">
              <a href="blog-details.html">Email Marketing</a>
              <div class="date">
                <a href="#"><img src="assets/images/icons/clock-img1.svg" alt="">Oct 15,2023</a>
              </div>
            </div>
            <div class="blog2-content">
              <a href="blog-details.html">Real Success Stories</a>
              <p>Share case studies or success stories of businesses have achieved remarkable...</p>
              <a href="#" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>-->
<!--===== BLOG AREA ENDS =======-->

<!--===== FOOTER AREA STARTS =======-->
<div class="footer2-section-area" style="background-image: url('{{ asset('LandingPage/assets/images/background/bg1.png') }}'); background-repeat: no-repeat; background-size: cover; background-position: center;">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 m-auto">
        <div class="footer-header heading2 text-center sp8">
          <h2 data-aos="fade-up" data-aos-duration="1000">Bizz Stats brings precision and productivity to your fingertips</h2>
          <span data-aos="fade-up" data-aos-duration="1200">Transform Your Business  <img src="{{ asset('LandingPage/assets/images/icons/star-icon1.svg') }}" alt="">With Bizz Stats </span>
          <div class="div text-center" data-aos="fade-up" data-aos-duration="1400">
            <a href="contact.html" class="header-btn2">Get Started Now </a>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="footer2-last-section">
          <div class="row">
            <div class="col-lg col-md-6 col-12">
              <div class="footer-auhtor-area">
              <!-- <img src="{{ asset('LandingPage/assets/images/logo/logo2.png') }}" alt=""> -->
              <p>Tailor our Project <br class="d-lg-block d-none"> Management Software to <br class="d-lg-block d-none"> fit your unique processes.</p>
                <ul class="social-links">
                  <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                  <li><a href="#"><i class="fa-brands fa-pinterest"></i></a></li>
                  <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                  <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                </ul>
              </div>
            </div>

            <div class="col-lg col-md-6 col-12">
              <div class="footer-auhtor-area">
                <h3>Features</h3>
                <ul>
                  <li><a href="#">Docs</a></li>
                  <li><a href="#">Integrations</a></li>
                  <li><a href="#">Protection</a></li>
                  <li><a href="#">CLoud-Base</a></li>
                  <li><a href="#">24/7 Support</a></li>
                </ul>
              </div>
            </div>

            <div class="col-lg col-md-6 col-12">
              <div class="footer-auhtor-area">
                <h3>Company</h3>
                <ul>
                  <li><a href="about.html">About</a></li>
                  <li><a href="#">Customer Stories</a></li>
                  <li><a href="#">Become a Partner</a></li>
                  <li><a href="#">Become a Partner</a></li>
                  <li><a href="#">Emergency Response</a></li>
                  <li><a href="#">Quad-U</a></li>
                </ul>
              </div>
            </div>

            <div class="col-lg col-md-6 col-12">
              <div class="footer-auhtor-area">
                <h3>Resources</h3>
                <ul>
                  <li><a href="#">Community</a></li>
                  <li><a href="blog-details.html">Blog</a></li>
                  <li><a href="#">Academy</a></li>
                  <li><a href="#">App Development</a></li>
                  <li><a href="#">Sass & Startup</a></li>
                  <li><a href="#">Find a Partner</a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="copyright-social-area">
                <ul>
                  <li class="copy"><p>Copyright @2024 Quad. All Right Reserved</p></li>
                </ul>
                <ul>
                  <li><a>Your Privacy</a></li>
                  <li class="terms"><a>Terms</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== FOOTER ENDS =======-->

<!--=====JS=======-->
<script src="{{ asset('LandingPage/assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/plugins/swiper.bundle.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/plugins/mobilemenu.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/plugins/slick-slider.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/plugins/owlcarousel.min.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/plugins/counter.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/plugins/waypoints.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/plugins/aos.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/plugins/gsap.min.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/plugins/magnific-popup.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/plugins/ScrollTrigger.min.js') }}"></script>
<script src="{{ asset('LandingPage/assets/js/main.js') }}"></script>

</body>
</html>