@extends('layouts.app')

@section('content')
<style>
    /* 1. GLOBAL POLISH - Maintaining Home Palette */
    .sugar-page-wrapper {
        background-color: #FDFDFD !important;
        color: #4A4A4A !important;
        min-height: 100vh;
        font-family: 'Inter', -apple-system, sans-serif;
        display: flex;
        flex-direction: column;
    }

    .main-content-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 20px;
        overflow: visible;
    }

    /* 2. IMAGE SECTION - Refined Product Showcase */
    .product-showcase {
        background: linear-gradient(135deg, #F4A2B1 0%, #F8C3CD 100%) !important;
        border-radius: 50px;
        padding: 80px 40px;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: transform 0.4s ease;
    }

    .main-product-img {
        width: 100%;
        max-width: 420px;
        border-radius: 40px;
        border: 12px solid white;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        z-index: 2;
    }

    .floating-detail {
        position: absolute;
        bottom: -25px;
        right: 10%;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 8px solid white;
        background: white;
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        object-fit: cover;
        z-index: 3;
    }

    /* 3. TEXT CONTENT & BUTTONS */
    .sugar-title { 
        color: #2D2D2D !important; 
        font-weight: 800; 
        letter-spacing: -1.5px;
        line-height: 1.1;
    }
    
    .btn-sugar-main {
        background: #D86B84 !important;
        color: white !important;
        border: none;
        padding: 18px 45px;
        border-radius: 50px;
        font-weight: 700;
        box-shadow: 0 10px 20px rgba(216, 107, 132, 0.25);
        transition: all 0.3s ease;
    }
    .btn-sugar-main:hover { transform: translateY(-2px); box-shadow: 0 15px 25px rgba(216, 107, 132, 0.35); }

    /* 4. SUGGESTIONS SECTION - White Card Fix */
    .hero-card-dark {
        background: #121416;
        border-radius: 40px;
        height: 100%;
        min-height: 480px;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        color: white;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        z-index: 1;
    }
    
    .sugar-card-white {
        background: #FFFFFF !important;
        border-radius: 35px !important;
        border: 1px solid rgba(0,0,0,0.03) !important;
        padding: 30px;
        text-align: center;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        z-index: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); 
    }

    .hero-card-dark:hover, .sugar-card-white:hover { 
        transform: translateY(-12px) scale(1.01); 
        box-shadow: 0 30px 60px rgba(0,0,0,0.08);
        z-index: 10;
    }

    .btn-add-box {
        background-color: #5D3A42 !important; /* High contrast but brand-consistent */
        color: #FFFFFF !important;
        border: none;
        width: 100%;
        padding: 12px;
        border-radius: 18px;
        font-weight: 700;
        margin-top: 20px;
        transition: all 0.2s ease;
    }

    .btn-add-box:hover {
        background-color: #D86B84 !important;
        transform: scale(1.02);
    }

    .img-box-muted {
        border-radius: 25px;
        padding: 25px;
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
    }

    .sugar-footer {
        margin-top: 100px;
        padding: 40px 0;
        border-top: 1px solid #EEE;
    }
</style>

<div class="sugar-page-wrapper">
    <div class="main-content-container">
        
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6">
                <div class="product-showcase">
                    <img src="{{ asset('images/smores.jpg') }}" class="main-product-img" alt="The S'mores">
                    <img src="{{ asset('images/smores.jpg') }}" class="floating-detail" alt="Texture">
                </div>
            </div>

            <div class="col-lg-6 ps-lg-5">
                <div class="text-content">
                    <span class="text-uppercase fw-bold mb-2 d-block" style="color: #D86B84; letter-spacing: 3px; font-size: 13px;">Signature Collection</span>
                    <h1 class="sugar-title display-4 mb-3">The S'mores</h1>
                    
                    <div class="d-flex align-items-center gap-4 my-4">
                        <h2 class="fw-bold m-0" style="color: #D86B84; font-size: 42px;">₱55</h2>
                        <span style="background:#FBE6E9; color:#D86B84; padding:8px 20px; border-radius:15px; font-size:12px; font-weight:800; letter-spacing: 1px;">★ TOP PICK</span>
                    </div>

                    <p class="mb-5" style="font-size: 18px; line-height: 1.8; color: #5D5D5D !important;">
                        Indulge in our small-batch, handcrafted cookies baked daily. Our S'mores flavor is woven with premium chocolate and artisanal magic to satisfy your sweet dreams.
                    </p>

                    <div class="d-flex gap-4 align-items-center mt-5">
                        <button class="btn btn-sugar-main flex-grow-1">Add to Box</button>
                        <button class="btn btn-light rounded-circle border d-flex align-items-center justify-content-center shadow-sm" style="width:65px; height:65px; font-size: 22px; color: #D86B84;">
                            ♡
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 pt-5">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <h2 class="sugar-title fw-bold m-0" style="font-size: 36px;">You might also like</h2>
                    <p class="text-muted m-0 mt-2">Artisanal pairings curated for your sweet tooth.</p>
                </div>
                <a href="#" class="fw-bold text-decoration-none" style="color: #D86B84; font-size: 15px;">View Catalog <span class="ms-1">→</span></a>
            </div>

            <div class="row g-5"> 
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="hero-card-dark">
                        <img src="{{ asset('images/smores.jpg') }}" class="hero-card-img" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.5;">
                        <div class="hero-card-content" style="position: relative; z-index: 2;">
                            <small class="text-uppercase opacity-75 fw-bold mb-2 d-block" style="letter-spacing: 2px; font-size: 11px;">The Classic</small>
                            <h3 class="fw-bold mb-4" style="font-size: 34px;">Triple Chocolate Sea Salt</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fs-3 fw-bold">60P</span>
                                <button class="btn btn-light rounded-pill px-5 py-2 fw-bold shadow-sm">Add Quick</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row g-4 h-100"> 
                        <div class="col-md-6">
                            <div class="sugar-card-white">
                                <div>
                                    <div class="img-box-muted" style="background: #E2EAD3;">
                                        <img src="{{ asset('images/smores.jpg') }}" class="img-fluid">
                                    </div>
                                    <h6 class="fw-bold mb-1" style="font-size: 18px;">Matcha Bliss</h6>
                                    <p class="small text-muted m-0">65P</p>
                                </div>
                                <button class="btn-add-box">Add</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sugar-card-white">
                                <div>
                                    <div class="img-box-muted" style="background: #F9E1E4;">
                                        <img src="{{ asset('images/smores.jpg') }}" class="img-fluid">
                                    </div>
                                    <h6 class="fw-bold mb-1" style="font-size: 18px;">Red Velvet</h6>
                                    <p class="small text-muted m-0">70P</p>
                                </div>
                                <button class="btn-add-box">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="sugar-footer d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-3 mb-md-0">
                <h6 class="fw-bold m-0" style="color: #D86B84; font-size: 18px;">SugarLoom PH</h6>
                <p class="text-muted small m-0">© 2026 SugarLoom PH. Baked with artisanal care.</p>
            </div>
            <div class="d-flex gap-5">
                <a href="#" class="text-muted text-decoration-none small fw-bold">Facebook</a>
                <a href="#" class="text-muted text-decoration-none small fw-bold">Instagram</a>
                <a href="#" class="text-muted text-decoration-none small fw-bold">Contact Us</a>
            </div>
        </footer>
    </div>
</div>
@endsection