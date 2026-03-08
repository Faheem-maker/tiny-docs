import { defineConfig } from 'vitepress'
import sidebar from './sidebar.mts'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  base: "/projects/tiny-php",
  title: "Tiny PHP",
  description: "A Simple Framework to Build Simple Applications Fast",
  head: [['link', { rel: 'icon', href: '/assets/logo-short.png' }]],
  themeConfig: {
    logo: "/assets/logo-short.png",
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Docs', link: '/docs/getting-started/installation' },
      { text: 'About', link: '/about' },
      { text: 'Gallery', link: '/gallery' },
    ],

    sidebar: sidebar,

    socialLinks: [
      { icon: 'github', link: 'https://github.com/Faheem-maker/tiny-php' }
    ]
  }
})
