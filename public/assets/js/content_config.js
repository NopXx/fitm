/**
 * Content Management Configuration
 * Shared variables and settings for content management
 */
const contentConfig = {
    // Routes
    uploadUrl: document.querySelector('meta[name="upload-url"]')?.content || '/media/upload',

    // CSRF Token
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.content || '',

    // Current locale
    currentLocale: document.documentElement.lang || 'en',

    // Messages
    uploadFailMsg: 'Upload failed',

    // Labels
    responsiveImgTitle: 'Full Width (Responsive)',
    noClassTitle: 'None',
    responsiveTableTitle: 'Full Width (Responsive)',
    thaiContentLabel: 'Thai Content',
    englishContentLabel: 'English Content',

    // Form settings
    formSubmitHandlers: {
        create: '/contents',
        update: '/contents/:id'
    }
};
