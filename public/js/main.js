/*---------------------------------------------
Template name:  Disilab -  Social Questions and Answers HTML Template
Author:         TechyDevs
Website:         www.techydevs.com
Author Email:   contact@tecydevs.com
----------------------------------------------*/

(function ($) {
    "use strict";
    var $window = $(window);

    $window.on('load', function () {
        var $document = $(document);
        var $dom = $('html, body');
        var bodyEl = $('body');
        var preloader = $('#preloader');
        var togglePassword = $('.toggle-password');
        var userTextEditor = $('.user-text-editor');
        var jsTilt = $('.js-tilt');
        var galleryCarousel = $('.gallery-carousel');
        var recruitingCarousel = $('.recruiting-carousel');
        var testimonialCarousel = $('.testimonial-carousel');
        var internationalTelephoneInput = $('#phone');
        var fileUploaderInput = $('.cv-input');
        var selectContainer = $('.select-container');
        var limitSelect = $('.limit-select');
        var inputTags = $('.input-tags');
        var lazyLoading = $('.lazy');
        var caseCard = $('.case-card');
        var quantityBtn = $('.qtyBtn');
        var companyDetailGallery = $('[data-fancybox="company-detail-gallery"]');
        var backToTopButton = $('#back-to-top');

        /* ======= Preloader ======= */
        preloader.delay('500').fadeOut(200);

        /*=========== Mobile search form close ============*/
        var searchFormClose = $('.search-bar-close, .body-overlay');
        searchFormClose.on('click', function () {
            $('.mobile-search-form, .body-overlay').removeClass('active');
           bodyEl.css({'overflow': 'inherit'});
        });

        /*=========== Main menu open ============*/
        var mainMenuToggle = $('.off-canvas-menu-toggle');
        mainMenuToggle.on('click', function () {
            $('.off-canvas-menu, .body-overlay').addClass('active');
           bodyEl.css({'overflow': 'hidden'});
        });

        /*=========== Main menu close ============*/
        var mainMenuClose = $('.off-canvas-menu-close, .body-overlay');
        mainMenuClose.on('click', function () {
            $('.off-canvas-menu, .body-overlay').removeClass('active');
            bodyEl.css({'overflow': 'inherit'});
        });

        /*=========== User menu open ============*/
        var userMenuToggle = $('.user-off-canvas-menu-toggle');
        userMenuToggle.on('click', function () {
            $('.user-off-canvas-menu, .body-overlay').addClass('active');
            bodyEl.css({'overflow': 'hidden'});
        });

        /*=========== User menu close ============*/
        var userMenuClose = $('.user-off-canvas-menu-close, .body-overlay');
        userMenuClose.on('click', function () {
            $('.user-off-canvas-menu, .body-overlay').removeClass('active');
            bodyEl.css({'overflow': 'inherit'});
        });

        /*=========== Sub menu ============*/
        var dropdowmMenu = $('.off-canvas-menu-list .sub-menu');
        dropdowmMenu.parent('li').children('a').append(function() {
            return '<button class="sub-nav-toggler" type="button"><i class="la la-angle-down"></i></button>';
        });

        /*=========== sub menu ============*/
        var dropMenuToggler = $('.sub-nav-toggler');
        dropMenuToggler.on('click', function() {
            var Self = $(this);
            Self.toggleClass('active');
            Self.parent().parent().toggleClass('active');
            Self.parent().parent().siblings().removeClass('active');
            Self.parent().parent().siblings().children("a").find(".sub-nav-toggler").removeClass("active");
            Self.parent().parent().children('.sub-menu').slideToggle();
            Self.parent().parent().siblings().children('.sub-menu').slideUp();
            return false;
        });

        /* ======= Back to Top Button and navbar scrolling fixed ======= */
        $window.on('scroll', function () {
            if ($(this).scrollTop() > 5) {
                $('.header-area').addClass("fixed-top");
                // add padding top to show content behind header-area
                bodyEl.css('margin-top', $('.header-area').outerHeight() + 'px');
            }else{
                $('.header-area').removeClass("fixed-top");
                // remove padding top from body
                bodyEl.css('margin-top', '0');
            }
            if($(this).scrollTop()>= 300){
                backToTopButton.show(200);
            }else{
                backToTopButton.hide(200);
            }
            scrollNav();
        });

        $document.on('click', '#back-to-top', function () {
            $dom.animate({
                scrollTop:0
            },1000);
        });

        /*========= Anchor Menu scroll animation by click ========*/
        var scrollLink = $('.page-scroll');
        scrollLink.on('click', function(e){
            e.preventDefault();
            var target = $(this.hash);
            $dom.animate({
                scrollTop: (target.offset().top -20)
            },600);
        });
        /*========= Anchor Menu link select by scrolling ========*/
        function scrollNav() {
            var windowScroll = $(window).scrollTop();
            if (windowScroll >= 100) {
                var anchorLink = $('.page-scroll');
                anchorLink.each(function () {
                    var sections = $(this).attr('href');
                    $(sections).each(function () {
                        if ($(this).offset().top <= windowScroll + 100) {
                            var sectionId = $(sections).attr('id');
                            $('.js-scroll-nav li').removeClass('active');
                            $('.js-scroll-nav').find('a[href*=\\#' + sectionId + ']').parent().addClass('active');
                        }
                    });
                });
            }
        }

        /*=========== Bootstrap Tooltip ============*/
        $('[data-toggle="tooltip"]').tooltip();

        /*=========== Bootstrap Popover ============*/
        $('.popover-trigger').popover({
            html: true,
            sanitize: false,
            content: function () {
                return $('.generic-popover').html();
            }
        });

        /*=========== Hide bootstrap popover by clicking outside ============*/
        bodyEl.on('click', function (e) {
            $('[data-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide')
                }
            });
        });

        /*=========== Billed switcher ============*/
        const checkboxInput = document.querySelector('.toggle-input');
        const priceMonth = document.querySelectorAll('.price-month');
        const priceYear = document.querySelectorAll('.price-year');

        if (checkboxInput) {
            checkboxInput.addEventListener('change', () => {
                if (checkboxInput.checked) {
                    priceYear.forEach(price => price.classList.remove('d-none'));
                    priceMonth.forEach(price => price.classList.add('d-none'));
                } else {
                    priceYear.forEach(price => price.classList.add('d-none'));
                    priceMonth.forEach(price => price.classList.remove('d-none'));
                }
            });
        }

        /*==== Show/Hide password of input field =====*/
        togglePassword.on('click', function () {
            var passInput = $('.password-field');
            $(this).toggleClass('active');
            if (passInput.attr('type') === 'password') {
                passInput.attr('type', 'text');
            } else {
                passInput.attr('type', 'password');
            }
        });
        /*=========== modal ============*/
        $document.on('click', '.login-btn', function () {
            $('.login-form').modal('show');
            $('.signup-form, .message-form').modal('hide');
            bodyEl.addClass('modal--open');
        });
        $document.on('click', '.signup-btn', function () {
            $('.login-form, .recover-form').modal('hide');
            $('.signup-form').modal('show');
            bodyEl.addClass('modal--open');
        });
        $document.on('click', '.lost-pass-btn', function () {
            $('.login-form').modal('hide');
            $('.recover-form').modal('show');
            bodyEl.addClass('modal--open');
        });

        /*=========== When body will be clicked it's modal-class hide ============*/
        $document.on('click', function(event){
            if ( !$(event.target).is('.login-form, .signup-form, .recover-form') === false ) {
                bodyEl.removeClass('modal--open');
            }
        });
        /*=========== When close button will be clicked body's modal-class hide ============*/
        $document.on('click', '.close', function(){
            bodyEl.removeClass('modal--open');
        });

        /*=========== Bootstrap tab active bar animation ============*/
        var animBar = $('.anim-bar');
        $document.on('click', '.generic-tabs .nav-link', function() {
            var position = $(this).parent().position();
            var width = $(this).parent().width();
            animBar.css({'left':+ position.left,'width': width});
        });
        var actWidth = $('.generic-tabs').find('.active').parent('li').width();
        var actPosition = $('.generic-tabs .active').position();
        if (animBar.length) {
            animBar.css({'left':+ actPosition.left,'width': actWidth});
        }

        /*=========== disable/enable a button with a checkbox if checked ============*/
        $document.on('click', '#delete-terms', function () {
            var deleteButton = $('#delete-button');
            //check if checkbox is checked
            if ($(this).is(':checked')) {
                deleteButton.removeAttr('disabled'); //enable
            } else {
                deleteButton.attr('disabled', true); //disable
            }
        });
        /*==== Copy to clipboard =====*/
        $document.on('click', '.copy-btn', function(e){
            e.preventDefault();
            var copyInput = $('.copy-input');
            var successMessage = $('.text-success-message');

            // Select the text
            copyInput.select();
            // Copy it
            document.execCommand("copy");
            // Remove focus from the input
            copyInput.blur();
            // Show message
            successMessage.addClass('active');
            // Hide message after 2 seconds
            setTimeout(function () {
                successMessage.removeClass('active');
            }, 2000);
        });
        /*==== js title =====*/
        if (jsTilt.length) {
            jsTilt.tilt({
                maxTilt: 3,
                scale: 1.02
            });
        }
        /*==== Gallery carousel =====*/
        if (galleryCarousel.length) {
            galleryCarousel.owlCarousel({
                items: 3,
                loop: true,
                margin: 15,
                smartSpeed: 800,
                dots: false,
                nav: true,
                navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" height=\"24px\" viewBox=\"0 0 24 24\" width=\"24px\" fill=\"#000000\"><path d=\"M0 0h24v24H0V0z\" fill=\"none\"/><path d=\"M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12l4.58-4.59z\"/></svg>", "<svg xmlns=\"http://www.w3.org/2000/svg\" height=\"24px\" viewBox=\"0 0 24 24\" width=\"24px\" fill=\"#000000\"><path d=\"M0 0h24v24H0V0z\" fill=\"none\"/><path d=\"M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z\"/></svg>"],
                responsive:{
                    0:{
                      items:1
                    },
                    600:{
                        items:3
                    }
                }
            });
        }
        /*==== Recruiting carousel =====*/
        if (recruitingCarousel.length) {
            recruitingCarousel.owlCarousel({
                items: 3,
                loop: false,
                margin: 15,
                smartSpeed: 800,
                dots: false,
                nav: true,
                navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" height=\"24px\" viewBox=\"0 0 24 24\" width=\"24px\" fill=\"#000000\"><path d=\"M0 0h24v24H0V0z\" fill=\"none\"/><path d=\"M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12l4.58-4.59z\"/></svg>", "<svg xmlns=\"http://www.w3.org/2000/svg\" height=\"24px\" viewBox=\"0 0 24 24\" width=\"24px\" fill=\"#000000\"><path d=\"M0 0h24v24H0V0z\" fill=\"none\"/><path d=\"M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z\"/></svg>"],
                responsive:{
                    0:{
                      items:1
                    },
                    600:{
                        items:3
                    }
                }
            });
        }
        /*==== Testimonial carousel =====*/
        if (testimonialCarousel.length) {
            testimonialCarousel.owlCarousel({
                items: 1,
                loop: true,
                margin: 15,
                smartSpeed: 800,
                dots: false,
                nav: true,
                navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" height=\"24px\" viewBox=\"0 0 24 24\" width=\"24px\" fill=\"#000000\"><path d=\"M0 0h24v24H0V0z\" fill=\"none\"/><path d=\"M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12l4.58-4.59z\"/></svg>", "<svg xmlns=\"http://www.w3.org/2000/svg\" height=\"24px\" viewBox=\"0 0 24 24\" width=\"24px\" fill=\"#000000\"><path d=\"M0 0h24v24H0V0z\" fill=\"none\"/><path d=\"M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z\"/></svg>"],
            });
        }
        /*========= International Telephone Dial Codes ========*/
        if (internationalTelephoneInput.length) {
            internationalTelephoneInput.intlTelInput({
                separateDialCode: true,
                utilsScript: "js/utils.js",
            });
        }
        /*========= Resume upload ========*/
        if (fileUploaderInput.length) {
            fileUploaderInput.MultiFile({
                max: 1,
                accept: 'pdf, doc, docx, rtf, html, odf, zip'
            });
        }
        /*==== Chosen select =====*/
        /*if ($(selectContainer).length) {
            $(selectContainer).chosen({
                no_results_text: "Oops, nothing found!"
            });
        }

        $(selectContainer).on('chosen:showing_dropdown', function(event, params) {
            var chosen_container = $( event.target ).next( '.chosen-container' );
            var dropdown = chosen_container.find( '.chosen-drop' );
            var dropdown_top = dropdown.offset().top - $(window).scrollTop();
            var dropdown_height = dropdown.height();
            var viewport_height = $(window).height();

            if ( dropdown_top + dropdown_height > viewport_height ) {
                chosen_container.addClass( 'chosen-drop-up' );
            }
        });

        $(selectContainer).on('chosen:hiding_dropdown', function(event, params) {
            $( event.target ).next( '.chosen-container' ).removeClass( 'chosen-drop-up' );
        });*/

        /*==== Selectize js =====*/
        if (selectContainer.length) {
            selectContainer.selectize();
        }
        if (limitSelect.length) {
            limitSelect.selectize({
                plugins: ['remove_button'],
                maxItems: 5,
            });
        }
        if (inputTags.length) {
            inputTags.selectize({
                persist: false,
                createOnBlur: true,
                create: true,
                maxItems: 5,
                plugins: ['remove_button'],
            });
        }
        /*========== Lazy loading ==========*/
        if (lazyLoading.length) {
            lazyLoading.Lazy();
        }
        /*==== js case card =====*/
        caseCard.on('click', function(){
            $(this).addClass('case-card-is-active');
            $(this).siblings().removeClass('case-card-is-active')
        });

        // Success function
        function doneFunction(response) {
            // setTimeout(function (){
            submitBtn.innerHTML = 'Send Message';
            message.fadeIn().removeClass('alert-danger').addClass('alert-success');
            message.text(response);
            setTimeout(function () {
                message.fadeOut();
            }, 3000);
            form.find('input:not([type="submit"]), textarea').val('');
        }

        // fail function
        function failFunction(data) {
            // setTimeout(function (){
            submitBtn.innerHTML = 'Send Message';
            message.fadeIn().removeClass('alert-success').addClass('alert-danger');
            message.text(data.responseText);
            setTimeout(function () {
                message.fadeOut();
            }, 3000);
        }

        /*==== Quantity number =====*/
        if (quantityBtn.length) {
            quantityBtn.on('click', function () {
                var $this = $(this);
                var oldValue = $this.parent().find('.qtyInput').val();

                if ($this.hasClass('qtyInc')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // don't allow decrementing below zero
                    if (oldValue > 0) {
                        newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }
                $this.parent().find('.qtyInput').val(newVal);
            });
        }
        /*=========== Payment Method Accordion ============*/
        var radioBtn = document.querySelectorAll('.payment-tab-toggle > input');

        for (var i = 0; i < radioBtn.length; i++) {
            radioBtn[i].addEventListener('change', expandAccordion);
        }

        function expandAccordion (event) {
            var allTabs = document.querySelectorAll('.payment-tab');
            for (var i = 0; i < allTabs.length; i++) {
                allTabs[i].classList.remove('is-active');
            }
            event.target.parentNode.parentNode.classList.add('is-active');
        }

        /*=========== Stop Propagation on dropdown menu ============*/
        var dropdownMenuKeepOpen = $('.dropdown-menu.keep-open');
        dropdownMenuKeepOpen.on('click', function (e) {
            e.stopPropagation();
        });

        if (companyDetailGallery.length) {
            companyDetailGallery.fancybox();
        }

    });

    $('body').on('submit', '#thread-form', function (e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let method = 'POST';
        let data = new FormData(this); // Use 'this' directly
    
        $.ajax({
            url: url,
            method: method,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                // Check if redirectUrl is provided in the response
                if (response.redirectUrl) {
                    window.location.href = response.redirectUrl; // Redirect to the new thread
                } else {
                    form.html(response.message); // Show the message as before
                }
            },
            error: function (response) {
                let errors = [];
                if (response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (key, value) {
                        errors.push(value[0]);
                    });
                    alert(errors.join("\n"));
                } else {
                    alert(response.responseJSON.message);
                }
            }
        });
    });    

    $('body').on('click', '.js-report', function (e) {
        let self = $(this)
        let form = $('#report-form')
        form.trigger('reset')
        $('[name="type"]').val(self.data('type'))
        $('[name="id"]').val(self.data('id'))
        $('[name="reason"]').val('')

        $('#input_reason').parent().addClass('hidden')
        $('#modal-report').modal('show')
    })

    $('body').on('change', '#select_reason', function (e) {
        let form = $('#report-form')
        $('[name="reason"]').val($(this).val())

        if($('option:selected', $(this)).hasClass('js-other')) {
            $('#input_reason').parent().removeClass('hidden')
        } else {
            $('#input_reason').parent().addClass('hidden')
        }
    })

    $('body').on('blur', '#input_reason', function (e) {
        let form = $('#report-form')
        $('[name="reason"]', form).val($.trim($(this).val()))
    })

    $('body').on('submit', '#report-form', function (e) {
        e.preventDefault()
        let form = $(this)
        let url = form.attr('action')
        let method = 'POST'
        let data = new FormData($(this)[0]);

        $.ajax({
            url: url,
            method: method,
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#modal-report').modal('hide')
                alert(response.message)
            },
            error: function (response) {
                let errors= [];
                if (response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (key, value) {
                        errors.push(value[0])
                    })
                    alert(errors.join("\n"))
                } else {
                    alert(response.responseJSON.message)
                }
            }
        })
    })

    $('body').on('submit', '#comment-form', function (e) {
        e.preventDefault()
        let form = $(this)
        let url = form.attr('action')
        let method = 'POST'
        let data = new FormData($(this)[0]);

        $.ajax({
            url: url,
            method: method,
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                form.trigger('reset')
                location.reload(true)
            },
            error: function (response) {
                let errors= [];
                if (response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (key, value) {
                        errors.push(value[0])
                    })
                    alert(errors.join("\n"))
                } else {
                    alert(response.responseJSON.message)
                }
            }
        })
    })

    $('body').on('click', '.js-link-edit-answer', function (e) {
        let form = $('#update-answer-form')
        let self = $(this)

        $.ajax({
            url: '/questions/get-answer/' + self.data('id'),
            method: 'GET',
            success: function (response) {
                $('#modal-edit-answer').modal('show')
                $('[name="body"]', form).val(response.body)
                form.attr('action', '/questions/update-answer/' + response.id)
                $('.js-images-list').html('')
                $.each(response.images, function (key, item) {
                    $('.js-images-list').append('' +
                        '<div class="js-answer-image" style="display: inline; padding:5px;">' +
                        '<img src="' + item.url + '" class="img-fluid"><br/>' +
                        '<a href="#" class="js-remove-answer-image" data-id="'+item.id+'"><i class="la la-trash"></i></a>' +
                    '</div>')
                })
            },
            error: function (response) {
                alert(response.responseJSON.message)
            }
        })
    })

    $('body').on('click', '.js-remove-answer-image', function (e) {
        e.preventDefault()
        let form = $('#update-answer-form')
        let self = $(this)
        form.append('<input type="hidden" name="remove_images[]" value="'+self.data('id')+'">')
        self.closest('.js-answer-image').remove()
    })


    $('body').on('submit', '#update-answer-form', function (e) {
        e.preventDefault()
        let form = $(this)
        let url = form.attr('action')
        let method = 'POST'
        let data = new FormData($(this)[0]);

        $.ajax({
            url: url,
            method: method,
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                form.trigger('reset')
                $('#modal-edit-answer').modal('hide')
                location.reload(true)
            },
            error: function (response) {
                let errors= [];
                if (response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (key, value) {
                        errors.push(value[0])
                    })
                    alert(errors.join("\n"))
                } else {
                    alert(response.responseJSON.message)
                }
            }
        })
    })


    $('body').on('submit', '#answer-form', function (e) {
        e.preventDefault()
        let form = $(this)
        let url = form.attr('action')
        let method = 'POST'
        let data = new FormData($(this)[0]);

        $.ajax({
            url: url,
            method: method,
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                form.trigger('reset')
                location.reload(true)
            },
            error: function (response) {
                let errors= [];
                if (response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (key, value) {
                        errors.push(value[0])
                    })
                    alert(errors.join("\n"))
                } else {
                    alert(response.responseJSON.message)
                    if (response.status === 401 || response.responseJSON.message === 'Unauthenticated') {
                        window.location.href = '/signin'; // Redirect to the sign-in page
                    }
                }
            }
        })
    })

    $('body').on('submit', '#profile-form', function (e) {
        e.preventDefault()
        let form = $(this)
        let url = form.attr('action')
        let method = 'POST'
        let data = new FormData($(this)[0]);

        $.ajax({
            url: url,
            method: method,
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.js-avatar').attr('src', response.avatar)
                form.trigger('reset')
                alert(response.message)
            },
            error: function (response) {
                let errors= [];
                if (response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (key, value) {
                        errors.push(value[0])
                    })
                    alert(errors.join("\n"))
                } else {
                    alert(response.responseJSON.message)
                }
            }
        })
    })

})(jQuery);

