// Function to toggle between menu icons and labels
function toggleMenuIcon() {
    const menuIcon = document.getElementById('menuIcon');
    const menuLabel = document.getElementById('menuToggleLabel');

    // Toggle the icon classes between fa-bars and fa-xmark
    if (menuIcon.classList.contains('fa-bars')) {
        // Change to close menu icon (fa-xmark)
        menuIcon.classList.remove('fa-bars');
        menuIcon.classList.add('fa-xmark');
        menuLabel.textContent = 'Close main menu';
    } else {
        // Change to open menu icon (fa-bars)
        menuIcon.classList.remove('fa-xmark');
        menuIcon.classList.add('fa-bars');
        menuLabel.textContent = 'Open main menu';
    }
}

// Add click event listener to the button
const menuToggleBtn = document.getElementById('menuToggleBtn');
menuToggleBtn.addEventListener('click', toggleMenuIcon);

let swiper = new Swiper('.swiper-container', {
  loop: true, // Enable loop mode
  pagination: {
      el: '.swiper-pagination',
      clickable: true, // Specify the pagination container
  },
  autoplay: {
      delay: 5000, // Set the delay between slides in milliseconds (5 seconds in this case)
      disableOnInteraction: false, // Enable/disable autoplay on user interaction
  },
});

  document.addEventListener('DOMContentLoaded', function () {
    // Select your header element
    const header = document.querySelector('header');

    // Define the scroll event listener
    window.onscroll = function () {
        // Check if the page has been scrolled down
        if (window.scrollY > 10) {
            // Add the sticky class to the header
            header.classList.add('sticky-header');
        } else {
            // Remove the sticky class if the page is scrolled back to the top
            header.classList.remove('sticky-header');
        }
    };
});

document.addEventListener('DOMContentLoaded', function () {
    if (window.innerWidth > 10) {
        gsap.registerPlugin(ScrollTrigger);

        ScrollTrigger.create({
            trigger: '#supercharge',
            start: "40% 50%",
            end: "bottom 35%",
            toggleClass: 'enable',
            // markers: true
        });

        const cards = document.querySelectorAll(".card__pin");

        cards.forEach((card, index) => {
            const tween = gsap.to(card, {
                scrollTrigger: {
                    trigger: card,
                    start: () => `top 25% center`,
                    endTrigger: "#contact",
                    end: "bottom bottom", // Adjusted to make the section slide in when triggered
                    scrub: true,
                    pin: true,
                    pinSpacing: false,
                    // markers: true,
                    invalidateOnRefresh: true
                },
                ease: "none",
                scale: () => 1 - (cards.length - index) * 0.090
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var navbarToggle = document.querySelector('[data-collapse-toggle="navbar-sticky"]');
    var navbar = document.querySelector('#navbar-sticky');

    navbarToggle.addEventListener('click', function() {
        navbar.classList.toggle('hidden');
    });
});


