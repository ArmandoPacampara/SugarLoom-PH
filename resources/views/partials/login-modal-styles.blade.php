body.modal-open {
    overflow: hidden;
}

.login-overlay {
    align-items: center;
    background: rgba(43, 27, 36, 0.48) !important;
    backdrop-filter: blur(8px) !important;
    display: none;
    inset: 0 !important;
    justify-content: center;
    padding: 2rem !important;
    position: fixed !important;
    z-index: 2000 !important;
}

.login-overlay.is-open {
    display: flex !important;
}

.login-popup {
    background:
        radial-gradient(circle at 88% 16%, rgba(255,255,255,0.95) 0 10rem, transparent 10.2rem),
        linear-gradient(105deg, #f7cbd5 0%, #fff5f0 100%) !important;
    border: 1px solid rgba(255,255,255,0.8) !important;
    border-radius: 26px !important;
    box-shadow: 0 28px 80px rgba(43, 27, 36, 0.28) !important;
    display: grid !important;
    grid-template-columns: minmax(0, 0.95fr) minmax(320px, 0.82fr) !important;
    gap: 1.5rem !important;
    max-width: 920px !important;
    min-height: 480px !important;
    overflow: hidden !important;
    padding: 2.1rem !important;
    position: relative !important;
    width: min(100%, 920px) !important;
    font-family: 'Poppins', sans-serif !important;
}

.login-copy {
    align-self: center !important;
    padding: 1rem 0.5rem 1rem 0.7rem !important;
}

.login-copy h2 {
    color: var(--text-dark, #1a1018) !important;
    font-size: clamp(2.9rem, 5vw, 4.6rem) !important;
    font-weight: 900 !important;
    letter-spacing: 0 !important;
    line-height: 0.96 !important;
    margin-bottom: 1.15rem !important;
    font-family: 'Poppins', sans-serif !important;
}

.login-copy h2 span {
    color: var(--text-accent, #a30f3b) !important;
    display: block !important;
}

.login-copy p {
    color: var(--text-body, #4a3d45) !important;
    font-size: 0.98rem !important;
    font-weight: 300 !important;
    line-height: 1.65 !important;
    margin: 0 !important;
    max-width: 410px !important;
    font-family: 'Poppins', sans-serif !important;
}

.login-panel {
    align-self: center !important;
    background: rgba(255,255,255,0.97) !important;
    border: 1px solid rgba(255,255,255,0.8) !important;
    border-radius: 22px !important;
    box-shadow: 0 18px 50px rgba(206, 90, 122, 0.18) !important;
    padding: 2.25rem 2.25rem 1.8rem !important;
}

.login-panel h2 {
    color: var(--text-dark, #1a1018) !important;
    font-size: 2rem !important;
    font-weight: 900 !important;
    letter-spacing: 0 !important;
    line-height: 1 !important;
    margin-bottom: 0.55rem !important;
    font-family: 'Poppins', sans-serif !important;
}

.login-panel .subtext {
    color: var(--text-muted, #8a7080) !important;
    font-size: 0.94rem !important;
    line-height: normal !important;
    margin: 0 !important;
    margin-bottom: 1.55rem !important;
    max-width: none !important;
}

.login-close {
    background: rgba(255,255,255,0.72) !important;
    border: 1px solid rgba(255,255,255,0.9) !important;
    border-radius: 50% !important;
    color: var(--text-muted, #8a7080) !important;
    cursor: pointer !important;
    font-size: 1.25rem !important;
    font-weight: 800 !important;
    height: 34px !important;
    line-height: 1 !important;
    position: absolute !important;
    right: 1rem !important;
    top: 1rem !important;
    width: 34px !important;
    z-index: 2 !important;
}

.login-close:hover {
    color: var(--pink-btn, #ce5a7a) !important;
}

.login-field {
    margin-bottom: 1rem !important;
}

.login-field label {
    color: var(--text-dark, #1a1018) !important;
    display: block !important;
    font-size: 0.86rem !important;
    font-weight: 800 !important;
    margin-bottom: 0.48rem !important;
    font-family: 'Poppins', sans-serif !important;
}

.login-field input[type="email"],
.login-field input[type="password"],
.login-field input[type="text"].login-password-input {
    background: #edf5ff !important;
    border: 1.5px solid #f0c8d3 !important;
    border-radius: 999px !important;
    color: var(--text-dark, #1a1018) !important;
    font: inherit !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.86rem !important;
    outline: none !important;
    padding: 0.82rem 1rem !important;
    width: 100% !important;
    min-height: 0 !important;
    box-sizing: border-box !important;
}

.login-password-wrap {
    position: relative !important;
}

.login-password-wrap input {
    padding-right: 4.5rem !important;
}

.login-password-toggle {
    background: transparent !important;
    border: 0 !important;
    color: var(--pink-btn, #ce5a7a) !important;
    cursor: pointer !important;
    font: inherit !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.72rem !important;
    font-weight: 900 !important;
    padding: 0.25rem 0.65rem !important;
    position: absolute !important;
    right: 0.54rem !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
}

.login-field input:focus {
    border-color: #ef7fa1 !important;
    box-shadow: 0 0 0 3px rgba(239, 127, 161, 0.2) !important;
}

.login-hint {
    color: var(--text-muted, #8a7080) !important;
    display: block !important;
    font-size: 0.66rem !important;
    margin-top: 0.26rem !important;
}

.login-row {
    align-items: center !important;
    display: flex !important;
    justify-content: space-between !important;
    gap: 0.75rem !important;
    margin: 1.1rem 0 1.35rem !important;
}

.login-remember {
    align-items: center !important;
    color: var(--text-body, #4a3d45) !important;
    display: flex !important;
    font-size: 0.82rem !important;
    font-weight: 700 !important;
    gap: 0.45rem !important;
}

.login-remember input {
    accent-color: var(--pink-btn, #ce5a7a) !important;
    width: auto !important;
    min-height: 0 !important;
}

.login-forgot,
.login-register a {
    color: var(--pink-btn, #ce5a7a) !important;
    font-size: 0.82rem !important;
    font-weight: 800 !important;
    text-decoration: none !important;
}

.login-submit {
    background: var(--pink-btn, #ce5a7a) !important;
    border: 0 !important;
    border-radius: 999px !important;
    box-shadow: 0 12px 28px rgba(206, 90, 122, 0.28) !important;
    color: var(--white, #ffffff) !important;
    cursor: pointer !important;
    font: inherit !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.92rem !important;
    font-weight: 900 !important;
    padding: 0.86rem 1rem !important;
    width: 100% !important;
    min-height: 0 !important;
}

.login-register {
    color: var(--text-muted, #8a7080) !important;
    font-size: 0.84rem !important;
    line-height: normal !important;
    margin-top: 1.25rem !important;
    max-width: none !important;
    text-align: center !important;
}

.login-errors,
.login-status {
    border-radius: 12px !important;
    font-size: 0.74rem !important;
    line-height: 1.45 !important;
    margin-bottom: 0.85rem !important;
    padding: 0.65rem 0.75rem !important;
}

.login-errors {
    background: #fff1f2 !important;
    color: #be123c !important;
}

.login-status {
    background: #ecfdf3 !important;
    color: #166534 !important;
}

@media (max-width: 760px) {
    .login-popup {
        display: block;
        min-height: 0;
        padding: 1rem;
    }

    .login-copy {
        display: none;
    }

    .login-panel {
        padding: 2.3rem 1.4rem 1.5rem;
    }
}
