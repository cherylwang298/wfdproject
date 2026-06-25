<?php
// _head.php — shared <head> content
$pageTitle = $pageTitle ?? 'StayGo - Atmospheric Travel';
?>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title><?= htmlspecialchars($pageTitle) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        colors: {
          "on-tertiary-fixed": "#141d21",
          "surface-container": "#e7eeff",
          "on-surface": "#111c2d",
          "primary-fixed": "#dce1ff",
          "surface-dim": "#cfdaf2",
          "on-primary": "#ffffff",
          "error-container": "#ffdad6",
          "outline-variant": "#c3c5d8",
          "on-secondary": "#ffffff",
          "on-primary-container": "#fffbff",
          "on-error": "#ffffff",
          "primary-fixed-dim": "#b6c4ff",
          "inverse-primary": "#b6c4ff",
          "tertiary-fixed-dim": "#bfc8ce",
          "on-primary-fixed-variant": "#003ab2",
          "surface-container-high": "#dee8ff",
          "on-primary-fixed": "#001550",
          "primary-container": "#3267ff",
          "on-secondary-fixed-variant": "#004e60",
          "on-error-container": "#93000a",
          "outline": "#737687",
          "on-tertiary-container": "#fbfdff",
          "surface-tint": "#004ee8",
          "surface-container-lowest": "#ffffff",
          "on-secondary-container": "#00566a",
          "on-surface-variant": "#434655",
          "inverse-on-surface": "#ecf1ff",
          "secondary-fixed-dim": "#47d6ff",
          "tertiary-container": "#6d767b",
          "error": "#ba1a1a",
          "surface": "#f9f9ff",
          "secondary-fixed": "#b6ebff",
          "on-secondary-fixed": "#001f28",
          "surface-bright": "#f9f9ff",
          "tertiary-fixed": "#dbe4ea",
          "secondary": "#00677f",
          "on-tertiary": "#ffffff",
          "surface-container-low": "#f0f3ff",
          "background": "#f9f9ff",
          "tertiary": "#545d62",
          "surface-variant": "#d8e3fb",
          "secondary-container": "#00d2ff",
          "primary": "#004ce2",
          "on-background": "#111c2d",
          "on-tertiary-fixed-variant": "#3f484d",
          "surface-container-highest": "#d8e3fb",
          "inverse-surface": "#263143"
        },
        borderRadius: {
          DEFAULT: "1rem", lg: "2rem", xl: "3rem", full: "9999px"
        },
        spacing: {
          gutter: "24px", "margin-mobile": "20px", "container-max": "1280px",
          base: "8px", "margin-desktop": "64px"
        },
        fontFamily: {
          "headline-md": ["Plus Jakarta Sans"], "body-md": ["Plus Jakarta Sans"],
          "body-lg": ["Plus Jakarta Sans"], "label-sm": ["Plus Jakarta Sans"],
          display: ["Plus Jakarta Sans"], "headline-lg": ["Plus Jakarta Sans"],
          "headline-lg-mobile": ["Plus Jakarta Sans"], "label-md": ["Plus Jakarta Sans"]
        },
        fontSize: {
          "headline-md": ["24px", { lineHeight: "1.3", fontWeight: "600" }],
          "body-md": ["16px", { lineHeight: "1.5", fontWeight: "400" }],
          "body-lg": ["18px", { lineHeight: "1.6", fontWeight: "400" }],
          "label-sm": ["12px", { lineHeight: "1.2", fontWeight: "700" }],
          display: ["56px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "800" }],
          "headline-lg": ["40px", { lineHeight: "1.2", letterSpacing: "-0.01em", fontWeight: "700" }],
          "headline-lg-mobile": ["32px", { lineHeight: "1.2", fontWeight: "700" }],
          "label-md": ["14px", { lineHeight: "1.2", letterSpacing: "0.02em", fontWeight: "600" }]
        }
      }
    }
  }
</script>
<style>
  body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }
  .material-symbols-outlined { font-variation-settings: 'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24; }
  .icon-fill { font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24; }
  .hide-scrollbar::-webkit-scrollbar { display: none; }
  .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .glass-card {
    background-color: rgba(255,255,255,0.7);
    backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.3);
    box-shadow: 0 20px 40px -10px rgba(0,76,226,0.1);
  }
  .glass-panel {
    background-color: rgba(255,255,255,0.7);
    backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.6);
    box-shadow: 0 8px 32px rgba(0,76,226,0.08);
  }
  .glass-input {
    background-color: rgba(249,249,255,0.8);
    border: 1px solid rgba(195,197,216,0.5);
    transition: all 0.2s ease;
  }
  .glass-input:focus-within { background-color:#fff; border-color:#004ce2; box-shadow:0 0 0 4px rgba(0,76,226,0.1); }
  .gradient-button {
    background: linear-gradient(90deg,#004ce2 0%,#00d2ff 100%);
    color: white; transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .gradient-button:hover { transform: scale(1.02); box-shadow: 0 12px 24px rgba(0,76,226,0.25); }
  input[type=range] { -webkit-appearance:none; width:100%; background:transparent; }
  input[type=range]::-webkit-slider-thumb { -webkit-appearance:none; height:20px; width:20px; border-radius:50%; background:#004ce2; cursor:pointer; margin-top:-8px; box-shadow:0 2px 6px rgba(0,76,226,0.3); border:2px solid white; }
  input[type=range]::-webkit-slider-runnable-track { width:100%; height:4px; cursor:pointer; background:#c3c5d8; border-radius:2px; }
</style>