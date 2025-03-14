/**
 * Carousel Script with single item scrolling
 * Scrolls as (1,2,3,4 → 2,3,4,5 → 3,4,5,6 → 4,5,6,1)
 */
document.addEventListener('DOMContentLoaded', function () {
    // Wait for DOM to fully load
    setTimeout(function () {
        console.log("Initializing single-scroll carousels");
        initSmoothScrollCarousels();
    }, 200);
});

/**
 * Initialize all smooth-scroll carousels
 */
function initSmoothScrollCarousels() {
    // Initialize FITM news carousel
    initSmoothFitmNewsCarousel();

    // Initialize news section carousels
    initSmoothNewsCarousels();

    // Initialize news section carousels
    initSmoothNewsCarousels();
}

/**
 * Initialize FITM news carousel with single-item scrolling
 */
function initSmoothFitmNewsCarousel() {
    // FITM news carousel for desktop
    setupSmoothScrollCarousel('fitm-news-desktop-carousel', {
        indicators: 'carousel-indicators-fitm-desktop',
        prevBtn: 'fitm-news-desktop-prev',
        nextBtn: 'fitm-news-desktop-next',
        itemsPerView: 4,
        itemSelector: '.flex-shrink-0',
        autoplayInterval: 5000,
        scrollStep: 1
    });

    // FITM news carousel for mobile
    setupSmoothScrollCarousel('fitm-news-carousel', {
        indicators: 'carousel-indicators-fitm',
        itemsPerView: 1,
        itemSelector: '.flex-shrink-0',
        autoplayInterval: 5000,
        scrollStep: 1
    });
}

/**
 * Initialize news section carousels with single-item scrolling
 */
function initSmoothNewsCarousels() {
    [11, 12, 13, 14].forEach(typeId => {
        // News carousel for desktop
        setupSmoothScrollCarousel(`news-desktop-carousel-${typeId}`, {
            indicators: `carousel-indicators-desktop-${typeId}`,
            prevBtn: `news-desktop-prev-${typeId}`,
            nextBtn: `news-desktop-next-${typeId}`,
            itemsPerView: 4,
            itemSelector: '.flex-shrink-0',
            autoplayInterval: 5000,
            scrollStep: 1
        });

        // News carousel for mobile
        setupSmoothScrollCarousel(`news-carousel-${typeId}`, {
            indicators: `carousel-indicators-${typeId}`,
            itemsPerView: 1,
            itemSelector: '.flex-shrink-0',
            autoplayInterval: 5000,
            scrollStep: 1
        });
    });
}

function initSmoothFitmVideosCarousel() {
    // FITM videos carousel for desktop
    setupSmoothScrollCarousel('fitm-videos-desktop-carousel', {
        indicators: 'carousel-indicators-videos-desktop',
        prevBtn: 'fitm-videos-desktop-prev',
        nextBtn: 'fitm-videos-desktop-next',
        itemsPerView: 4,
        itemSelector: '.flex-shrink-0',
        autoplayInterval: 5000,
        scrollStep: 1
    });

    // FITM videos carousel for mobile
    setupSmoothScrollCarousel('fitm-videos-carousel', {
        indicators: 'carousel-indicators-videos',
        itemsPerView: 1,
        itemSelector: '.flex-shrink-0',
        autoplayInterval: 5000,
        scrollStep: 1
    });
}

/**
 * Setup carousel with single-item scrolling
 */
function setupSmoothScrollCarousel(carouselId, config) {
    console.log(`Setting up smooth-scroll carousel: ${carouselId}`);

    const carousel = document.getElementById(carouselId);
    if (!carousel) {
        console.warn(`Carousel #${carouselId} not found`);
        return;
    }

    // Find inner container
    const innerContainerId = `${carouselId}-inner`;
    let innerContainer = document.getElementById(innerContainerId);

    // If inner container not found by ID, find by selector
    if (!innerContainer) {
        innerContainer = carousel.querySelector('.overflow-hidden > div');
        if (innerContainer) {
            innerContainer.id = innerContainerId;
            console.log(`Added ID to inner container: ${innerContainerId}`);
        } else {
            console.warn(`Inner container for ${carouselId} not found`);
            return;
        }
    }

    // Reference to control buttons
    const prevBtn = config.prevBtn ? document.getElementById(config.prevBtn) : null;
    const nextBtn = config.nextBtn ? document.getElementById(config.nextBtn) : null;
    const indicators = document.querySelectorAll(`.${config.indicators} button`);

    // Get all carousel items
    let allItems = innerContainer.querySelectorAll(config.itemSelector);
    if (allItems.length === 0) {
        console.warn(`No items found in carousel ${carouselId}`);
        return;
    }

    console.log(`Found ${allItems.length} items in carousel ${carouselId}`);

    // Set styling
    innerContainer.style.display = 'flex';
    innerContainer.style.flexWrap = 'nowrap';
    innerContainer.style.transition = 'transform 0.5s ease-in-out';

    // Set width of each item
    const itemsPerView = config.itemsPerView || 4;
    const isDesktop = carouselId.includes('desktop');

    // Adjust the width of items based on number to display per view
    Array.from(allItems).forEach(item => {
        if (isDesktop) {
            // Desktop view
            const percentage = 100 / itemsPerView;
            item.style.flex = `0 0 ${percentage}%`;
            item.style.minWidth = `${percentage}%`;
        } else {
            // Mobile view
            item.style.flex = '0 0 100%';
            item.style.minWidth = '100%';
        }
    });

    // IMPORTANT: Only clone items if we have few items and need to create a continuous loop
    const originalItemCount = allItems.length;

    // Only clone if we actually need to (less than itemsPerView + buffer)
    if (originalItemCount < itemsPerView + 4 && originalItemCount > 1) {
        // Calculate how many clones we need
        const clonesNeeded = itemsPerView + 4 - originalItemCount;

        // Clone only as many as needed, in a repeating pattern if necessary
        for (let i = 0; i < clonesNeeded; i++) {
            const itemToClone = allItems[i % originalItemCount];
            const clone = itemToClone.cloneNode(true);

            // Add a data attribute to mark as clone (useful for debugging)
            clone.setAttribute('data-clone', 'true');

            innerContainer.appendChild(clone);
        }

        // Update item list after cloning
        allItems = innerContainer.querySelectorAll(config.itemSelector);
        console.log(`After cloning: ${allItems.length} items in carousel ${carouselId}`);
    }

    // State variables
    let currentIndex = 0;
    let autoplayTimer = null;
    const totalItems = allItems.length;
    const percentage = 100 / itemsPerView; // Width as percentage
    const scrollStep = config.scrollStep || 1; // Number of items to scroll each time

    // Update indicators
    function updateIndicators() {
        if (indicators.length === 0) return;

        // Calculate which indicator should be active based on current items
        const activeIndicatorIndex = Math.floor(currentIndex / scrollStep) % indicators.length;

        indicators.forEach((indicator, index) => {
            if (index === activeIndicatorIndex) {
                indicator.classList.add('bg-blue-500');
                indicator.classList.remove('bg-gray-300');
            } else {
                indicator.classList.remove('bg-blue-500');
                indicator.classList.add('bg-gray-300');
            }
        });
    }

    // Move carousel
    function moveCarousel(index, source = 'unknown') {
        // Ensure index is within valid range
        if (index < 0) {
            index = totalItems - itemsPerView;
        } else if (index >= totalItems - (itemsPerView - 1)) {
            index = 0;
        }

        currentIndex = index;

        // Calculate translation percentage
        const translationPercentage = -(currentIndex * percentage);
        innerContainer.style.transform = `translateX(${translationPercentage}%)`;

        // Update indicators
        updateIndicators();

        // Restart autoplay
        restartAutoplay();

        console.log(`Moved ${carouselId} to position ${currentIndex} (source: ${source})`);
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

        // Skip autoplay if no interval specified
        if (!config.autoplayInterval) return;

        // Only setup autoplay if we have more than one viewable screen of items
        if (totalItems <= itemsPerView) return;

        autoplayTimer = setInterval(() => {
            // Move by scrollStep items for smooth scrolling
            moveCarousel(currentIndex + scrollStep, 'autoplay');
        }, config.autoplayInterval);
    }

    function restartAutoplay() {
        stopAutoplay();
        startAutoplay();
    }

    // Setup navigation buttons
    if (prevBtn) {
        prevBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            console.log(`Prev button clicked for ${carouselId}`);

            // Move back by scrollStep
            moveCarousel(currentIndex - scrollStep, 'prev button');
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            console.log(`Next button clicked for ${carouselId}`);

            // Move forward by scrollStep
            moveCarousel(currentIndex + scrollStep, 'next button');
        });
    }

    // Setup indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            console.log(`Indicator ${index} clicked for ${carouselId}`);

            // Move to specific position
            moveCarousel(index * scrollStep, 'indicator');
        });
    });

    // Touch support for swiping
    let touchStartX = 0;
    carousel.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoplay();
    }, {
        passive: true
    });

    carousel.addEventListener('touchend', (e) => {
        const touchEndX = e.changedTouches[0].screenX;
        const deltaX = touchEndX - touchStartX;

        if (Math.abs(deltaX) > 30) { // Minimum touch distance
            if (deltaX < 0) {
                // Swipe left - next
                moveCarousel(currentIndex + scrollStep, 'swipe left');
            } else {
                // Swipe right - previous
                moveCarousel(currentIndex - scrollStep, 'swipe right');
            }
        } else {
            startAutoplay();
        }
    }, {
        passive: true
    });

    // Pause on mouse hover
    carousel.addEventListener('mouseenter', stopAutoplay);
    carousel.addEventListener('mouseleave', startAutoplay);

    // Initialize
    updateIndicators();
    startAutoplay();
    console.log(`Smooth-scroll carousel ${carouselId} initialized successfully!`);

    return {
        moveToIndex: moveCarousel,
        stopAutoplay,
        startAutoplay
    };
}
