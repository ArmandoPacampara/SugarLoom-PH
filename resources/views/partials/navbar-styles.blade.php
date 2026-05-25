.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 4rem;
    height: 70px;
    background: var(--pink-nav) !important;
    position: sticky;
    top: 0;
    z-index: 100;
    font-family: 'Poppins', sans-serif !important;
}

.logo {
    font-size: 1.1rem;
    font-weight: 900 !important;
    color: white !important;
    letter-spacing: 0;
    text-decoration: none !important;
    font-family: 'Poppins', sans-serif !important;
}

.nav-links {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 2.5rem;
}

.nav-links a {
    color: var(--white) !important;
    text-decoration: none !important;
    font-size: 0.9rem;
    font-weight: 400 !important;
    transition: opacity 0.2s;
    font-family: 'Poppins', sans-serif !important;
}

.nav-links form {
    margin: 0;
}

.nav-links button {
    background: transparent !important;
    border: 0 !important;
    color: var(--white) !important;
    cursor: pointer;
    font: inherit !important;
    font-family: 'Poppins', sans-serif !important;
    padding: 0;
}

.nav-links a:hover,
.nav-links button:hover {
    opacity: 0.8 !important;
}

.nav-actions {
    display: flex;
    gap: 0.8rem;
    align-items: center;
}

.account-dropdown {
    position: relative;
}

.account-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.5) !important;
    background: transparent !important;
    color: white !important;
    cursor: pointer;
    display: grid;
    place-items: center;
    transition: background 0.2s;
    padding: 0;
}

.account-btn:hover {
    background: rgba(255,255,255,0.2) !important;
}

.dropdown-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: white !important;
    min-width: 160px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    display: none;
    flex-direction: column;
    padding: 8px 0;
    z-index: 1000;
}

.dropdown-menu.show {
    display: flex;
}

.dropdown-menu a, .dropdown-menu button {
    padding: 10px 20px !important;
    text-decoration: none !important;
    color: var(--text-dark) !important;
    font-size: 0.9rem !important;
    text-align: left !important;
    transition: background 0.2s;
    width: 100% !important;
    border: 0 !important;
    background: transparent !important;
    cursor: pointer;
    font: inherit !important;
    font-family: 'Poppins', sans-serif !important;
}

.dropdown-menu a:hover, .dropdown-menu button:hover {
    background: #fdf2f8 !important;
    color: #fb7185 !important;
}

.nav-actions > button,
.nav-actions > a,
.nav-actions > span {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.5) !important;
    background: transparent !important;
    color: white !important;
    cursor: pointer;
    display: grid;
    place-items: center;
    transition: background 0.2s;
    padding: 0;
    position: relative;
    font-family: 'Poppins', sans-serif !important;
}

.nav-actions > button:hover,
.nav-actions > a:hover,
.nav-actions > span:hover {
    background: rgba(255,255,255,0.2) !important;
}

.nav-actions svg {
    width: 18px !important;
    height: 18px !important;
    fill: currentColor !important;
}

.cart-count {
    position: absolute;
    top: -9px !important;
    right: -7px !important;
    color: white !important;
    font-size: 0.72rem !important;
    font-weight: 800 !important;
    line-height: 1 !important;
    text-shadow: 0 1px 2px rgba(43, 27, 36, 0.45) !important;
    font-family: 'Poppins', sans-serif !important;
}

.cart-count.is-empty {
    display: none !important;
}

.login-btn {
    background: transparent !important;
    border: 0 !important;
    font: inherit !important;
    font-family: 'Poppins', sans-serif !important;
}
