/* Inline Tailwind Play CDN configuration.
   Loaded BEFORE the Tailwind CDN script with `tailwind.config = {...}`.
   Centralized here so every page references the same tokens. */

window.tailwind = window.tailwind || {};
window.tailwind.config = {
  darkMode: "class",
  theme: {
    container: {
      center: true,
      padding: "1.5rem",
    },
    extend: {
      colors: {
        bg: "#0A0A0A",
        surface: "#141414",
        "surface-2": "#1C1A18",
        ink: "#F5F1EA",
        muted: "#9C9690",
        "muted-2": "#7A7570",
        accent: "#C9A66B",
        "accent-dim": "#8A6F3F",
        hairline: "rgba(245,241,234,0.08)",
      },
      fontFamily: {
        display: ['"Inter Tight"', "Inter", "system-ui", "sans-serif"],
        body: ["Inter", "system-ui", "sans-serif"],
        label: ['"Tenor Sans"', '"Inter Tight"', "serif"],
      },
      letterSpacing: {
        "ultra-wide": "0.32em",
        "ultra-wider": "0.4em",
      },
      maxWidth: {
        "screen-3xl": "1440px",
      },
      transitionTimingFunction: {
        cinema: "cubic-bezier(0.22, 1, 0.36, 1)",
      },
    },
  },
};
