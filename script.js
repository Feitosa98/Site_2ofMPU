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

// Scroll Animation (Fade In)
const observerOptions = {
    threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Add initial styles for animation to cards and sections
document.querySelectorAll('.card, .section-title, .contact-container').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'all 0.6s ease-out';
    observer.observe(el);
});

// Video sound control on hover
document.addEventListener('DOMContentLoaded', function () {
    const videos = document.querySelectorAll('.instagram-video');

    videos.forEach(video => {
        // Mute by default
        video.muted = true;

        // Unmute on hover
        video.addEventListener('mouseenter', function () {
            this.muted = false;
            this.volume = 0.7; // 70% volume
        });

        // Mute when mouse leaves
        video.addEventListener('mouseleave', function () {
            this.muted = true;
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
