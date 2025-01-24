import { defineConfig } from 'vitepress'

export default defineConfig({
    title: "Hetzner Cloud PHP", description: "Documentation for the Hetzner Cloud PHP client.", themeConfig: {
        nav: [{
            text: 'Home', link: '/'
        }, {
            text: 'Examples', link: '/markdown-examples'
        }], sidebar: [{
            text: 'Examples', items: [{
                text: 'Markdown Examples', link: '/markdown-examples'
            }, {
                text: 'Runtime API Examples', link: '/api-examples'
            }]
        }],

        socialLinks: [{
            icon: 'github', link: 'https://github.com/vuejs/vitepress'
        }]
    }
})
