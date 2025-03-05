/**
 * Direct fix for news section carousels
 * This specialized script focuses just on fixing the issues with the news section carousels
 */
document.addEventListener('DOMContentLoaded', function() {
    // Allow time for DOM to fully render
    setTimeout(function() {
        fixNewsCarousels();
    }, 100);
});

/**
 * Fix specifically for news section carousels
 */
function fixNewsCarousels() {
    console.log('⚙️ Applying specialized fix for news section carousels');

    // Process each news type
    [11, 12, 13, 14].forEach(typeId => {
        // Get elements
        const carouselId = `news-desktop-carousel-${typeId}`;
        const carousel = document.getElementById(carouselId);
        if (!carousel) {
            console.warn(`📣 Carousel #${carouselId} not found`);
            return;
        }

        const innerContainerId = `news-desktop-carousel-inner-${typeId}`;
        const innerContainer = document.getElementById(innerContainerId);
        if (!innerContainer) {
            console.warn(`📣 Inner container #${innerContainerId} not found`);
            return;
        }

        const prevBtnId = `news-desktop-prev-${typeId}`;
        const prevBtn = document.getElementById(prevBtnId);
        if (!prevBtn) {
            console.warn(`📣 Prev button #${prevBtnId} not found`);
        }

        const nextBtnId = `news-desktop-next-${typeId}`;
        const nextBtn = document.getElementById(nextBtnId);
        if (!nextBtn) {
            console.warn(`📣 Next button #${nextBtnId} not found`);
        }

        const indicatorsClass = `carousel-indicators-desktop-${typeId}`;
        const indicators = document.querySelectorAll(`.${indicatorsClass} button`);

        console.log(`🔍 News carousel ${typeId}: inner=${innerContainer ? '✓' : '✗'}, prev=${prevBtn ? '✓' : '✗'}, next=${nextBtn ? '✓' : '✗'}, indicators=${indicators.length}`);

        // If no buttons found, skip this carousel
        if (!prevBtn && !nextBtn && indicators.length === 0) {
            console.warn(`📣 No controls found for carousel #${carouselId}, skipping`);
            return;
        }

        // Fix carousel structure
        const items = innerContainer.children;
        if (items.length === 0) {
            console.warn(`📣 No slides found in carousel #${carouselId}`);
            return;
        }

        // Set up carousel styles
        innerContainer.style.display = 'flex';
        innerContainer.style.transition = 'transform 0.3s ease-in-out';

        // Ensure each slide takes full width
        Array.from(items).forEach(item => {
            item.style.flex = '0 0 100%';
            item.style.width = '100%';
        });

        // Initialize state
        let currentIndex = 0;
        let autoplayTimer = null;
        const autoplayInterval = 8000;

        // Update indicators function
        function updateIndicators() {
            indicators.forEach((indicator, index) => {
                if (index === currentIndex) {
                    indicator.classList.add('bg-blue-500');
                    indicator.classList.remove('bg-gray-300');
                } else {
                    indicator.classList.remove('bg-blue-500');
                    indicator.classList.add('bg-gray-300');
                }
            });
        }

        // Move carousel function with debug output
        function moveCarousel(index) {
            const maxIndex = items.length - 1;
            if (index < 0) index = maxIndex;
            if (index > maxIndex) index = 0;

            currentIndex = index;
            innerContainer.style.transform = `translateX(-${index * 100}%)`;
            updateIndicators();

            console.log(`🔄 Moving carousel ${typeId} to slide ${index}`);

            // Restart autoplay
            stopAutoplay();
            startAutoplay();
        }

        // Autoplay functions
        function stopAutoplay() {
            if (autoplayTimer) {
                clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        }

        function startAutoplay() {
            stopAutoplay();
            autoplayTimer = setInterval(() => {
                moveCarousel(currentIndex + 1);
            }, autoplayInterval);
        }

        // Direct event listeners with explicit debugging
        if (prevBtn) {
            // Remove any existing event listeners (in case this is re-initialized)
            prevBtn.replaceWith(prevBtn.cloneNode(true));
            const newPrevBtn = document.getElementById(prevBtnId);

            newPrevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log(`👆 PREV button ${typeId} clicked!`);
                moveCarousel(currentIndex - 1);
            });

            // Add visual debug helper
            newPrevBtn.setAttribute('title', `Previous (Carousel ${typeId})`);
        }

        if (nextBtn) {
            // Remove any existing event listeners (in case this is re-initialized)
            nextBtn.replaceWith(nextBtn.cloneNode(true));
            const newNextBtn = document.getElementById(nextBtnId);

            newNextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log(`👆 NEXT button ${typeId} clicked!`);
                moveCarousel(currentIndex + 1);
            });

            // Add visual debug helper
            newNextBtn.setAttribute('title', `Next (Carousel ${typeId})`);
        }

        // Set up indicators
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log(`👆 Indicator ${index} for carousel ${typeId} clicked!`);
                moveCarousel(index);
            });
        });

        // Initialize
        updateIndicators();
        startAutoplay();
        console.log(`✅ News carousel ${typeId} initialized successfully!`);
    });
}
