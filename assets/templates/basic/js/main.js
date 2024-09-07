(function ($) {
  ("use strict");
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

    // qty js start here 
    var buttonPlus = $(".qty-btn-plus");
    var buttonMinus = $(".qty-btn-minus")
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

  //  sidebar js start here 
  $(".bar-icon, .dashboard-body__bar-icon").on("click", function () {
    $(".sidebar-menu").addClass("show-sidebar");
    $(".sidebar-overlay").addClass("show");
  });
  $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
    $(".sidebar-menu").removeClass("show-sidebar");
    $(".sidebar-overlay").removeClass("show");
  });
  //  sidebar js end here 

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


  //============== product details slider js end here ==============

  //=================== search box wrapper js start ===================

  $('.search-icon').on('click', function (event) {
    event.stopPropagation(); // Prevent the click event from propagating to the body
    $('.search-field').toggleClass('show-search-field');
  });
  $('.search-field').on('click', function (event) {
    event.stopPropagation(); // Prevent the click event from propagating to the body
    $('.search-field').addClass('show-search-field')
  });
  $('body').on('click', function () {
    $('.search-field').removeClass('show-search-field');
  })
  //======================= search box wrapper js end =======================

  // cancelation js 
  $('.single-product-item__icon').on('click', function () {
    $(this).closest('.single-product-item').addClass('d-none');
  })

  // ========================= Preloader Js Start =====================
  $(window).on("load", function () {
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
