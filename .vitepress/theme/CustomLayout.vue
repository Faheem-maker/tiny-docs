<script setup>
import DefaultTheme from 'vitepress/theme'
import { useData } from 'vitepress'
import { computed } from 'vue'

const { Layout } = DefaultTheme
const { page, frontmatter } = useData()

const isBlog = computed(() => {
  return page.value.relativePath.startsWith('blog/')
})

const isBlogPost = computed(() => {
  return isBlog.value && page.value.relativePath !== 'blog/index.md'
})
</script>

<template>
  <Layout :class="{ 'blog-page': isBlog, 'blog-post': isBlogPost }">
    <template #home-hero-image>
        <DemoCodePreview />
    </template>
    
    <template #doc-before>
      <div v-if="isBlogPost" class="blog-header">
        <h1 class="blog-title">{{ frontmatter.title }}</h1>
        <div class="blog-meta" v-if="frontmatter.date">
          Published on {{ new Date(frontmatter.date).toLocaleDateString() }}
        </div>
      </div>
    </template>
  </Layout>
</template>

<style>
.blog-page .VPDoc {
    padding-top: 64px;
    padding-bottom: 64px;
}

.blog-page .VPDoc .container {
    max-width: 720px !important;
    margin: 0 auto;
}

.blog-header {
    margin-bottom: 64px;
    text-align: center;
}

.blog-title {
    font-size: 3.5rem;
    line-height: 1.2;
    font-weight: 800;
    margin-bottom: 16px;
    letter-spacing: -0.02em;
    background: linear-gradient(135deg, var(--vp-c-brand-1) 0%, var(--vp-c-brand-2) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.blog-meta {
    color: var(--vp-c-text-2);
    font-size: 1rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.blog-page .vp-doc {
    font-size: 1.15rem;
    line-height: 1.7;
}

.blog-post .vp-doc h1 {
    display: none;
}

.blog-page .vp-doc h2 {
    margin-top: 48px;
    border-top: none;
    font-size: 1.8rem;
}

.blog-page .vp-doc p {
    margin-bottom: 24px;
}

@media (max-width: 768px) {
    .blog-title {
        font-size: 2.5rem;
    }
}
</style>