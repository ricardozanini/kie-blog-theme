(function () {

  /**
   * "Read more" mechanism used on posts.
   */
  function readMore(postId) {
    var excerpt = document.querySelector("#excerpt-" + postId);
    var content = document.querySelector("#content-" + postId);

    content.removeAttribute("hidden");
    excerpt.setAttribute("hidden", true);
  }

  /**
   * "See more" mechanism used on sidebar to show more authors.
   */
  function initializeSeeMoreAuthorsButton() {
    var seeMoreToggler = document.body.querySelector("#sidebar-see-more-anchor");

    seeMoreToggler.onclick = function (e) {
      var collapsedClass = "sidebar-module--collapsed";
      var sidebar = document.body.querySelector("#sidebar-module-element");

      if (sidebar.classList.contains(collapsedClass)) {
        sidebar.classList.remove(collapsedClass);
        seeMoreToggler.textContent = "See less «";
      } else {
        sidebar.classList.add(collapsedClass);
        seeMoreToggler.textContent = "See more »";
      }

      e.stopPropagation();
      e.preventDefault();

      return false;
    }
  }

  /**
   * Initialize responsive sidebar
   */
  function initializeResponsiveSidebar() {
    var responsiveMenuClass = "responsive-menu-opened";

    function closeResponsiveMenu() {
      document.body.classList.remove(responsiveMenuClass);
    }

    function toggleResponsiveMenu() {
      document.body.classList.toggle(responsiveMenuClass);
    }

    jQuery(".responsive-menu-button").click(function (e) {
      toggleResponsiveMenu();
      e.preventDefault();
      return false;
    });

    jQuery(document).keyup(function (e) {
      if (e.keyCode === 27) {
        closeResponsiveMenu()
      }
    });

    jQuery(document).click(closeResponsiveMenu);

    // Do not hide sidebar when click event happens inside of responsive menu.
    jQuery('#blog_sidebar').click(function (event) {
      event.stopPropagation();
    });
  }

  window.KIE = {
    readMore: readMore,
    initializeSeeMoreAuthorsButton: initializeSeeMoreAuthorsButton,
    initializeResponsiveSidebar: initializeResponsiveSidebar
  };

}());
