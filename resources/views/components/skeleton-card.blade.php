@props(['count' => 1, 'class' => 'catalog-card'])

@for ($i = 0; $i < $count; $i++)
<div class="{{ $class }} skeleton-card">
    <div class="skeleton-element skeleton-img-wrap"></div>
    <div class="skeleton-card-body">
        <div class="skeleton-name-row">
            <div class="skeleton-element skeleton-title"></div>
            <div class="skeleton-element skeleton-rating"></div>
        </div>
        <div class="skeleton-element skeleton-desc"></div>
        <div class="skeleton-element skeleton-desc" style="width: 80%"></div>
        <div class="skeleton-element skeleton-badge"></div>
        <div class="skeleton-element skeleton-button"></div>
    </div>
</div>
@endfor

<style>
/* ── UNIVERSAL SKELETON STYLES ── */
.skeleton-card {
    pointer-events: none !important;
    border-color: rgba(250, 232, 238, 0.4) !important;
    background: white !important;
    box-shadow: 0 4px 20px rgba(216,84,123,0.05) !important;
    display: flex;
    flex-direction: column;
}

.skeleton-card-body {
    padding: 1.5rem;
    flex-grow: 1;
}

.skeleton-name-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.skeleton-element {
    background: #f2f2f2 !important;
    position: relative;
    overflow: hidden;
    border: none !important;
}

.skeleton-element::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.7), transparent);
    animation: skeleton-shimmer 1.8s infinite linear;
}

@keyframes skeleton-shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.skeleton-img-wrap { 
    width: 100%;
    height: 240px; 
    border-radius: 16px 16px 0 0;
}

.skeleton-title { width: 55%; height: 1.4rem; border-radius: 6px; }
.skeleton-rating { width: 18%; height: 1.4rem; border-radius: 6px; }
.skeleton-desc { width: 100%; height: 0.9rem; border-radius: 4px; margin-bottom: 0.6rem; }
.skeleton-badge { width: 90px; height: 1.6rem; border-radius: 999px; margin-top: 0.8rem; margin-bottom: 1rem; }
.skeleton-button { width: 100%; height: 3rem; border-radius: 999px; margin-top: auto; }

/* Catalog Card Specific Overrides if any */
.catalog-card.skeleton-card .skeleton-img-wrap {
    border-radius: 16px;
    margin: 1rem 1rem 0;
    width: calc(100% - 2rem);
}
</style>
