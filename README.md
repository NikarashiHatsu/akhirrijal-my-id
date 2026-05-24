# Akhirrijal — Photography Portfolio

A cinematic, dark-luxury photography portfolio for **Qothrul Aziz Akhirrijal**, a Jakarta-based documentary and outdoor photographer. Built as a multi-page static site with Tailwind, Motion One, Lenis, and PhotoSwipe — no build pipeline required.

> Capturing authentic human moments, stories, and landscapes through visual storytelling.

---

## Quick start

There is no build step. Open `index.html` in any modern browser, or serve the directory with any static file server.

```bash
# Option 1 — Python (any version 3.x)
python3 -m http.server 4173

# Option 2 — Node (npx)
npx serve .

# Then open
open http://127.0.0.1:4173/
```

> Tip: the Tailwind Play CDN and Google Fonts both require network access. Open the site while online for the intended look.

---

## Site map

| Path | Purpose |
| --- | --- |
| `index.html` | Cinematic hero, about preview, 2×2 featured series, manifesto, contact CTA |
| `about.html` | Biography, experience cards, equipment cards, closing CTA |
| `portfolio.html` | Series hub — four alternating showcase blocks |
| `portfolio/street.html` | Masonry gallery — Street series (12 frames) |
| `portfolio/human-interest.html` | Masonry gallery — Human Interest series (12 frames) |
| `portfolio/landscape.html` | Masonry gallery — Landscape series (12 frames) |
| `portfolio/outdoor.html` | Masonry gallery — Outdoor series (12 frames) |
| `contact.html` | Direct contact details + project brief form |

---

## Stack

| Layer | Tool | Loaded via |
| --- | --- | --- |
| Utility CSS | **Tailwind CSS** (Play CDN) | `<script src="https://cdn.tailwindcss.com">` + inline config in `assets/js/tailwind.config.js` |
| Design tokens | Custom CSS | `assets/css/main.css` |
| Smooth scroll | **Lenis** | jsDelivr CDN |
| Scroll & entrance animation | **Motion One** (vanilla cousin of Framer Motion) | jsDelivr ESM, dynamically imported inside `site.js` |
| Lightbox | **PhotoSwipe v5** | jsDelivr ESM, dynamically imported inside `gallery.js` |
| Typography | `Inter Tight` (display), `Inter` (body), `Tenor Sans` (labels) | Google Fonts |
| Images | **Unsplash** CDN hotlinks with responsive widths | direct URLs in markup and in `assets/js/data.js` |

All third-party scripts use `defer`, dynamic `import()`, or `preconnect` to keep the critical render path small.

---

## File layout

```
ahirrizal-my-id/
├── index.html
├── about.html
├── portfolio.html
├── contact.html
├── portfolio/
│   ├── street.html
│   ├── human-interest.html
│   ├── landscape.html
│   └── outdoor.html
├── assets/
│   ├── css/
│   │   └── main.css          # design tokens + base type + utilities
│   ├── js/
│   │   ├── tailwind.config.js # Tailwind Play config (loaded before CDN)
│   │   ├── site.js            # Lenis, nav, reveal motion, page transitions
│   │   ├── gallery.js         # category-page masonry + PhotoSwipe init
│   │   └── data.js            # per-category Unsplash image catalog
│   └── partials/
│       ├── nav.html           # canonical reference (inlined on each page)
│       └── footer.html        # canonical reference (inlined on each page)
└── README.md
```

There is intentionally no template engine; the nav and footer markup is **inlined into every page** so the site can be opened directly from disk. The files in `assets/partials/` are the single source of truth for that markup — when you change them, update every page.

---

## Design system

A dark, editorial palette with a warm golden-beige accent.

| Token | Value | Use |
| --- | --- | --- |
| `--bg` | `#0A0A0A` | page background |
| `--surface` | `#141414` | cards & sections |
| `--surface-2` | `#1C1A18` | warm surface hover |
| `--text` | `#F5F1EA` | primary text |
| `--muted` | `#9C9690` | secondary text |
| `--accent` | `#C9A66B` | calls to action, dots, underlines |
| `--hairline` | `rgba(245,241,234,0.08)` | quiet dividers |

The same tokens are mirrored into the Tailwind config (`bg`, `surface`, `ink`, `accent`, etc.) so you can also use class names like `text-ink`, `bg-surface`, `text-accent`.

Typography uses three weights of `Inter Tight` (200/300/500) for display and `Inter` for body. Eyebrow labels use `Tenor Sans` in tracked-out uppercase.

---

## Customizing for production

This site is designed to be quickly skinnable into a real launch. The recommended steps:

### 1. Swap the placeholder photos

Two places to edit:

- **Hero & section images** — search each HTML file for `images.unsplash.com/photo-` and replace the URL with your own CDN-hosted image. Keep the responsive `srcset` pattern (`?w=900`, `?w=1600`, etc.) for performance.
- **Gallery images** — open [`assets/js/data.js`](assets/js/data.js) and replace each `make("PHOTO_ID", "alt text", "ratio")` entry. The first argument is the bare Unsplash photo ID (everything after `photo-` and before `?`); change `buildUrl()` if you're hosting elsewhere.

### 2. Replace the contact placeholders

Search every HTML file for these strings and replace them:

| Placeholder | Where it shows |
| --- | --- |
| `qothrul112358@gmail.com` | nav button mailto, footer, contact page |
| `6283824482936` | WhatsApp URL (E.164 without `+`) |
| `+62 838-2448-2936` | display WhatsApp number |
| `@senandung_hujan` | Instagram handle |
| `instagram.com/ahirrizal` | Instagram URL |
| `akhirrijal` | website URL (used in canonical, OG, and footer) |

### 3. Wire up a real contact form

`contact.html` ships with a `mailto:` form so it works without a backend. To swap in a real service (Formspree, Basin, Web3Forms, Cloudflare Worker, etc.):

```html
<!-- contact.html -->
<form action="https://formspree.io/f/your-id" method="post">
  …
</form>
```

…and remove `enctype="text/plain"`.

### 4. Compile Tailwind for production

The Tailwind Play CDN is fine for showcasing but adds ~80kb and a brief flash of unstyled content. For launch, compile a static stylesheet:

```bash
npx tailwindcss -i ./assets/css/main.css -o ./assets/css/built.css --minify \
  --content "./*.html,./portfolio/*.html"
```

Then on each page swap

```html
<script src="./assets/js/tailwind.config.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="./assets/css/main.css" />
```

for the single compiled file:

```html
<link rel="stylesheet" href="./assets/css/built.css" />
```

(The Tailwind config exports already-shaped tokens so the same class names continue to work.)

### 5. Self-host the libraries (optional)

To remove the runtime dependency on jsDelivr you can vendor:

- `lenis` → `assets/vendor/lenis.min.js`
- `motion@10` → `assets/vendor/motion.esm.min.js` (and adjust the dynamic `import()` in `site.js`)
- `photoswipe@5` → two files (`photoswipe.css`, `photoswipe-lightbox.esm.min.js`, `photoswipe.esm.min.js`)

---

## Accessibility & performance notes

- Semantic landmarks (`header`, `main`, `section`, `footer`, `nav`) and proper heading hierarchy on every page.
- All informative images have descriptive `alt`; decorative overlays are marked `aria-hidden`.
- Focus rings are styled in the accent color (never removed).
- `prefers-reduced-motion: reduce` disables Lenis, the Ken-Burns hero, and all reveal animations.
- Hero images use `<link rel="preload">` with `fetchpriority="high"`. Gallery thumbnails use native `loading="lazy"` and `decoding="async"`.
- `<link rel="preconnect">` to `fonts.googleapis.com`, `images.unsplash.com`, and `cdn.jsdelivr.net` on every page.
- Each page has a unique `<title>`, meta description, canonical link, Open Graph image, and Twitter card; the home and about pages also include `Person` JSON-LD.

---

## License & credits

All copy and the design system are made for Qothrul Aziz Akhirrijal. Placeholder photographs are sourced from [Unsplash](https://unsplash.com/license) and remain under their license; replace them with your own work before going live.

— *Crafted in Jakarta · Indonesia*
