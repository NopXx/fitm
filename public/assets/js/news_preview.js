document.addEventListener("DOMContentLoaded", function () {
    // Title and Detail Inputs
    var titleTh = document.querySelector('input[name="title_th"]');
    var detailTh = document.querySelector('textarea[name="detail_th"]');
    var titleEn = document.querySelector('input[name="title_en"]');
    var detailEn = document.querySelector('textarea[name="detail_en"]');

    // Preview Elements
    var previewTitle1 = document.getElementById("previewTitle1");
    var previewDetail1 = document.getElementById("previewDetail1");
    var previewTitle2 = document.getElementById("previewTitle2");
    var previewDetail2 = document.getElementById("previewDetail2");

    // Set default text for translation placeholders
    const defaultTitle = previewTitle1 ? previewTitle1.textContent : 'Title';
    const defaultDetail = previewDetail1 ? previewDetail1.textContent : 'Description';

    // Update Title Preview (prioritize current language)
    const updatePreviewTitle = function () {
        if (!previewTitle1 || !previewTitle2) return;

        // Get active tab - fix here: use #infoTabs instead of #langTabs
        const activeTab = document.querySelector('#infoTabs .nav-link.active');
        if (!activeTab) return;

        const currentLang = activeTab.id;
        let title = '';

        if (currentLang === 'thai-info-tab') {
            title = titleTh.value || defaultTitle;
        } else {
            title = titleEn.value || titleTh.value || defaultTitle;
        }

        previewTitle1.textContent = title;
        previewTitle2.textContent = title;
    };

    // Update Detail Preview (prioritize current language)
    const updatePreviewDetail = function () {
        if (!previewDetail1 || !previewDetail2) return;

        // Get active tab - fix here: use #infoTabs instead of #langTabs
        const activeTab = document.querySelector('#infoTabs .nav-link.active');
        if (!activeTab) return;

        const currentLang = activeTab.id;
        let detail = '';

        if (currentLang === 'thai-info-tab') {
            detail = detailTh.value || defaultDetail;
        } else {
            detail = detailEn.value || detailTh.value || defaultDetail;
        }

        previewDetail1.textContent = detail;
        previewDetail2.textContent = detail;
    };

    // Only add event listeners if elements exist
    if (titleTh && titleEn && detailTh && detailEn) {
        // Update preview on input change
        titleTh.addEventListener("input", updatePreviewTitle);
        detailTh.addEventListener("input", updatePreviewDetail);
        titleEn.addEventListener("input", updatePreviewTitle);
        detailEn.addEventListener("input", updatePreviewDetail);

        // Update preview on tab change - fix here: use #infoTabs instead of #langTabs
        document.querySelectorAll('#infoTabs .nav-link').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function () {
                updatePreviewTitle();
                updatePreviewDetail();
            });
        });

        // Initial update
        updatePreviewTitle();
        updatePreviewDetail();
    }
});
