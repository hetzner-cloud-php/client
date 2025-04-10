import { defineConfig } from 'vitepress';

export default defineConfig({
    title: '☁ Hetzner Cloud PHP',
    description: 'Documentation for the Hetzner Cloud PHP client.',
    themeConfig: {
        nav: [
            {
                text: 'Home',
                link: '/',
            },
            {
                text: 'Getting Started',
                link: '/installation',
            },
        ],
        sidebar: [
            {
                text: 'Getting Started',
                items: [
                    {
                        text: 'Installation',
                        link: '/installation',
                    },
                ],
            },
            {
                text: 'Resources',
                items: [
                    {
                        text: 'Actions',
                        link: '/resources/actions',
                    },
                    {
                        text: 'Certificates',
                        link: '/resources/certificates',
                    },
                    {
                        text: 'Certificate Actions',
                        link: '/resources/certificate-actions',
                    },
                    {
                        text: 'Servers',
                        link: '/resources/servers',
                    },
                ],
            },
        ],
        socialLinks: [
            {
                icon: 'github',
                link: 'https://github.com/hetzner-cloud-php/client',
            },
        ],
    },
});
