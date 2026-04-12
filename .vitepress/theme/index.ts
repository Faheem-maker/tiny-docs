import DefaultTheme from 'vitepress/theme'
import DemoCodePreview from './components/DemoCodePreview.vue';
import BlogIndex from './components/BlogIndex.vue';
import CustomLayout from './CustomLayout.vue'

export default {
    ...DefaultTheme,
    Layout: CustomLayout,
    enhanceApp({ app }) {
        app.component("DemoCodePreview", DemoCodePreview)
        app.component("BlogIndex", BlogIndex)
    }
}