{{-- A still copy of the top of the home page (top bar, menu bar, first hero slide), shown the moment
     the HTML arrives. The app replaces it once it starts. It uses only the inline styles below, so it
     needs neither the stylesheet nor JavaScript. Keep it in step with the hero in pages/Home.vue. --}}
<style>
    body{margin:0}
    .hs{font-family:'DM Sans',ui-sans-serif,system-ui,sans-serif;-webkit-font-smoothing:antialiased;min-height:100vh;background:#fff}
    .hs *{box-sizing:border-box;margin:0}
    .hs-c{width:100%;margin:0 auto}
    @media(min-width:640px){.hs-c{max-width:40rem}}
    @media(min-width:768px){.hs-c{max-width:48rem}}
    @media(min-width:1024px){.hs-c{max-width:64rem}}
    @media(min-width:1280px){.hs-c{max-width:80rem}}
    @media(min-width:1536px){.hs-c{max-width:96rem}}
    .hs-top{height:25px;background:#fff;border-bottom:1px solid #e2e8f0}
    .hs-nav{background:rgba(2,6,23,.95);border-bottom:1px solid #3a3a3a}
    .hs-nav .hs-c{display:flex;align-items:center;justify-content:space-between;padding:8px 16px;min-height:56px}
    .hs-logo{display:flex;align-items:center;gap:12px;color:#fff;font-size:18px;line-height:28px;font-weight:600;letter-spacing:-.025em;text-decoration:none}
    .hs-logo img{height:36px;width:auto}
    .hs-menu{display:inline-flex;height:40px;width:40px;align-items:center;justify-content:center;border-radius:8px;border:1px solid #1e293b;background:#0f172a;color:rgba(255,255,255,.9)}
    .hs-hero{position:relative;overflow:hidden;min-height:64vh}
    .hs-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
    .hs-shade{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.8),rgba(0,0,0,.55),rgba(0,0,0,.4))}
    .hs-slide{position:relative;min-height:64vh;display:flex;align-items:center}
    .hs-slide .hs-c{padding:64px 24px}
    .hs-copy{max-width:48rem}
    .hs-pill{display:inline-flex;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:9999px;padding:6px 16px;font-size:12px;line-height:16px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:#de9fe9;margin-bottom:24px}
    .hs h1{font-size:36px;line-height:1.05;font-weight:700;letter-spacing:-.025em;color:#fff;margin-bottom:24px}
    .hs-lead{color:rgba(255,255,255,.8);font-size:16px;line-height:1.625;max-width:36rem;margin-bottom:40px}
    .hs-ctas{display:flex;flex-wrap:wrap;align-items:center;gap:16px}
    .hs-btn{display:inline-flex;align-items:center;gap:8px;padding:14px 32px;font-size:14px;line-height:20px;font-weight:600;border-radius:9999px;color:#fff;text-decoration:none}
    .hs-btn-1{background:#ad0ec9}
    .hs-btn-2{border:1px solid rgba(255,255,255,.3)}
    /* At least as tall as the app's counter bar, so the app's hero image is never larger than
       this one and the browser doesn't count it as a new, later "largest paint". */
    .hs-count{position:relative;min-height:130px;border-top:1px solid rgba(255,255,255,.1);background:rgba(0,0,0,.2)}
    @media(min-width:768px){
        .hs-hero,.hs-slide{min-height:78vh}
        .hs-slide .hs-c{padding:80px 24px}
        .hs h1{font-size:48px}
        .hs-lead{font-size:18px}
        .hs-count{min-height:150px}
    }
    @media(min-width:1024px){.hs-menu{display:none}.hs h1{font-size:60px}.hs-nav .hs-c{padding:7px 24px 8px;min-height:0}}
</style>
<div class="hs">
    <div class="hs-top"></div>
    <div class="hs-nav">
        <div class="hs-c">
            <a href="/" class="hs-logo">
                <img src="{{ $logoUrl ?: \Illuminate\Support\Facades\Vite::asset('resources/img/Omnivatech-logo.webp') }}" alt="" height="36">
                <span>{{ $siteName }}</span>
            </a>
            <span class="hs-menu" aria-hidden="true"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg></span>
        </div>
    </div>
    <div class="hs-hero">
        <img class="hs-bg" src="{{ \Illuminate\Support\Facades\Vite::asset('resources/img/tech-background.webp') }}" alt="" width="1920" height="1080" fetchpriority="high" decoding="sync">
        <div class="hs-shade"></div>
        <div class="hs-slide">
            <div class="hs-c">
                <div class="hs-copy">
                    <span class="hs-pill">Welcome to OmniviaTech</span>
                    <h1>Innovative Technology Solutions</h1>
                    <p class="hs-lead">Empowering businesses with cutting-edge technology and digital transformation services across the globe.</p>
                    <div class="hs-ctas">
                        <a href="/services" class="hs-btn hs-btn-1">Explore Solutions <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg></a>
                        <a href="/about" class="hs-btn hs-btn-2">About OmniviaTech</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hs-count"></div>
    </div>
</div>
