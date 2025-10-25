const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

const themeVersionKey = 'site-theme-version';
const currentThemeVersion = '20250301';
const storedThemeVersion = localStorage.getItem(themeVersionKey);

if (storedThemeVersion !== currentThemeVersion) {
    localStorage.removeItem('color-theme');
    localStorage.setItem(themeVersionKey, currentThemeVersion);
}

const storedColorTheme = localStorage.getItem('color-theme');
const activeColorTheme = storedColorTheme ?? 'dark';

if (storedColorTheme === null) {
    localStorage.setItem('color-theme', activeColorTheme);
}

// Change the icons inside the button based on previous settings
if (activeColorTheme === 'dark') {
    themeToggleLightIcon?.classList.remove('hidden');
    document.documentElement.classList.add('dark');
} else {
    themeToggleDarkIcon?.classList.remove('hidden');
    document.documentElement.classList.remove('dark');
}

const themeToggleBtn = document.getElementById('theme-toggle');

let event = new Event('dark-mode');

themeToggleBtn.addEventListener('click', function() {

    // toggle icons
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');

    // if set via local storage previously
    const currentTheme = localStorage.getItem('color-theme') ?? 'dark';

    if (localStorage.getItem('color-theme')) {
        if (currentTheme === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (currentTheme === 'dark' || document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }
    }

    document.dispatchEvent(event);
    
});
