// Mobile Menu Toggle
const mobileToggle = document.querySelector('.mobile-toggle');
const navLinks = document.querySelector('.nav-links');

mobileToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    const icon = mobileToggle.querySelector('i');
    if (navLinks.classList.contains('active')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-xmark');
    } else {
        icon.classList.remove('fa-xmark');
        icon.classList.add('fa-bars');
    }
});

// Smooth Scroll for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        // Close mobile menu if open
        if (navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
            const icon = mobileToggle.querySelector('i');
            icon.classList.remove('fa-xmark');
            icon.classList.add('fa-bars');
        }

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Scroll reveal animation
const observerOptions = {
    threshold: 0.15,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Add animation to all major elements
document.addEventListener('DOMContentLoaded', function () {
    // Select all elements to animate
    const elementsToAnimate = document.querySelectorAll(`
        .card,
        .section-title,
        .contact-container,
        .info-cards > div,
        .qa-item,
        .team-wrapper,
        .city-card,
        .video-card,
        .service-card,
        .management-card,
        .footer-col
    `);

    elementsToAnimate.forEach((el, index) => {
        // Set initial state
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = `all 0.6s ease-out ${index * 0.1}s`;

        // Observe element
        observer.observe(el);
    });
});

// Video sound control - Click to toggle
document.addEventListener('DOMContentLoaded', function () {
    const videos = document.querySelectorAll('.instagram-video');

    videos.forEach(video => {
        // Ensure muted by default
        video.muted = true;

        // Create sound indicator
        const soundIcon = document.createElement('div');
        soundIcon.className = 'sound-indicator';
        soundIcon.innerHTML = '<i class="fa-solid fa-volume-xmark"></i>';
        video.parentElement.appendChild(soundIcon);

        // Toggle sound on click
        video.addEventListener('click', function (e) {
            e.preventDefault();

            if (this.muted) {
                this.muted = false;
                this.volume = 0.7;
                soundIcon.innerHTML = '<i class="fa-solid fa-volume-high"></i>';
                soundIcon.classList.add('active');
            } else {
                this.muted = true;
                soundIcon.innerHTML = '<i class="fa-solid fa-volume-xmark"></i>';
                soundIcon.classList.remove('active');
            }
        });

        // Show indicator on hover
        video.parentElement.addEventListener('mouseenter', function () {
            soundIcon.style.opacity = '1';
        });

        video.parentElement.addEventListener('mouseleave', function () {
            if (video.muted) {
                soundIcon.style.opacity = '0';
            }
        });
    });
});

// Instagram Video Autoplay
// Wait for Instagram embeds to load, then enable autoplay
window.addEventListener('load', function () {
    setTimeout(function () {
        // Find all Instagram iframes
        const instagramIframes = document.querySelectorAll('.instagram-embed iframe');

        // Create intersection observer for video autoplay
        const videoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const iframe = entry.target;
                if (entry.isIntersecting) {
                    // Try to play the video when visible
                    try {
                        iframe.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
                    } catch (e) {
                        console.log('Instagram autoplay not available');
                    }
                }
            });
        }, {
            threshold: 0.5 // Video needs to be 50% visible
        });

        // Observe each Instagram iframe
        instagramIframes.forEach(iframe => {
            videoObserver.observe(iframe);
        });
    }, 2000); // Wait 2 seconds for Instagram embeds to fully load
});
