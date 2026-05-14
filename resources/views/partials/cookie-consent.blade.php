@if(! request()->is('admin*'))
<button type="button" class="cookie-floating-btn" id="cookieTrigger" onclick="openCookieSettings()" aria-label="Manage Cookie Settings" title="Cookie Settings">
    🍪
</button>
@endif

<div id="cookieConsentModal" class="cookie-modal-overlay" style="display: none;" role="dialog" aria-labelledby="cookieTitle" aria-modal="true">
    <div class="cookie-modal-card">
        <button type="button" class="close-btn" onclick="hideModal()" aria-label="Skip for now">×</button>
        <!-- Main View -->
        <div id="cookieMainView">
            <div class="cookie-icon">🍪</div>
            <h2 id="cookieTitle">We value your privacy</h2>
            <p>We use cookies to enhance your browsing experience, serve personalized ads or content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.</p>
            
            <div class="cookie-actions">
                <button type="button" class="cookie-btn btn-primary" onclick="consentAll()">Accept All</button>
                <button type="button" class="cookie-btn btn-outline" onclick="showCustomize()">Customize</button>
                <button type="button" class="cookie-btn btn-text" onclick="rejectAll()">Reject All</button>
            </div>
        </div>

        <!-- Customize View -->
        <div id="cookieCustomizeView" style="display: none;">
            <div class="customize-header">
                <h3>Cookie Settings</h3>
            </div>
            
            <div class="cookie-options-list">
                <div class="cookie-option">
                    <div class="option-info">
                        <span class="option-name">Essential</span>
                        <span class="option-desc">Necessary for the website to function. Cannot be switched off.</span>
                    </div>
                    <div class="toggle-wrap">
                        <input type="checkbox" checked disabled>
                        <span class="toggle-slider disabled"></span>
                    </div>
                </div>

                <div class="cookie-option">
                    <div class="option-info">
                        <span class="option-name">Analytics</span>
                        <span class="option-desc">Help us understand how visitors interact with the website.</span>
                    </div>
                    <div class="toggle-wrap">
                        <input type="checkbox" id="analyticsCookies">
                        <label for="analyticsCookies" class="toggle-slider"></label>
                    </div>
                </div>

                <div class="cookie-option">
                    <div class="option-info">
                        <span class="option-name">Marketing</span>
                        <span class="option-desc">Used to track visitors across websites to deliver relevant ads.</span>
                    </div>
                    <div class="toggle-wrap">
                        <input type="checkbox" id="marketingCookies">
                        <label for="marketingCookies" class="toggle-slider"></label>
                    </div>
                </div>
            </div>

            <div class="cookie-actions">
                <button type="button" class="cookie-btn btn-primary" onclick="saveCustom()">Save Preferences</button>
            </div>
        </div>
    </div>
</div>

<style>
    .cookie-modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(43, 27, 36, 0.2);
        backdrop-filter: blur(8px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.4s ease;
    }

    .cookie-modal-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 28px;
        padding: 40px;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(216, 84, 123, 0.15);
        text-align: center;
        position: relative;
        animation: slideUp 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .close-btn {
        position: absolute;
        top: 20px;
        right: 24px;
        background: none;
        border: none;
        font-size: 28px;
        color: #835372;
        cursor: pointer;
        line-height: 1;
        transition: color 0.2s;
    }

    .close-btn:hover { color: #d8547b; }

    .cookie-icon { font-size: 48px; margin-bottom: 20px; }
    
    .cookie-modal-card h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        color: #2b1b24;
        margin-bottom: 12px;
    }

    .cookie-modal-card h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2b1b24;
    }

    .cookie-modal-card p {
        font-size: 0.95rem;
        line-height: 1.6;
        color: #665560;
        margin-bottom: 32px;
    }

    .cookie-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .cookie-btn {
        padding: 14px 24px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        font-family: 'Poppins', sans-serif;
    }

    .cookie-btn.btn-primary {
        background: #d8547b;
        color: white;
        box-shadow: 0 8px 20px rgba(216, 84, 123, 0.3);
    }

    .cookie-btn.btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(216, 84, 123, 0.4);
    }

    .cookie-btn.btn-outline {
        background: transparent;
        border: 2px solid #f0e1e5;
        color: #2b1b24;
    }

    .cookie-btn.btn-outline:hover {
        background: rgba(216, 84, 123, 0.05);
        border-color: #d8547b;
    }

    .cookie-btn.btn-text {
        background: transparent;
        color: #835372;
        font-size: 0.85rem;
    }

    .cookie-btn.btn-text:hover { color: #d8547b; }

    /* Customize View Styles */
    .customize-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        text-align: left;
    }

    .cookie-options-list {
        text-align: left;
        margin-bottom: 32px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .cookie-option {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .option-name { display: block; font-weight: 700; color: #2b1b24; font-size: 0.95rem; }
    .option-desc { display: block; font-size: 0.8rem; color: #835372; line-height: 1.4; margin-top: 2px; }

    /* Custom Toggle Switch */
    .toggle-wrap { position: relative; width: 44px; height: 24px; }
    .toggle-wrap input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #f0e1e5;
        transition: .3s; border-radius: 24px;
    }
    .toggle-slider:before {
        position: absolute; content: "";
        height: 18px; width: 18px; left: 3px; bottom: 3px;
        background-color: white; transition: .3s; border-radius: 50%;
    }
    input:checked + .toggle-slider { background-color: #d8547b; }
    input:checked + .toggle-slider:before { transform: translateX(20px); }
    .toggle-slider.disabled { cursor: not-allowed; opacity: 0.6; }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 480px) {
        .cookie-modal-card { padding: 30px 24px; }
    }

    .cookie-floating-btn {
        position: fixed;
        bottom: 100px; /* Adjusted to sit comfortably above chatbot */
        right: 24px;
        width: 60px; /* Increased to match chatbot size */
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(216, 84, 123, 0.2);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        font-size: 28px; /* Larger cookie icon */
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .cookie-floating-btn:hover {
        transform: scale(1.1) rotate(15deg);
        background: white;
        border-color: #d8547b;
        box-shadow: 0 8px 25px rgba(216, 84, 123, 0.2);
    }
</style>

<script>
    const STORAGE_KEY = 'sugarloom_cookie_consent';
    const modal = document.getElementById('cookieConsentModal');
    const trigger = document.getElementById('cookieTrigger');
    const mainView = document.getElementById('cookieMainView');
    const customizeView = document.getElementById('cookieCustomizeView');

    function checkConsent() {
        if (!localStorage.getItem(STORAGE_KEY)) {
            openCookieSettings();
        }
    }

    function openCookieSettings() {
        modal.style.display = 'flex';
        modal.style.opacity = '1';
        if (trigger) trigger.style.display = 'none';

        // Show Customize view directly
        mainView.style.display = 'none';
        customizeView.style.display = 'block';
        
        // Sync toggles with existing preferences
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved) {
            const prefs = JSON.parse(saved);
            document.getElementById('analyticsCookies').checked = prefs.analytics || false;
            document.getElementById('marketingCookies').checked = prefs.marketing || false;
        }
    }

    function hideModal() {
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
            if (trigger) trigger.style.display = 'flex';
        }, 400);
    }

    function consentAll() {
        const preferences = {
            essential: true,
            analytics: true,
            marketing: true,
            timestamp: new Date().toISOString()
        };
        localStorage.setItem(STORAGE_KEY, JSON.stringify(preferences));
        hideModal();
    }

    function rejectAll() {
        const preferences = {
            essential: true,
            analytics: false,
            marketing: false,
            timestamp: new Date().toISOString()
        };
        localStorage.setItem(STORAGE_KEY, JSON.stringify(preferences));
        hideModal();
    }

    function showCustomize() {
        mainView.style.display = 'none';
        customizeView.style.display = 'block';
    }

    function saveCustom() {
        const preferences = {
            essential: true,
            analytics: document.getElementById('analyticsCookies').checked,
            marketing: document.getElementById('marketingCookies').checked,
            timestamp: new Date().toISOString()
        };
        localStorage.setItem(STORAGE_KEY, JSON.stringify(preferences));
        hideModal();
    }

    // Run check on load
    document.addEventListener('DOMContentLoaded', checkConsent);
</script>
