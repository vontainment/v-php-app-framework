// attach a function to the document that will execute once the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function () {
  // select all elements with the class 'fade-in'
  const fadeInElements = document.querySelectorAll(".fade-in");

  // define a function to check visibility of each 'fade-in' element
  function checkVisibility() {
    // loop through each 'fade-in' element
    fadeInElements.forEach(function (element) {
      // get the bounding rectangle of the current element
      const rect = element.getBoundingClientRect();
      // get the window height
      const windowHeight =
        window.innerHeight || document.documentElement.clientHeight;

      // check if the element is within the viewport
      if (rect.top <= windowHeight && rect.bottom >= 0) {
        // add the class 'is-visible' to the element if it's within the viewport
        element.classList.add("is-visible");
      }
    });
  }

  // call the checkVisibility function when the user scrolls
  window.addEventListener("scroll", checkVisibility);
  // call the checkVisibility function when the user resizes the window
  window.addEventListener("resize", checkVisibility);
  // call the checkVisibility function when the page has finished loading
  window.addEventListener("load", checkVisibility);

    // Configurable constants and variable to track the currently visible modal
  const isOpenClass = "modal-is-open";
  const openingClass = "modal-is-opening";
  const closingClass = "modal-is-closing";
  const animationDuration = 400; // in milliseconds
  let visibleModal = null;

  // Function to toggle (open/close) a modal dialog
  const toggleModal = (event) => {
    event.preventDefault();
    const modalId = event.currentTarget.getAttribute("data-modal-target");
    const modal = document.getElementById(modalId);
    (typeof modal != "undefined" && modal != null && isModalOpen(modal))
      ? closeModal(modal)
      : openModal(modal);
  };

  // Function to check if a modal dialog is open
  const isModalOpen = (modal) => modal.hasAttribute("open") && modal.getAttribute("open") != "false";

  // Function to open a modal dialog
  const openModal = (modal) => {
    if (isScrollbarVisible()) {
      document.documentElement.style.setProperty("--scrollbar-width", `${getScrollbarWidth()}px`);
    }
    document.documentElement.classList.add(isOpenClass, openingClass);
    setTimeout(() => {
      visibleModal = modal;
      document.documentElement.classList.remove(openingClass);
    }, animationDuration);
    modal.setAttribute("open", true);
  };

  // Function to close a modal dialog
  const closeModal = (modal) => {
    visibleModal = null;
    document.documentElement.classList.add(closingClass);
    setTimeout(() => {
      document.documentElement.classList.remove(closingClass, isOpenClass);
      document.documentElement.style.removeProperty("--scrollbar-width");
      modal.removeAttribute("open");
    }, animationDuration);
  };

  // Close modal dialog upon clicking outside it
  document.addEventListener("click", (event) => {
    if (visibleModal != null) {
      const modalContent = visibleModal.querySelector("article");
      const isClickInside = modalContent.contains(event.target);
      (!isClickInside) && closeModal(visibleModal);
    }
  });

  // Close modal dialog upon pressing Esc key
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && visibleModal != null) {
      closeModal(visibleModal);
    }
  });

  // Get the width of the browser's scrollbar
  const getScrollbarWidth = () => {
    const outer = document.createElement("div");
    // Invisible container
    outer.style.visibility = "hidden";
    outer.style.overflow = "scroll"; // forcing scrollbar to appear
    outer.style.msOverflowStyle = "scrollbar"; // needed for WinJS apps
    document.body.appendChild(outer);

    const inner = document.createElement("dove);
    outer.appendChild(inner);

    // Calculating difference between container's full width and the child width
    const scrollbarWidth = outer.offsetWidth - inner.offsetWidth;

    // Removing temporary elements from the DOM
    outer.parentNode.removeChild(outer);

    return scrollbarWidth;
  };

  // Check if scrollbar is visible
  const isScrollbarVisible = () => document.body.scrollHeight > screen.height;
});
