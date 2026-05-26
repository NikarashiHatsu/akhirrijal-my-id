import 'photoswipe/style.css';

import Lenis from 'lenis';
import { animate, stagger } from 'motion';
import PhotoSwipeLightbox from 'photoswipe/lightbox';

const prefersReducedMotion =
    typeof window.matchMedia === 'function' &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const cinemaEasing = [0.22, 1, 0.36, 1];

const escapeHtml = (value) =>
    String(value == null ? '' : value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');

function initLenis() {
    if (prefersReducedMotion) {
        return null;
    }

    const lenis = new Lenis({
        lerp: 0.085,
        smoothWheel: true,
        wheelMultiplier: 1,
        touchMultiplier: 1.2,
    });

    const raf = (time) => {
        lenis.raf(time);
        requestAnimationFrame(raf);
    };
    requestAnimationFrame(raf);

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href^="#"]');
        if (! link) {
            return;
        }

        const id = link.getAttribute('href').slice(1);
        if (! id) {
            return;
        }

        const target = document.getElementById(id);
        if (! target) {
            return;
        }

        event.preventDefault();
        lenis.scrollTo(target, { offset: -80, duration: 1.4 });
    });

    return lenis;
}

function initReveals() {
    const elements = document.querySelectorAll('[data-reveal]');
    if (! elements.length && ! document.querySelector('[data-reveal-group]')) {
        return;
    }

    if (prefersReducedMotion) {
        elements.forEach((el) => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (! entry.isIntersecting) {
                    return;
                }
                const el = entry.target;
                const delay = parseFloat(el.dataset.revealDelay || '0');
                const y = parseFloat(el.dataset.revealY || '28');
                animate(
                    el,
                    { opacity: [0, 1], transform: [`translateY(${y}px)`, 'translateY(0px)'] },
                    { duration: 0.95, easing: cinemaEasing, delay }
                );
                observer.unobserve(el);
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -60px 0px' }
    );

    elements.forEach((el) => observer.observe(el));

    document.querySelectorAll('[data-reveal-group]').forEach((group) => {
        const children = group.querySelectorAll('[data-reveal-child]');
        const baseDelay = parseFloat(group.dataset.revealDelay || '0');
        const step = parseFloat(group.dataset.revealStagger || '0.08');
        children.forEach((child, index) => {
            child.setAttribute('data-reveal', '');
            child.dataset.revealDelay = (baseDelay + index * step).toString();
            observer.observe(child);
        });
    });
}

function initHero() {
    const hero = document.querySelector('[data-hero]');
    if (! hero) {
        return;
    }

    const lines = hero.querySelectorAll('[data-hero-stagger] > *');
    if (! lines.length) {
        return;
    }

    if (prefersReducedMotion) {
        lines.forEach((line) => {
            line.style.opacity = '1';
            line.style.transform = 'none';
        });
        return;
    }

    lines.forEach((line) => {
        line.style.opacity = '0';
        line.style.transform = 'translateY(36px)';
    });

    animate(
        lines,
        { opacity: [0, 1], transform: ['translateY(36px)', 'translateY(0px)'] },
        {
            duration: 1.1,
            easing: cinemaEasing,
            delay: stagger(0.12, { start: 0.2 }),
        }
    );
}

function initNav() {
    const nav = document.querySelector('.site-nav');
    if (! nav) {
        return;
    }

    const setScrolled = () => {
        if (window.scrollY > 24) {
            nav.classList.add('nav--scrolled');
        } else {
            nav.classList.remove('nav--scrolled');
        }
    };

    setScrolled();
    window.addEventListener('scroll', setScrolled, { passive: true });
}

function initMobileMenu() {
    const toggle = document.querySelector('[data-menu-toggle]');
    const close = document.querySelector('[data-menu-close]');
    const menu = document.querySelector('[data-mobile-menu]');
    if (! toggle || ! menu) {
        return;
    }

    const open = () => {
        menu.classList.add('open');
        document.documentElement.style.overflow = 'hidden';
    };

    const shut = () => {
        menu.classList.remove('open');
        document.documentElement.style.overflow = '';
    };

    toggle.addEventListener('click', open);
    if (close) {
        close.addEventListener('click', shut);
    }
    menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', shut));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            shut();
        }
    });
}

function resetPageVisibility() {
    document.body.classList.remove('page-leaving');

    const main = document.querySelector('main');
    if (main) {
        main.style.transition = 'none';
        main.style.opacity = '1';
        void main.offsetHeight;
        main.style.removeProperty('transition');
        main.style.removeProperty('opacity');
    }

    document.documentElement.style.overflow = '';

    document.querySelectorAll('[data-reveal], [data-hero-stagger] > *, [data-gallery] .gallery-item').forEach((el) => {
        el.style.opacity = '1';
        el.style.transform = 'none';
    });
}

function initBfcacheRecovery() {
    window.addEventListener('pagehide', resetPageVisibility);
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            resetPageVisibility();
        }
    });
}

function initPageTransitions() {
    if (prefersReducedMotion) {
        return;
    }

    const sameOrigin = (href) => {
        try {
            const url = new URL(href, window.location.href);
            return url.origin === window.location.origin;
        } catch {
            return false;
        }
    };

    document.addEventListener('click', (event) => {
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
        }

        const link = event.target.closest('a');
        if (! link) {
            return;
        }

        const href = link.getAttribute('href');
        if (! href) {
            return;
        }

        if (
            href.startsWith('#') ||
            href.startsWith('mailto:') ||
            href.startsWith('tel:') ||
            link.target === '_blank' ||
            link.hasAttribute('download') ||
            link.hasAttribute('data-no-transition') ||
            ! sameOrigin(href)
        ) {
            return;
        }

        event.preventDefault();
        document.body.classList.add('page-leaving');
        setTimeout(() => {
            window.location.href = href;
        }, 280);
    });
}

function initYear() {
    document.querySelectorAll('[data-year]').forEach((el) => {
        el.textContent = String(new Date().getFullYear());
    });
}

function initGallery() {
    const mount = document.querySelector('[data-gallery]');
    if (! mount) {
        return;
    }

    const galleryTitle = mount.dataset.galleryTitle || '';
    const items = mount.querySelectorAll('a.gallery-item');
    if (! items.length) {
        return;
    }

    if (! prefersReducedMotion) {
        items.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(24px)';
            item.style.transition =
                'opacity .9s cubic-bezier(.22,1,.36,1), transform .9s cubic-bezier(.22,1,.36,1)';
            item.style.transitionDelay = `${Math.min(index * 0.05, 0.6)}s`;
        });

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (! entry.isIntersecting) {
                        return;
                    }
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                });
            },
            { threshold: 0.05, rootMargin: '0px 0px -40px 0px' }
        );
        items.forEach((item) => observer.observe(item));
    }

    const lightbox = new PhotoSwipeLightbox({
        gallery: '[data-gallery]',
        children: 'a.gallery-item',
        pswpModule: () => import('photoswipe'),
        bgOpacity: 0.96,
        showHideAnimationType: 'fade',
        zoom: true,
        counter: true,
        spacing: 0.1,
        paddingFn: (viewport) =>
            viewport.x >= 1024
                ? { top: 0, bottom: 0, left: 0, right: 380 }
                : { top: 0, bottom: 220, left: 0, right: 0 },
    });

    lightbox.on('uiRegister', () => {
        lightbox.pswp.ui.registerElement({
            name: 'side-caption',
            order: 9,
            isButton: false,
            appendTo: 'root',
            onInit: (el, pswp) => {
                el.classList.add('pswp-side-caption');

                const render = () => {
                    const anchor = pswp.currSlide && pswp.currSlide.data && pswp.currSlide.data.element;
                    if (! anchor) {
                        el.innerHTML = '';
                        return;
                    }

                    const title = anchor.dataset.pswpTitle || '';
                    const story = anchor.dataset.pswpStory || '';
                    const location = anchor.dataset.pswpLocation || '';
                    const date = anchor.dataset.pswpDate || '';
                    const meta = [location, date].filter(Boolean).join('  \u00b7  ');
                    const idx = pswp.currIndex + 1;
                    const total = pswp.getNumItems();
                    const counter = `${String(idx).padStart(2, '0')} / ${String(total).padStart(2, '0')}`;

                    el.innerHTML = `
                        <div class="pswp-side-caption__inner">
                            <span class="pswp-side-caption__eyebrow">${escapeHtml(galleryTitle)} \u00b7 ${counter}</span>
                            <h2 class="pswp-side-caption__title">${escapeHtml(title)}</h2>
                            ${meta ? `<p class="pswp-side-caption__meta">${escapeHtml(meta)}</p>` : ''}
                            ${story ? `<p class="pswp-side-caption__story">${escapeHtml(story)}</p>` : ''}
                        </div>`;
                };

                pswp.on('change', render);
                pswp.on('afterInit', render);
                render();
            },
        });
    });

    lightbox.init();
}

document.addEventListener('DOMContentLoaded', () => {
    initBfcacheRecovery();
    initLenis();
    initNav();
    initMobileMenu();
    initYear();
    initPageTransitions();
    initHero();
    initReveals();
    initGallery();
});
