# Audio Player Widget

An Elementor widget that renders a [Plyr](https://plyr.io/) audio player. Supports direct URL input or an ACF attachment field, making it suitable for any site — not just those using ACF.

---

## Requirements

- WordPress 6.0+
- PHP 8.0+
- Elementor (free or Pro)
- Advanced Custom Fields (free or Pro) — only required when using ACF field mode

---

## Installation

1. Upload the `audio-player-widget` folder to `/wp-content/plugins/`
2. Activate via **Plugins > Installed Plugins**
3. The widget appears in the Elementor panel under **General > Audio Player**

---

## Usage

1. Open your Elementor template
2. Search for **Audio Player** in the widget panel
3. Drag it onto the canvas
4. In the **Content** tab, choose your source type:
   - **Direct URL** — paste in any audio file URL
   - **ACF Field** — enter the ACF field slug that stores an audio attachment ID
5. In the **Style** tab, configure colours and border radius

---

## File structure

```
audio-player-widget/
├── audio-player-widget.php          # Plugin bootstrap
├── includes/
│   └── class-audio-player-widget.php  # Elementor widget class
├── assets/
│   └── js/
│       └── init.js                  # Plyr initialisation
└── lib/
    └── plugin-update-checker/       # Vendored — do not upgrade without testing
```

---

## Notes

- Plyr is loaded via CDN only on pages where the widget is present
- Multiple players on one page are supported
- Updates are delivered via GitHub releases — no WordPress.org account required
