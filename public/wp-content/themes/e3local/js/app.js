(() => {
  // resources/js/app.js
  window.addEventListener("load", function() {
    let main_navigation = document.querySelector("#primary-menu");
    let menu_toggle = document.querySelector("#primary-menu-toggle");
    
    // Only add event listener if both elements exist
    if (main_navigation && menu_toggle) {
      menu_toggle.addEventListener("click", function(e) {
        e.preventDefault();
        main_navigation.classList.toggle("hidden");
      });
    }
  });
})();
