export default [
  {
    text: 'Prologue',
    collapsed: true,
    items: [
      { text: 'Introduction', link: '/docs/prologue/introduction' },
      { text: 'Release Notes', link: '/docs/prologue/release-notes' },
    ]
  },
  {
    text: 'Getting Started',
    collapsed: false,
    items: [
      { text: 'Installation', link: '/docs/getting-started/installation' },
      { text: 'Controllers', link: '/docs/getting-started/controllers' },
      { text: 'Views', link: '/docs/getting-started/views' },
      { text: 'Reactivity', link: '/docs/getting-started/reactivity' },
    ]
  },
  {
    text: "The Basics",
    collapsed: true,
    items: [
      { text: "Routing", link: "/docs/basics/routing" },
      { text: "Security", link: "/docs/basics/security" },
      { text: "Request", link: "/docs/basics/request" }
    ]
  },
  {
    text: 'Forms',
    collapsed: true,
    items: [
      { text: 'Models', link: '/docs/forms/models' },
    ]
  },
  {
    text: 'Database',
    collapsed: true,
    items: [
      { text: 'Query Builder', link: '/docs/database/query-builder' },
      { text: 'ORM', link: '/docs/database/orm' },
    ]
  }
];