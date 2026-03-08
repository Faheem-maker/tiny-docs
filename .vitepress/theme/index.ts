import DefaultTheme from 'vitepress/theme'
import DemoCodePreview from './components/DemoCodePreview.vue';
import CustomLayout from './CustomLayout.vue'

export default {
    ...DefaultTheme,
    Layout: CustomLayout,
    enhanceApp({ app }) {
        app.component("DemoCodePreview", DemoCodePreview)
    }
}