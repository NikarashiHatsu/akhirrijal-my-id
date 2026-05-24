/* =====================================================================
   Akhirrijal Photography — Site behavior
   Lenis smooth scroll + Motion One scroll reveals + nav state + page fade
   ===================================================================== */

const prefersReducedMotion =
  window.matchMedia &&
  window.matchMedia("(prefers-reduced-motion: reduce)").matches;

/* ---------- Lenis smooth scroll ---------- */
function initLenis() {
  if (prefersReducedMotion) return null;
  if (typeof window.Lenis !== "function") return null;

  const lenis = new window.Lenis({
    lerp: 0.085,
    smoothWheel: true,
    wheelMultiplier: 1,
    touchMultiplier: 1.2,
  });

  function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
  }
  requestAnimationFrame(raf);

  // Anchor support
  document.addEventListener("click", (e) => {
    const a = e.target.closest('a[href^="#"]');
    if (!a) return;
    const id = a.getAttribute("href").slice(1);
    if (!id) return;
    const el = document.getElementById(id);
    if (!el) return;
    e.preventDefault();
    lenis.scrollTo(el, { offset: -80, duration: 1.4 });
  });

  return lenis;
}

/* ---------- Reveal-on-scroll ---------- */
async function initReveals() {
  const els = document.querySelectorAll("[data-reveal]");
  if (!els.length) return;

  if (prefersReducedMotion) {
    els.forEach((el) => {
      el.style.opacity = "1";
      el.style.transform = "none";
    });
    return;
  }

  let motion = null;
  try {
    motion = await import(
      "https://cdn.jsdelivr.net/npm/motion@10.18.0/+esm"
    );
  } catch (err) {
    // Graceful fallback — show everything if Motion can't load
    els.forEach((el) => {
      el.style.transition = "opacity .8s ease, transform .8s ease";
      el.style.opacity = "1";
      el.style.transform = "none";
    });
    return;
  }

  const { animate } = motion;
  const easing = [0.22, 1, 0.36, 1];

  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const delay = parseFloat(el.dataset.revealDelay || "0");
        const y = parseFloat(el.dataset.revealY || "28");
        animate(
          el,
          { opacity: [0, 1], transform: [`translateY(${y}px)`, "translateY(0px)"] },
          { duration: 0.95, easing, delay }
        );
        io.unobserve(el);
      });
    },
    { threshold: 0.12, rootMargin: "0px 0px -60px 0px" }
  );

  els.forEach((el) => io.observe(el));

  // Stagger groups
  document.querySelectorAll("[data-reveal-group]").forEach((group) => {
    const children = group.querySelectorAll("[data-reveal-child]");
    const baseDelay = parseFloat(group.dataset.revealDelay || "0");
    const step = parseFloat(group.dataset.revealStagger || "0.08");
    children.forEach((child, i) => {
      child.setAttribute("data-reveal", "");
      child.dataset.revealDelay = (baseDelay + i * step).toString();
      io.observe(child);
    });
  });
}

/* ---------- Hero entrance ---------- */
async function initHero() {
  const hero = document.querySelector("[data-hero]");
  if (!hero) return;

  const lines = hero.querySelectorAll("[data-hero-stagger] > *");
  if (!lines.length) return;

  if (prefersReducedMotion) {
    lines.forEach((l) => {
      l.style.opacity = "1";
      l.style.transform = "none";
    });
    return;
  }

  try {
    const { animate, stagger } = await import(
      "https://cdn.jsdelivr.net/npm/motion@10.18.0/+esm"
    );
    lines.forEach((l) => {
      l.style.opacity = "0";
      l.style.transform = "translateY(36px)";
    });
    animate(
      lines,
      { opacity: [0, 1], transform: ["translateY(36px)", "translateY(0px)"] },
      {
        duration: 1.1,
        easing: [0.22, 1, 0.36, 1],
        delay: stagger(0.12, { start: 0.2 }),
      }
    );
  } catch (err) {
    lines.forEach((l) => {
      l.style.transition = "opacity 1s ease, transform 1s ease";
      l.style.opacity = "1";
      l.style.transform = "none";
    });
  }
}

/* ---------- Nav scroll state ---------- */
function initNav() {
  const nav = document.querySelector(".site-nav");
  if (!nav) return;
  const setScrolled = () => {
    if (window.scrollY > 24) nav.classList.add("nav--scrolled");
    else nav.classList.remove("nav--scrolled");
  };
  setScrolled();
  window.addEventListener("scroll", setScrolled, { passive: true });
}

/* ---------- Mobile menu ---------- */
function initMobileMenu() {
  const toggle = document.querySelector("[data-menu-toggle]");
  const close = document.querySelector("[data-menu-close]");
  const menu = document.querySelector("[data-mobile-menu]");
  if (!toggle || !menu) return;

  const open = () => {
    menu.classList.add("open");
    document.documentElement.style.overflow = "hidden";
  };
  const shut = () => {
    menu.classList.remove("open");
    document.documentElement.style.overflow = "";
  };

  toggle.addEventListener("click", open);
  if (close) close.addEventListener("click", shut);
  menu.querySelectorAll("a").forEach((a) => a.addEventListener("click", shut));
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") shut();
  });
}

/* ---------- Page transition fade ---------- */
function initPageTransitions() {
  if (prefersReducedMotion) return;

  document.addEventListener("click", (e) => {
    const a = e.target.closest("a");
    if (!a) return;
    const href = a.getAttribute("href");
    if (!href) return;
    if (
      href.startsWith("#") ||
      href.startsWith("mailto:") ||
      href.startsWith("tel:") ||
      href.startsWith("https://") ||
      href.startsWith("http://") ||
      a.target === "_blank" ||
      a.hasAttribute("data-no-transition")
    ) {
      return;
    }
    // internal link
    e.preventDefault();
    document.body.classList.add("page-leaving");
    setTimeout(() => {
      window.location.href = href;
    }, 280);
  });
}

/* ---------- Year stamp ---------- */
function initYear() {
  document.querySelectorAll("[data-year]").forEach((el) => {
    el.textContent = new Date().getFullYear();
  });
}

/* ---------- Boot ---------- */
document.addEventListener("DOMContentLoaded", () => {
  initLenis();
  initNav();
  initMobileMenu();
  initYear();
  initPageTransitions();
  initHero();
  initReveals();
});
