document.addEventListener("DOMContentLoaded", () => {
  // Mobile Menu Toggle
  const menuBtn = document.querySelector(".menu-btn")
  const mobileMenu = document.querySelector(".mobile-menu")

  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden")
    })
  }

  // Portfolio Filtering
  const filterBtns = document.querySelectorAll(".filter-btn")
  const portfolioItems = document.querySelectorAll(".portfolio-item")

  if (filterBtns.length > 0 && portfolioItems.length > 0) {
    filterBtns.forEach((btn) => {
      btn.addEventListener("click", function () {
        // Remove active class from all buttons
        filterBtns.forEach((btn) => btn.classList.remove("active"))

        // Add active class to clicked button
        this.classList.add("active")

        const filterValue = this.getAttribute("data-filter")

        portfolioItems.forEach((item) => {
          if (filterValue === "all" || item.getAttribute("data-category") === filterValue) {
            item.style.display = "block"
            setTimeout(() => {
              item.style.opacity = "1"
              item.style.transform = "scale(1)"
            }, 10)
          } else {
            item.style.opacity = "0"
            item.style.transform = "scale(0.8)"
            setTimeout(() => {
              item.style.display = "none"
            }, 300)
          }
        })
      })
    })
  }

  // Smooth Scrolling for Anchor Links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()

      // Close mobile menu if open
      if (mobileMenu && !mobileMenu.classList.contains("hidden")) {
        mobileMenu.classList.add("hidden")
      }

      const targetId = this.getAttribute("href")
      if (targetId === "#") return

      const targetElement = document.querySelector(targetId)
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - 80, // Adjust for fixed header
          behavior: "smooth",
        })
      }
    })
  })

  // Back to Top Button
  const backToTopBtn = document.getElementById("back-to-top")

  if (backToTopBtn) {
    window.addEventListener("scroll", () => {
      if (window.pageYOffset > 300) {
        backToTopBtn.classList.remove("opacity-0", "invisible")
        backToTopBtn.classList.add("opacity-100", "visible")
      } else {
        backToTopBtn.classList.remove("opacity-100", "visible")
        backToTopBtn.classList.add("opacity-0", "invisible")
      }
    })

    backToTopBtn.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      })
    })
  }

  // Animate elements on scroll
  const animateElements = document.querySelectorAll(".fade-in")

  function checkIfInView() {
    const windowHeight = window.innerHeight
    const windowTopPosition = window.scrollY
    const windowBottomPosition = windowTopPosition + windowHeight

    animateElements.forEach((element) => {
      const elementHeight = element.offsetHeight
      const elementTopPosition = element.offsetTop
      const elementBottomPosition = elementTopPosition + elementHeight

      // Check if element is in viewport
      if (elementBottomPosition >= windowTopPosition && elementTopPosition <= windowBottomPosition) {
        element.style.animationPlayState = "running"
      }
    })
  }

  // Set initial state for animations
  animateElements.forEach((element) => {
    element.style.animationPlayState = "paused"
  })

  // Check elements on load
  window.addEventListener("load", checkIfInView)

  // Check elements on scroll
  window.addEventListener("scroll", checkIfInView)

  // Service cards animation
  const serviceCards = document.querySelectorAll(".service-card")
  let delay = 0

  serviceCards.forEach((card) => {
    card.style.opacity = "0"
    card.style.transform = "translateY(20px)"
    card.style.transition = "opacity 0.5s ease, transform 0.5s ease"
    card.style.transitionDelay = `${delay}s`
    delay += 0.1
  })

  function animateServiceCards() {
    const windowHeight = window.innerHeight
    const servicesSection = document.getElementById("services")

    if (servicesSection) {
      const servicesSectionTop = servicesSection.offsetTop
      const servicesSectionHeight = servicesSection.offsetHeight
      const windowScrollTop = window.scrollY

      if (windowScrollTop > servicesSectionTop - windowHeight + 200) {
        serviceCards.forEach((card) => {
          card.style.opacity = "1"
          card.style.transform = "translateY(0)"
        })
      }
    }
  }

  window.addEventListener("scroll", animateServiceCards)
  window.addEventListener("load", animateServiceCards)

  // Add animation to buttons
  const buttons = document.querySelectorAll(".btn-primary, .btn-secondary")
  buttons.forEach((button) => {
    button.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-5px)"
    })

    button.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)"
    })
  })
})
