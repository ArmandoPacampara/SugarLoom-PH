.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 4rem;
    height: 70px;
    background: var(--pink-nav);
    position: sticky;
    top: 0;
    z-index: 100;
}

.logo {
    font-size: 1.1rem;
    font-weight: 900;
    color: white;
    letter-spacing: 0;
    text-decoration: none;
}

.nav-links {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 2.5rem;
}

.nav-links a {
    color: var(--white);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 400;
    transition: opacity 0.2s;
}

.nav-links form {
    margin: 0;
}

.nav-links button {
    background: transparent;
    border: 0;
    color: var(--white);
    cursor: pointer;
    font: inherit;
    padding: 0;
}

.nav-links a:hover,
.nav-links button:hover {
    opacity: 0.8;
}

.nav-actions {
    display: flex;
    gap: 0.8rem;
}

.nav-actions > button,
.nav-actions > a,
.nav-actions > span {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.5);
    background: transparent;
    color: var(--text-dark);
    cursor: pointer;
    display: grid;
    place-items: center;
    transition: background 0.2s;
    padding: 0;
    position: relative;
}

.nav-actions > button:hover,
.nav-actions > a:hover,
.nav-actions > span:hover {
    background: rgba(255,255,255,0.2);
}

.nav-actions svg {
    width: 16px;
    height: 16px;
    fill: currentColor;
}

.cart-count {
    position: absolute;
    top: -9px;
    right: -7px;
    color: white;
    font-size: 0.72rem;
    font-weight: 800;
    line-height: 1;
    text-shadow: 0 1px 2px rgba(43, 27, 36, 0.45);
}

.cart-count.is-empty {
    display: none;
}

.login-btn {
    background: transparent;
    border: 0;
    font: inherit;
}
