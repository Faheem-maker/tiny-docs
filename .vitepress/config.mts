import { defineConfig } from 'vitepress'
import sidebar from './sidebar.mts'
import apiSidebar from './api-sidebar.mts'

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
      { text: 'Tutorial', link: '/docs/getting-started/installation' },
      { text: 'API Reference', link: '/docs/api-reference/' },
      { text: 'About', link: '/about' },
      { text: 'Gallery', link: '/gallery' },
      { text: 'Blog', link: '/blog/' },
    ],

    sidebar: {
      '/docs/api-reference/': apiSidebar,
      '/docs/': sidebar
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/Faheem-maker/tiny-php' }
    ]
  },
  srcExclude: ['temp']
})
