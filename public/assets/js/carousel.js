/**
 * Embla Carousel Implementation for FITM website (CDN Version)
 * With improvements for button visibility controls
 */
document.addEventListener('DOMContentLoaded', function () {
    // Wait for DOM to fully load
    setTimeout(function () {
        initAllEmblaCarousels();
    }, 200);
});

/**
 * Initialize all Embla carousels
 */
function initAllEmblaCarousels() {
    // Initialize FITM news carousel
    initFitmNewsCarousel();

    // Initialize news section carousels
    initNewsCarousels();

    // Initialize FITM videos carousel
    initFitmVideosCarousel();
}

/**
 * Initialize FITM news carousel
 */
function initFitmNewsCarousel() {
    // FITM news carousel for desktop
    setupEmblaCarousel('fitm-news-desktop-carousel', {
        prevBtnSelector: '.embla__button--prev',
        nextBtnSelector: '.embla__button--next',
        dotsSelector: '.embla__dots',
        options: {
            align: 'start',
            loop: true
        },
        autoplay: true,
        autoplayInterval: 5000
    });

    // FITM news carousel for mobile - ensure buttons are always hidden
    setupEmblaCarousel('fitm-news-carousel', {
        prevBtnSelector: '.embla__button--prev',
        nextBtnSelector: '.embla__button--next',
        dotsSelector: '.embla__dots',
        options: {
            align: 'start',
            loop: true
        },
        autoplay: true,
        autoplayInterval: 5000,
        hideButtonsOnMobile: true
    });

    // Force hide buttons on mobile carousels
    const mobileCarousel = document.getElementById('fitm-news-carousel');
    if (mobileCarousel) {
        const mobileButtons = mobileCarousel.querySelector('.embla__buttons');
        if (mobileButtons) {
            mobileButtons.style.display = 'none';
        }
    }
}

/**
 * Initialize news section carousels
 */
function initNewsCarousels() {
    // เพิ่ม 'important' เข้าไปในรายการ typeId ที่ต้องการสร้าง carousel
    ['important', 11, 12, 13, 14].forEach(typeId => {
        // News carousel for desktop
        setupEmblaCarousel(`news-desktop-carousel-${typeId}`, {
            prevBtnSelector: '.embla__button--prev',
            nextBtnSelector: '.embla__button--next',
            dotsSelector: '.embla__dots',
            options: {
                align: 'start',
                loop: true
            },
            autoplay: true,
            autoplayInterval: 5000
        });

        // News carousel for mobile
        setupEmblaCarousel(`news-carousel-${typeId}`, {
            prevBtnSelector: '.embla__button--prev',
            nextBtnSelector: '.embla__button--next',
            dotsSelector: '.embla__dots',
            options: {
                align: 'start',
                loop: true
            },
            autoplay: true,
            autoplayInterval: 5000,
            hideButtonsOnMobile: true
        });

        // Force hide buttons on all mobile carousels
        const mobileCarousel = document.getElementById(`news-carousel-${typeId}`);
        if (mobileCarousel) {
            const mobileButtons = mobileCarousel.querySelector('.embla__buttons');
            if (mobileButtons) {
                mobileButtons.style.display = 'none';
            }
        }
    });

    // Add a global CSS rule to forcefully hide buttons on mobile
    const mobileButtonStyle = document.createElement('style');
    mobileButtonStyle.textContent = `
        @media (max-width: 767px) {
            .embla__buttons {
                display: none !important;
            }
        }
    `;
    document.head.appendChild(mobileButtonStyle);
}

/**
 * Initialize FITM videos carousel
 */
function initFitmVideosCarousel() {
    // FITM videos carousel for desktop
    setupEmblaCarousel('fitm-videos-desktop-carousel', {
        prevBtnSelector: '.embla__button--prev',
        nextBtnSelector: '.embla__button--next',
        dotsSelector: '.embla__dots',
        options: {
            align: 'start',
            loop: true,
            dragFree: true, // Enable momentum scrolling for smoother experience
            containScroll: 'trimSnaps', // Prevent overscrolling
            skipSnaps: false, // Ensures proper snap alignment
            speed: 15 // Slower transition for video content
        },
        autoplay: true,
        autoplayInterval: 10000 // Longer interval for video content (10 seconds)
    });

    // FITM videos carousel for mobile
    setupEmblaCarousel('fitm-videos-carousel', {
        prevBtnSelector: '.embla__button--prev',
        nextBtnSelector: '.embla__button--next',
        dotsSelector: '.embla__dots',
        options: {
            align: 'start',
            loop: true,
            dragFree: true,
            containScroll: 'trimSnaps',
            skipSnaps: false,
            speed: 15
        },
        autoplay: true,
        autoplayInterval: 10000,
        hideButtonsOnMobile: true
    });

    // Add special handling for video content
    handleVideoCarousels('fitm-videos-desktop-carousel');
    handleVideoCarousels('fitm-videos-carousel');
}

/**
 * Setup Embla Carousel
 * @param {string} carouselId - ID of the carousel section element
 * @param {Object} config - Configuration for the carousel
 */
function setupEmblaCarousel(carouselId, config) {
    const emblaNode = document.getElementById(carouselId);
    if (!emblaNode) {
        return;
    }

    const viewportNode = emblaNode.querySelector('.embla__viewport');
    if (!viewportNode) {
        return;
    }

    // Find controls
    const prevBtnNode = emblaNode.querySelector(config.prevBtnSelector);
    const nextBtnNode = emblaNode.querySelector(config.nextBtnSelector);
    const dotsNode = emblaNode.querySelector(config.dotsSelector);
    const buttonsContainerNode = emblaNode.querySelector('.embla__buttons');

    // Initialize Embla Carousel
    const emblaApi = EmblaCarousel(viewportNode, config.options || {
        align: 'start'
    });

    // Check if we should hide buttons based on slide count
    const slideCount = emblaApi.slideNodes().length;
    const shouldHideButtons = slideCount <= 4 || config.hideButtonsOnMobile;

    // Hide buttons container if needed
    if (buttonsContainerNode) {
        if (slideCount <= 4) {
            // Hide for both desktop and mobile if 4 or fewer slides
            buttonsContainerNode.style.display = 'none';
        } else if (config.hideButtonsOnMobile && window.innerWidth < 768) {
            // Force hide on mobile layouts regardless of class
            buttonsContainerNode.style.display = 'none';
        } else if (config.hideButtonsOnMobile) {
            // Apply mobile-specific classes
            buttonsContainerNode.classList.add('md:block');
            buttonsContainerNode.classList.add('hidden');
        } else {
            // Ensure buttons are visible
            buttonsContainerNode.style.display = '';
            buttonsContainerNode.classList.remove('hidden', 'md:block');
        }
    }

    // Apply direct CSS to ensure mobile hiding works
    if (config.hideButtonsOnMobile) {
        // Add a media query based style directly to the carousel
        const styleId = `embla-style-${carouselId}`;
        let styleEl = document.getElementById(styleId);

        if (!styleEl) {
            styleEl = document.createElement('style');
            styleEl.id = styleId;
            document.head.appendChild(styleEl);
        }

        styleEl.textContent = `
            @media (max-width: 767px) {
                #${carouselId} .embla__buttons {
                    display: none !important;
                }
            }
        `;
    }

    // Add dots (indicators)
    const removeDotBtnsAndClickHandlers = addDotBtnsAndClickHandlers(emblaApi, dotsNode);

    // Add prev/next button handlers if buttons are visible
    const removePrevNextBtnsClickHandlers = !shouldHideButtons ?
        addPrevNextBtnsClickHandlers(emblaApi, prevBtnNode, nextBtnNode) : () => {};

    // Set up autoplay if enabled
    let autoplayTimer = null;
    const startAutoplay = () => {
        if (!config.autoplay) return;

        stopAutoplay();
        autoplayTimer = setInterval(() => {
            if (emblaApi.canScrollNext()) {
                emblaApi.scrollNext();
            } else if (config.options && config.options.loop) {
                emblaApi.scrollTo(0);
            }
        }, config.autoplayInterval || 5000);
    };

    const stopAutoplay = () => {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    };

    // Start autoplay
    startAutoplay();

    // Pause on mouse hover
    if (config.autoplay) {
        emblaNode.addEventListener('mouseenter', stopAutoplay);
        emblaNode.addEventListener('mouseleave', startAutoplay);

        // Also pause on focus of buttons for accessibility
        if (prevBtnNode) prevBtnNode.addEventListener('focus', stopAutoplay);
        if (nextBtnNode) nextBtnNode.addEventListener('focus', stopAutoplay);
        if (dotsNode) {
            const dotButtons = dotsNode.querySelectorAll('.embla__dot');
            dotButtons.forEach(dot => {
                dot.addEventListener('focus', stopAutoplay);
            });
        }
    }

    // Clean up on destroy
    emblaApi.on('destroy', () => {
        stopAutoplay();
        removePrevNextBtnsClickHandlers();
        removeDotBtnsAndClickHandlers();

        if (config.autoplay) {
            emblaNode.removeEventListener('mouseenter', stopAutoplay);
            emblaNode.removeEventListener('mouseleave', startAutoplay);

            if (prevBtnNode) prevBtnNode.removeEventListener('focus', stopAutoplay);
            if (nextBtnNode) nextBtnNode.removeEventListener('focus', stopAutoplay);
        }
    });

    return emblaApi;
}

/**
 * Add dot buttons and their click handlers
 * @param {EmblaCarouselType} emblaApi - Embla Carousel instance
 * @param {HTMLElement} dotsNode - Container for the dots
 * @returns {Function} - Cleanup function
 */
function addDotBtnsAndClickHandlers(emblaApi, dotsNode) {
    if (!dotsNode) return () => {};

    let dotNodes = [];

    const addDotBtnsWithClickHandlers = () => {
        dotsNode.innerHTML = emblaApi
            .scrollSnapList()
            .map(() => '<button class="embla__dot" type="button"></button>')
            .join('');

        const scrollTo = (index) => {
            emblaApi.scrollTo(index);
        };

        dotNodes = Array.from(dotsNode.querySelectorAll('.embla__dot'));
        dotNodes.forEach((dotNode, index) => {
            dotNode.addEventListener('click', () => scrollTo(index), false);
        });
    };

    const toggleDotBtnsActive = () => {
        const previous = emblaApi.previousScrollSnap();
        const selected = emblaApi.selectedScrollSnap();
        if (previous >= 0 && previous < dotNodes.length) {
            dotNodes[previous].classList.remove('embla__dot--selected');
        }
        if (selected >= 0 && selected < dotNodes.length) {
            dotNodes[selected].classList.add('embla__dot--selected');
        }
    };

    emblaApi
        .on('init', addDotBtnsWithClickHandlers)
        .on('reInit', addDotBtnsWithClickHandlers)
        .on('init', toggleDotBtnsActive)
        .on('reInit', toggleDotBtnsActive)
        .on('select', toggleDotBtnsActive);

    return () => {
        dotsNode.innerHTML = '';
    };
}

/**
 * Add button state management (enabled/disabled)
 * @param {EmblaCarouselType} emblaApi - Embla Carousel instance
 * @param {HTMLElement} prevBtn - Previous button
 * @param {HTMLElement} nextBtn - Next button
 * @returns {Function} - Cleanup function
 */
function addTogglePrevNextBtnsActive(emblaApi, prevBtn, nextBtn) {
    if (!prevBtn || !nextBtn) return () => {};

    const togglePrevNextBtnsState = () => {
        if (emblaApi.canScrollPrev()) prevBtn.removeAttribute('disabled');
        else prevBtn.setAttribute('disabled', 'disabled');

        if (emblaApi.canScrollNext()) nextBtn.removeAttribute('disabled');
        else nextBtn.setAttribute('disabled', 'disabled');
    };

    emblaApi
        .on('select', togglePrevNextBtnsState)
        .on('init', togglePrevNextBtnsState)
        .on('reInit', togglePrevNextBtnsState);

    return () => {
        prevBtn.removeAttribute('disabled');
        nextBtn.removeAttribute('disabled');
    };
}

/**
 * Add click handlers for the prev/next buttons
 * @param {EmblaCarouselType} emblaApi - Embla Carousel instance
 * @param {HTMLElement} prevBtn - Previous button
 * @param {HTMLElement} nextBtn - Next button
 * @returns {Function} - Cleanup function
 */
function addPrevNextBtnsClickHandlers(emblaApi, prevBtn, nextBtn) {
    if (!prevBtn || !nextBtn) return () => {};

    const scrollPrev = () => {
        emblaApi.scrollPrev();
    };

    const scrollNext = () => {
        emblaApi.scrollNext();
    };

    prevBtn.addEventListener('click', scrollPrev, false);
    nextBtn.addEventListener('click', scrollNext, false);

    const removeTogglePrevNextBtnsActive = addTogglePrevNextBtnsActive(
        emblaApi,
        prevBtn,
        nextBtn
    );

    return () => {
        removeTogglePrevNextBtnsActive();
        prevBtn.removeEventListener('click', scrollPrev, false);
        nextBtn.removeEventListener('click', scrollNext, false);
    };
}

function handleVideoCarousels(carouselId) {
    const carouselNode = document.getElementById(carouselId);
    if (!carouselNode) return;

    const viewportNode = carouselNode.querySelector('.embla__viewport');
    const emblaApi = EmblaCarousel(viewportNode);

    // Get all iframe elements in the carousel
    const iframes = carouselNode.querySelectorAll('iframe');

    // Function to pause all videos
    const pauseAllVideos = () => {
      iframes.forEach(iframe => {
        // This requires YouTube or Vimeo iframe API to be properly set up
        // Simple approach: reload the iframe to effectively pause it
        const src = iframe.src;
        iframe.src = src;
      });
    };

    // Pause videos when sliding
    emblaApi.on('settle', () => {
      // Pause all videos except the currently visible one
      const currentIndex = emblaApi.selectedScrollSnap();
      iframes.forEach((iframe, index) => {
        if (Math.floor(index / emblaApi.slidesInView()) !== currentIndex) {
          const src = iframe.src;
          iframe.src = src;
        }
      });
    });

    // Pause on destroy
    emblaApi.on('destroy', pauseAllVideos);
}