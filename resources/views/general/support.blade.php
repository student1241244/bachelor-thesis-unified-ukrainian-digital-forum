<x-standard-2-layout>
<!--======================================
        START HERO AREA
======================================-->
<section class="hero-area bg-white shadow-sm pt-80px pb-80px">
    <span class="icon-shape icon-shape-1"></span>
    <span class="icon-shape icon-shape-2"></span>
    <span class="icon-shape icon-shape-3"></span>
    <span class="icon-shape icon-shape-4"></span>
    <span class="icon-shape icon-shape-5"></span>
    <span class="icon-shape icon-shape-6"></span>
    <span class="icon-shape icon-shape-7"></span>
    <div class="container">
        <div class="hero-content text-center">
            <h2 class="section-title pb-3">We'd love to here from you</h2>
            <p class="section-desc">Your thoughtful suggestions and sincere feedback is important to us.
                <br> Please, feel free to let us know anything you have in your mind.
            </p>
        </div><!-- end hero-content -->
    </div><!-- end container -->
</section>
<!--======================================
        END HERO AREA
======================================-->

<!--======================================
        START CONTACT AREA
======================================-->
<section class="contact-area pt-80px pb-80px">
    <div class="container">
        <form action="php/contact.php" class="contact-form card card-item">
            <div class="card-body row">
                <div class="col-lg-7">
                    <div class="alert alert-success contact-success-message mb-3" role="alert">
                        Thank You! Your message has been sent.
                    </div>
                    <div class="form-group">
                        <label class="fs-14 text-black fw-medium lh-20">Your Name</label>
                        <input type="text" id="name" name="name" class="form-control form--control fs-14" placeholder="e.g. Alex smith">
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <label class="fs-14 text-black fw-medium lh-20">Email <span class="text-gray">(Address never made public)</span></label>
                        <input type="email" id="email" name="email" class="form-control form--control fs-14" placeholder="e.g. alexsmith@gmail.com">
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <label class="fs-14 text-black fw-medium lh-20">Phone Number</label>
                        <input type="tel" id="phone-number" name="phone" class="form-control form--control fs-14" placeholder="Your phone number">
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <label class="fs-14 text-black fw-medium lh-20">Message</label>
                        <textarea id="message" name="message" class="form-control form--control fs-14" rows="6" placeholder="Tell us how we can help you."></textarea>
                    </div><!-- end form-group -->
                    <div class="form-group mb-0">
                        <button id="send-message-btn" class="btn theme-btn" type="submit">Send Message</button>
                    </div><!-- end form-group -->
                </div><!-- end col-lg-7 -->
            </div><!-- end row -->
        </form>
    </div><!-- end container -->
</section>
<!--======================================
        END CONTACT AREA
======================================-->
</x-standard-2-layout>