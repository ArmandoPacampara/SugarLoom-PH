body.modal-open {
    overflow: hidden;
}

.login-overlay {
    align-items: center;
    background: rgba(43, 27, 36, 0.48);
    backdrop-filter: blur(8px);
    display: none;
    inset: 0;
    justify-content: center;
    padding: 2rem;
    position: fixed;
    z-index: 999;
}

.login-overlay.is-open {
    display: flex;
}

.login-popup {
    background:
        radial-gradient(circle at 88% 16%, rgba(255,255,255,0.95) 0 10rem, transparent 10.2rem),
        linear-gradient(105deg, #f7cbd5 0%, #fff5f0 100%);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: 26px;
    box-shadow: 0 28px 80px rgba(43, 27, 36, 0.28);
    display: grid;
    grid-template-columns: minmax(0, 0.95fr) minmax(320px, 0.82fr);
    gap: 1.5rem;
    max-width: 920px;
    min-height: 480px;
    overflow: hidden;
    padding: 2.1rem;
    position: relative;
    width: min(100%, 920px);
}

.login-copy {
    align-self: center;
    padding: 1rem 0.5rem 1rem 0.7rem;
}

.login-copy h2 {
    color: var(--text-dark, #1a1018);
    font-size: clamp(2.9rem, 5vw, 4.6rem);
    font-weight: 900;
    letter-spacing: 0;
    line-height: 0.96;
    margin-bottom: 1.15rem;
}

.login-copy h2 span {
    color: var(--text-accent, #a30f3b);
    display: block;
}

.login-copy p {
    color: var(--text-body, #4a3d45);
    font-size: 0.98rem;
    font-weight: 300;
    line-height: 1.65;
    margin: 0;
    max-width: 410px;
}

.login-panel {
    align-self: center;
    background: rgba(255,255,255,0.97);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: 22px;
    box-shadow: 0 18px 50px rgba(206, 90, 122, 0.18);
    padding: 2.25rem 2.25rem 1.8rem;
}

.login-panel h2 {
    color: var(--text-dark, #1a1018);
    font-size: 2rem;
    font-weight: 900;
    letter-spacing: 0;
    line-height: 1;
    margin-bottom: 0.55rem;
}

.login-panel .subtext {
    color: var(--text-muted, #8a7080);
    font-size: 0.94rem;
    line-height: normal;
    margin: 0;
    margin-bottom: 1.55rem;
    max-width: none;
}

.login-close {
    background: rgba(255,255,255,0.72);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 50%;
    color: var(--text-muted, #8a7080);
    cursor: pointer;
    font-size: 1.25rem;
    font-weight: 800;
    height: 34px;
    line-height: 1;
    position: absolute;
    right: 1rem;
    top: 1rem;
    width: 34px;
    z-index: 2;
}

.login-close:hover {
    color: var(--pink-btn, #ce5a7a);
}

.login-field {
    margin-bottom: 1rem;
}

.login-field label {
    color: var(--text-dark, #1a1018);
    display: block;
    font-size: 0.86rem;
    font-weight: 800;
    margin-bottom: 0.48rem;
}

.login-field input[type="email"],
.login-field input[type="password"] {
    background: #edf5ff;
    border: 1.5px solid #f0c8d3;
    border-radius: 999px;
    color: var(--text-dark, #1a1018);
    font: inherit;
    font-size: 0.86rem;
    outline: none;
    padding: 0.82rem 1rem;
    width: 100%;
}

.login-field input:focus {
    border-color: #ef7fa1;
    box-shadow: 0 0 0 3px rgba(239, 127, 161, 0.2);
}

.login-hint {
    color: var(--text-muted, #8a7080);
    display: block;
    font-size: 0.66rem;
    margin-top: 0.26rem;
}

.login-row {
    align-items: center;
    display: flex;
    justify-content: space-between;
    gap: 0.75rem;
    margin: 1.1rem 0 1.35rem;
}

.login-remember {
    align-items: center;
    color: var(--text-body, #4a3d45);
    display: flex;
    font-size: 0.82rem;
    font-weight: 700;
    gap: 0.45rem;
}

.login-remember input {
    accent-color: var(--pink-btn, #ce5a7a);
}

.login-forgot,
.login-register a {
    color: var(--pink-btn, #ce5a7a);
    font-size: 0.82rem;
    font-weight: 800;
    text-decoration: none;
}

.login-submit {
    background: var(--pink-btn, #ce5a7a);
    border: 0;
    border-radius: 999px;
    box-shadow: 0 12px 28px rgba(206, 90, 122, 0.28);
    color: var(--white, #ffffff);
    cursor: pointer;
    font: inherit;
    font-size: 0.92rem;
    font-weight: 900;
    padding: 0.86rem 1rem;
    width: 100%;
}

.login-register {
    color: var(--text-muted, #8a7080);
    font-size: 0.84rem;
    line-height: normal;
    margin-top: 1.25rem;
    max-width: none;
    text-align: center;
}

.login-errors,
.login-status {
    border-radius: 12px;
    font-size: 0.74rem;
    line-height: 1.45;
    margin-bottom: 0.85rem;
    padding: 0.65rem 0.75rem;
}

.login-errors {
    background: #fff1f2;
    color: #be123c;
}

.login-status {
    background: #ecfdf3;
    color: #166534;
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
