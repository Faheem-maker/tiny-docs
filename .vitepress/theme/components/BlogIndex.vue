<script setup>
import { data as posts } from '../../posts.data.mts'
</script>

<template>
  <div class="blog-index">
    <div v-for="post in posts" :key="post.url" class="blog-card">
      <a :href="post.url" class="blog-card-link">
        <div class="blog-card-content">
          <div class="blog-card-date">{{ post.date.string }}</div>
          <h2 class="blog-card-title">{{ post.title }}</h2>
          <p v-if="post.excerpt" class="blog-card-excerpt" v-html="post.excerpt"></p>
          <div class="blog-card-footer">
            <span class="read-more">Read Article →</span>
          </div>
        </div>
      </a>
    </div>
  </div>
</template>

<style scoped>
.blog-index {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  margin-top: 2rem;
}

.blog-card {
  background: var(--vp-c-bg-soft);
  border-radius: 16px;
  overflow: hidden;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid var(--vp-c-divider);
}

.blog-card:hover {
  transform: translateY(-4px);
  border-color: var(--vp-c-brand-1);
  box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.1);
}

.blog-card-link {
  text-decoration: none !important;
  color: inherit !important;
}

.blog-card-content {
  padding: 2rem;
}

.blog-card-date {
  font-size: 0.85rem;
  color: var(--vp-c-text-2);
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 0.75rem;
}

.blog-card-title {
  font-size: 1.75rem;
  font-weight: 700;
  margin: 0 0 1rem 0;
  line-height: 1.3;
  color: var(--vp-c-text-1);
}

.blog-card-excerpt {
  color: var(--vp-c-text-2);
  font-size: 1.05rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.blog-card-footer {
  display: flex;
  align-items: center;
}

.read-more {
  color: var(--vp-c-brand-1);
  font-weight: 600;
  font-size: 0.95rem;
  transition: color 0.2s;
}

.blog-card:hover .read-more {
  color: var(--vp-c-brand-2);
}

@media (max-width: 640px) {
  .blog-card-content {
    padding: 1.5rem;
  }
  .blog-card-title {
    font-size: 1.5rem;
  }
}
</style>
