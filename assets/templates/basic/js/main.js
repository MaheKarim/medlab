(function ($) {
  ("use strict");

  /*========= swiper slider js =========*/

  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    pagination: {
      el: ".swiper-pagination",
      type: "fraction",
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      460: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      767: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
      1399: {
        slidesPerView: 4,
        spaceBetween: 20,
      },
    },

  });

  /*================ swiper slider js end here ================*/

  // ========================= testimonial Slider Js Start ==============
  $(".testimonial-slider").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    Infinity: true,
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 1500,
    dots: false,
    pauseOnHover: true,
    arrows: true,
    prevArrow:
      '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
    nextArrow:
      '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 767,
        settings: {
          arrows: false,
          slidesToShow: 1,
          dots: true,
        },
      },
    ],
  });
  // ========================= testimonial Slider Js End ===================

  // ==========================================
  //      Start Document Ready function
  // ==========================================
  $(document).ready(function () {
    // ========================== category menu sidebar Bar Js Start =====================
    $(".navbar-toggler.header-button").on("click", function () {
      $(".category-menu").addClass("show-sidebar");
      $('.sidebar-overlay').addClass('show');
    });
    $(".sidebar-overlay, .close-sidebar-icon").on("click", function () {
      $(".category-menu").removeClass("show-sidebar");
      $('.sidebar-overlay').removeClass('show');
    });
    // ========================== category menu sidebar Bar Js End =====================

    // ========================== cart sidebar Bar Js Start =====================
    $(".cart-icon").on("click", function () {
      $(".cart-sidebar-area").addClass("active");
      $('.sidebar-overlay').addClass('show');
    });
    $(".sidebar-overlay, .side-sidebar-close-btn").on("click", function () {
      $(".cart-sidebar-area").removeClass("active");
      $('.sidebar-overlay').removeClass('show');
    });
    // ========================== cart sidebar Bar Js End =====================

    // ========================== Small Device Header Menu On Click Dropdown menu collapse Stop Js Start =====================
    $(".dropdown-item").on("click", function () {
      $(this).closest(".dropdown-menu").addClass("d-block");
    });
    // ========================== Small Device Header Menu On Click Dropdown menu collapse Stop Js End =====================

    // ========================== Add Attribute For Bg Image Js Start =====================
    $(".bg-img").css("background", function () {
      var bg = "url(" + $(this).data("background-image") + ")";
      return bg;
    });
    // ========================== Add Attribute For Bg Image Js End =====================

    // ========================== add active class to ul>li top Active current page Js Start =====================
    function dynamicActiveMenuClass(selector) {
      let fileName = window.location.pathname.split("/").reverse()[0];
      selector.find("li").each(function () {
        let anchor = $(this).find("a");
        if ($(anchor).attr("href") == fileName) {
          $(this).addClass("active");
        }
      });
      // if any li has active element add class
      selector.children("li").each(function () {
        if ($(this).find(".active").length) {
          $(this).addClass("active");
        }
      });
      // if no file name return
      if ("" == fileName) {
        selector.find("li").eq(0).addClass("active");
      }
    }
    if ($("ul.sidebar-menu-list").length) {
      dynamicActiveMenuClass($("ul.sidebar-menu-list"));
    }
    // ========================== add active class to ul>li top Active current page Js End =====================

    // ================== Password Show Hide Js Start ==========
    $(".toggle-password").on("click", function () {
      $(this).toggleClass(" fa-eye-slash");
      var input = $($(this).attr("id"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
    // =============== Password Show Hide Js End =================

    // ========================= Slick Slider Js Start ==============
    $(".banner-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 1000,
      speed: 1000,
      dots: false,
      pauseOnHover: true,
      arrows: false,
    });
    // ========================= Slick Slider Js End ===================

    // ========================= product category Slider Js Start ===============
    $('.product-slider').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplaySpeed: 1000,
      pauseOnHover: true,
      speed: 1000,
      dots: false,
      arrows: true,
      prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
      responsive: [
        {
          breakpoint: 1199,
          settings: {
            slidesToShow: 3,
          }
        },

        {
          breakpoint: 767,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 375,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    });
    // ========================= product category Slider Js End ===================
    // magnific popup js start here 
    var videoItem = $(".play-button");
    if (videoItem) {
      videoItem.magnificPopup({
        type: "iframe",
      });
    };
    // ================== Sidebar Menu Js Start ===============
    $(".has-dropdown > a").click(function () {
      $(".sidebar-submenu").slideUp(200);
      if ($(this).parent().hasClass("active")) {
        $(".has-dropdown").removeClass("active");
        $(this).parent().removeClass("active");
      } else {
        $(".has-dropdown").removeClass("active");
        $(this).next(".sidebar-submenu").slideDown(200);
        $(this).parent().addClass("active");
      }
    });
    // Sidebar Dropdown Menu End
    // Sidebar Icon & Overlay js
    $(".navigation-bar").on("click", function () {
      $(".sidebar-menu").addClass("show-sidebar");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
      $(".sidebar-menu").removeClass("show-sidebar");
      $(".sidebar-overlay").removeClass("show");
    });
    // Sidebar Icon & Overlay js
    // ===================== Sidebar Menu Js End =================

  

    // ==================== Dashboard User Profile Dropdown Start ==================
    $(".user-info__button").on("click", function () {
      $(".user-info-dropdown").toggleClass("show");
    });
    $(".user-info__button").attr("tabindex", -1).focus();

    $(".user-info__button").on("focusout", function () {
      $(".user-info-dropdown").removeClass("show");
    });
    // ==================== Dashboard User Profile Dropdown End ==================

    // qty js start here 
    var buttonPlus = $(".qty-btn-plus");
    var buttonMinus = $(".qty-btn-minus");

    var incrementPlus = buttonPlus.click(function () {
      var $n = $(this)
        .parent(".qty-container")
        .find(".input-qty");
      $n.val(Number($n.val()) + 1);
    });

    var incrementMinus = buttonMinus.click(function () {
      var $n = $(this)
        .parent(".qty-container")
        .find(".input-qty");
      var amount = Number($n.val());
      if (amount > 0) {
        $n.val(amount - 1);
      }
    });

    // qty js end here 
  });
  //============== product details slider js start here ==============
  $('.product-details__wrapper').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: false,
    fade: true,
    asNavFor: '.product-details__gallery',
    prevArrow: '<button type="button" class="slick-prev gig-details-thumb-arrow"><i class="las la-long-arrow-alt-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next gig-details-thumb-arrow"><i class="las la-long-arrow-alt-right"></i></button>',
  });

  $('.product-details__gallery').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.product-details__wrapper',
    dots: false,
    arrows: false,

    focusOnSelect: true,
    prevArrow: '<button type="button" class="slick-prev gig-details-arrow"><i class="las la-long-arrow-alt-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next gig-details-arrow"><i class="las la-long-arrow-alt-right"></i></button>',
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 676,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 460,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
    ]
  });

  //============== product details slider js end here ==============

    //=================== search box wrapper js start ===================

    $('.search-icon').on('click', function(event) {
      event.stopPropagation(); // Prevent the click event from propagating to the body
      $('.search-field').toggleClass('show-search-field'); 
    }); 
    $('.search-field').on('click', function (event) {
      event.stopPropagation(); // Prevent the click event from propagating to the body
      $('.search-field').addClass('show-search-field')
    }); 
    $('body').on('click', function() {
      $('.search-field').removeClass('show-search-field'); 
    })
  //======================= search box wrapper js end =======================

  // cancelation js 
  $('.single-product-item__icon').on('click', function() {
   $(this).closest('.single-product-item').addClass('d-none');
  })

  // ========================= Preloader Js Start =====================
  $(window).on("load", function(){
    $('.preloader-wrapper').fadeOut(); 
  })
  // ========================= Preloader Js End=====================

  // // ========================= Header Sticky Js Start ==============
  $(window).on("scroll", function () {
    if ($(window).scrollTop() >= 100) {
      $(".header").addClass("fixed-header");
    } else {
      $(".header").removeClass("fixed-header");
    }
  });
  // // ========================= Header Sticky Js End===================

  // //============================ Scroll To Top Icon Js Start =========
  var btn = $(".scroll-top");

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  });

  btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
  });

})(jQuery);
