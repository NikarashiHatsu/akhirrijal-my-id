/* =====================================================================
   Akhirrijal Photography — Gallery
   Renders the masonry grid for a category and wires up PhotoSwipe v5.
   Expects:
     - <main data-category="street|human-interest|landscape|outdoor">
     - <div data-gallery></div>  (mount point)
     - assets/js/data.js to have populated window.PORTFOLIO_DATA

   Each tile carries data-pswp-title/story/location/date so the custom
   PhotoSwipe side-caption panel can read it on every slide change.
   ===================================================================== */

(function () {
  const main = document.querySelector("[data-category]");
  if (!main) return;
  const slug = main.dataset.category;
  const data = window.PORTFOLIO_DATA && window.PORTFOLIO_DATA[slug];
  if (!data) return;

  const mount = document.querySelector("[data-gallery]");
  if (!mount) return;

  const escape = (value) =>
    String(value == null ? "" : value)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#39;");

  const html = data.items
    .map((item, i) => {
      const counter = String(i + 1).padStart(2, "0");
      const safeTitle = escape(item.title);
      const safeStory = escape(item.story);
      const safeLocation = escape(item.location || "");
      const safeDate = escape(item.date || "");
      const safeAlt = escape(item.alt);
      return `
      <a
        class="gallery-item"
        href="${item.full}"
        data-pswp-width="${item.width}"
        data-pswp-height="${item.height}"
        data-pswp-title="${safeTitle}"
        data-pswp-story="${safeStory}"
        data-pswp-location="${safeLocation}"
        data-pswp-date="${safeDate}"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Open photo ${i + 1} of ${data.items.length}: ${safeTitle}"
      >
        <img
          src="${item.thumb}"
          srcset="${item.thumb} 900w, ${item.display} 1600w"
          sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw"
          alt="${safeAlt}"
          loading="lazy"
          decoding="async"
        />
        <figcaption class="caption">
          <span class="caption-eyebrow">${escape(data.title)} \u00b7 ${counter}</span>
          <span class="caption-title">${safeTitle}</span>
        </figcaption>
      </a>`;
    })
    .join("");

  mount.innerHTML = html;

  const prefersReducedMotion =
    window.matchMedia &&
    window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  if (!prefersReducedMotion) {
    mount.querySelectorAll(".gallery-item").forEach((el, i) => {
      el.style.opacity = "0";
      el.style.transform = "translateY(24px)";
      el.style.transition =
        "opacity .9s cubic-bezier(.22,1,.36,1), transform .9s cubic-bezier(.22,1,.36,1)";
      el.style.transitionDelay = `${Math.min(i * 0.05, 0.6)}s`;
    });

    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          entry.target.style.opacity = "1";
          entry.target.style.transform = "translateY(0)";
          io.unobserve(entry.target);
        });
      },
      { threshold: 0.05, rootMargin: "0px 0px -40px 0px" }
    );
    mount.querySelectorAll(".gallery-item").forEach((el) => io.observe(el));
  }

  // PhotoSwipe v5 with a Facebook-style side caption panel.
  import("https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe-lightbox.esm.min.js")
    .then(({ default: PhotoSwipeLightbox }) => {
      const lightbox = new PhotoSwipeLightbox({
        gallery: "[data-gallery]",
        children: "a.gallery-item",
        pswpModule: () =>
          import("https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe.esm.min.js"),
        bgOpacity: 0.96,
        showHideAnimationType: "fade",
        zoom: true,
        counter: true,
        spacing: 0.1,
        // Leave room for the caption panel so the photo never slides under it.
        paddingFn: (viewport) =>
          viewport.x >= 1024
            ? { top: 0, bottom: 0, left: 0, right: 380 }
            : { top: 0, bottom: 220, left: 0, right: 0 },
      });

      lightbox.on("uiRegister", () => {
        lightbox.pswp.ui.registerElement({
          name: "side-caption",
          order: 9,
          isButton: false,
          appendTo: "root",
          onInit: (el, pswp) => {
            el.classList.add("pswp-side-caption");

            const render = () => {
              const anchor = pswp.currSlide && pswp.currSlide.data && pswp.currSlide.data.element;
              if (!anchor) {
                el.innerHTML = "";
                return;
              }
              const title = anchor.dataset.pswpTitle || "";
              const story = anchor.dataset.pswpStory || "";
              const location = anchor.dataset.pswpLocation || "";
              const date = anchor.dataset.pswpDate || "";
              const meta = [location, date].filter(Boolean).join("  \u00b7  ");
              const idx = pswp.currIndex + 1;
              const total = pswp.getNumItems();
              const counter = `${String(idx).padStart(2, "0")} / ${String(total).padStart(2, "0")}`;

              el.innerHTML = `
                <div class="pswp-side-caption__inner">
                  <span class="pswp-side-caption__eyebrow">${escape(data.title)} \u00b7 ${counter}</span>
                  <h2 class="pswp-side-caption__title">${escape(title)}</h2>
                  ${meta ? `<p class="pswp-side-caption__meta">${escape(meta)}</p>` : ""}
                  ${story ? `<p class="pswp-side-caption__story">${escape(story)}</p>` : ""}
                </div>`;
            };

            pswp.on("change", render);
            pswp.on("afterInit", render);
            render();
          },
        });
      });

      lightbox.init();
    })
    .catch(() => {
      /* Lightbox failed to load — links gracefully open in a new tab. */
    });
})();
