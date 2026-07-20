import Alpine from 'alpinejs'
import morph from '@alpinejs/morph'
 
window.Alpine = Alpine
Alpine.plugin(morph)
Alpine.start()



// Auto contrast: picks light/dark text color based on computed background luminance
const CONTRAST_SELECTOR = '[data-contrast]'
const CONTRAST_HOVER_SELECTOR = '[data-contrast-hover]'
const ALL_CONTRAST_SELECTOR = '[data-contrast], [data-contrast-hover]'

function autoContrast(el) {
    const bg = getComputedStyle(el).backgroundColor
    const [r, g, b, a = 1] = (bg.match(/[\d.]+/g) || []).map(Number)
    if (a === 0 || [r, g, b].some(Number.isNaN)) {
        // Transparent baggrund — fjern inline color så CSS-cascade tager over
        if (el.matches('[data-contrast-hover]')) {
            el.style.removeProperty('color')
            el.style.removeProperty('--text-color')
        }
        return
    }

    const rootStyles = getComputedStyle(document.documentElement)
    const light = rootStyles.getPropertyValue('--contrast-light').trim() || '#ffffff'
    const dark = rootStyles.getPropertyValue('--contrast-dark').trim() || '#000000'
    const brightness = (r * 299 + g * 587 + b * 114) / 1000
    const textColor = brightness > 128 ? dark : light
    el.style.color = textColor
    el.style.setProperty('--text-color', textColor)
}

// Følger baggrundens transition frame-for-frame så tekstfarven flipper præcist
// når baggrunden krydser lys/mørk-grænsen (hover, disabled-toggle, slide)
function trackContrast(el) {
    const dur = parseFloat(getComputedStyle(el).transitionDuration) * 1000 || 0
    el._contrastUntil = performance.now() + dur + 50
    if (el._contrastTicking) return
    el._contrastTicking = true
    const tick = (now) => {
        if (now < el._contrastUntil) {
            autoContrast(el)
            requestAnimationFrame(tick)
        } else {
            el._contrastTicking = false
        }
    }
    requestAnimationFrame(tick)
}

window.applyContrastColors = function () {
    document.querySelectorAll(ALL_CONTRAST_SELECTOR).forEach(trackContrast)
}

// Hover: kun [data-contrast-hover] genberegnes ved mouseover/mouseout.
// Ved mouseout må vi IKKE bare fjerne inline color — knappen arver ellers
// forældrenes tekstfarve (fx hvid i en mørk hero) i stedet for den korrekte
// kontrastfarve til den hvilende baggrund (fx mørk på gul).
function onHoverContrast(e) {
    const el = e.target.closest?.(CONTRAST_HOVER_SELECTOR)
    if (!el) return
    if (e.type === 'mouseout' && el.contains(e.relatedTarget)) {
        return
    }
    trackContrast(el)
}
document.addEventListener('mouseover', onHoverContrast)
document.addEventListener('mouseout', onHoverContrast)

// MutationObserver: fanger DOM-ændringer (morph, class-skift, disabled-toggle)
let scheduled = false
const contrastObserver = new MutationObserver((mutations) => {
    for (const m of mutations) {
        if (m.type === 'attributes' && m.attributeName === 'disabled'
            && m.target.matches?.(ALL_CONTRAST_SELECTOR)) {
            trackContrast(m.target)
        }
    }
    if (scheduled) return
    scheduled = true
    requestAnimationFrame(() => {
        scheduled = false
        document.querySelectorAll(ALL_CONTRAST_SELECTOR).forEach(trackContrast)
    })
})
contrastObserver.observe(document.body, {
    childList: true,
    subtree: true,
    attributes: true,
    attributeFilter: ['class', 'disabled'],
})

document.addEventListener('DOMContentLoaded', window.applyContrastColors)

// LQIP: mark already-loaded images (e.g. from cache) as loaded immediately
document.querySelectorAll('.lqip .lqip-img').forEach(img => {
    if (img.complete) img.classList.add('lqip-loaded')
})

// Featured news: dynamic height for last item background
const featuredNews = document.querySelector('[data-featured-news]')
if (featuredNews) {
    const update = () => {
        requestAnimationFrame(() => {
            const last = featuredNews.querySelector('ul > li:last-child')
            if (last) featuredNews.style.setProperty('--dynamic-height', last.offsetHeight + 'px')
        })
    }
    update()
    window.addEventListener('resize', update)
}

// Player carousel buttons
const playerCarousel = document.querySelector('.player .carousel')
if (playerCarousel) {
    const prevBtn = document.querySelector('[data-carousel-prev]')
    const nextBtn = document.querySelector('[data-carousel-next]')

    const updateButtons = () => {
        if (prevBtn) prevBtn.disabled = playerCarousel.scrollLeft <= 0
        if (nextBtn) nextBtn.disabled = playerCarousel.scrollLeft + playerCarousel.clientWidth >= playerCarousel.scrollWidth - 1
    }

    prevBtn?.addEventListener('click', () => playerCarousel.scrollBy({ left: -playerCarousel.clientWidth, behavior: 'smooth' }))
    nextBtn?.addEventListener('click', () => playerCarousel.scrollBy({ left: playerCarousel.clientWidth, behavior: 'smooth' }))
    playerCarousel.addEventListener('scroll', updateButtons)
    updateButtons()
}

// Copyright year
const yearEl = document.getElementById('year')
if (yearEl) yearEl.textContent = new Date().getFullYear()

// Marquee: duplicate sponsor logos for seamless loop
const marquee = document.getElementById('marquee-logos')
if (marquee) {
    const items = Array.from(marquee.children)
    items.forEach(item => {
        const clone = item.cloneNode(true)
        clone.setAttribute('aria-hidden', 'true')
        clone.querySelectorAll('a').forEach(a => a.setAttribute('tabindex', '-1'))
        marquee.appendChild(clone)
    })
}

// Gallery lightbox
const galleries = document.querySelectorAll('[data-gallery]')
if (galleries.length) {
    const dlg = document.createElement('dialog')
    dlg.id = 'lb'
    dlg.style.cssText = 'border:none;padding:0;background:transparent;max-width:100%;max-height:100%;width:100vw;height:100dvh;'
    dlg.innerHTML =
        '<style>' +
        '#lb::backdrop{background:rgba(0,0,0,.88)}' +
        '#lb .lb-wrap{display:flex;align-items:center;justify-content:center;height:100%;gap:.5rem;padding:1rem}' +
        '#lb img{max-height:90dvh;max-width:min(85vw,1400px);object-fit:contain;display:block}' +
        '#lb[data-backdrop="light"] img{background:#fff;padding:1.5rem;border-radius:4px}' +
        '#lb .lb-btn{background:none;border:none;color:#fff;cursor:pointer;font-size:3rem;line-height:1;padding:.25rem .75rem;opacity:.6;transition:opacity .15s}' +
        '#lb .lb-btn:hover{opacity:1}' +
        '#lb .lb-close{position:absolute;top:1rem;right:1rem;font-size:1.5rem}' +
        '</style>' +
        '<div class="lb-wrap">' +
            '<button class="lb-btn lb-prev" aria-label="Forrige">&#8249;</button>' +
            '<img alt="">' +
            '<button class="lb-btn lb-next" aria-label="Næste">&#8250;</button>' +
        '</div>' +
        '<button class="lb-btn lb-close" aria-label="Luk">&#x2715;</button>'
    document.body.appendChild(dlg)

    const lbImg = dlg.querySelector('img')
    let lbSrcs = [], lbIdx = 0

    const lbNav = (dir) => {
        lbIdx = (lbIdx + dir + lbSrcs.length) % lbSrcs.length
        lbImg.src = lbSrcs[lbIdx]
    }

    dlg.querySelector('.lb-prev').addEventListener('click', () => lbNav(-1))
    dlg.querySelector('.lb-next').addEventListener('click', () => lbNav(1))
    dlg.querySelector('.lb-close').addEventListener('click', () => dlg.close())
    dlg.addEventListener('click', (e) => { if (e.target === dlg) dlg.close() })
    dlg.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') lbNav(-1)
        if (e.key === 'ArrowRight') lbNav(1)
    })

    galleries.forEach((gallery) => {
        const btns = Array.from(gallery.querySelectorAll('[data-src]'))
        btns.forEach((btn, i) => {
            btn.addEventListener('click', () => {
                lbSrcs = btns.map((b) => b.dataset.src)
                lbIdx = i
                lbImg.src = lbSrcs[lbIdx]
                dlg.dataset.backdrop = gallery.dataset.galleryBackdrop || ''
                dlg.showModal()
            })
        })
    })
}

// Intro slider
const slider = document.querySelector('.intro .slider');
const navButtons = document.querySelectorAll('.intro .slider-nav button');

if (slider && navButtons.length) {
    const slides = slider.querySelectorAll('.slide-item');
    const indicator = document.querySelector('.intro .slider-nav__indicator');
    const intro = document.querySelector('.intro');

    if (slides.length && intro) {
        const sliderSpeed = parseFloat(intro.dataset.sliderSpeed) || 6;
        const interval = Math.max(sliderSpeed, 1) * 1000;
        let currentIndex = 0;
        let timer = null;
        let startTime = null;
        let remaining = interval;

        function restartIndicator() {
            if (!indicator) return;
            indicator.classList.remove('is-animating');
            // Force reflow so the progress animation restarts cleanly
            void indicator.offsetWidth;
            indicator.classList.add('is-animating');
        }

        function goToSlide(index) {
            const slide = slides[index];
            if (!slide) return;

            currentIndex = index;
            // 'auto' — not 'smooth': smooth + scroll-snap can loop in Chrome
            slider.scrollTo({ left: slide.offsetLeft, behavior: 'auto' });
            navButtons.forEach((btn, i) => btn.classList.toggle('is-active', i === index));
            restartIndicator();
        }

        function scheduleNext(delay) {
            clearTimeout(timer);
            startTime = Date.now();
            remaining = delay;
            timer = setTimeout(() => {
                goToSlide((currentIndex + 1) % slides.length);
                scheduleNext(interval);
            }, delay);
        }

        function pause() {
            clearTimeout(timer);
            remaining = Math.max(remaining - (Date.now() - startTime), 0);
            indicator?.classList.add('is-paused');
        }

        function resume() {
            indicator?.classList.remove('is-paused');
            scheduleNext(remaining || interval);
        }

        navButtons.forEach((btn, i) => {
            btn.addEventListener('click', (e) => {
                // Inline-edit targets live inside these buttons — don't steal the click
                // (mouse) or a Space-key activation while editing.
                if (
                    e.target.closest('[data-sid-inline-edit], [data-sid-field], [contenteditable], [data-sve-editing]')
                    || btn.querySelector('[data-sve-editing], [contenteditable="true"]')
                ) {
                    return
                }
                goToSlide(i);
                scheduleNext(interval);
            });
        });

        intro.style.setProperty('--slider-interval', `${interval}ms`);
        if (intro.dataset.pauseOnHover === '1' || intro.dataset.pauseOnHover === 'true') {
            intro.addEventListener('mouseenter', pause);
            intro.addEventListener('mouseleave', resume);
        }

        goToSlide(0);

        if (window.self !== window.top) {
            window.addEventListener('slider:goto', (e) => goToSlide(e.detail));
        } else {
            scheduleNext(interval);
        }
    }
}
