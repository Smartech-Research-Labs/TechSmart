<template>
  <PublicLayout>
    <section class="relative py-16 md:py-20 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="heroLaptopDark" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/60"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-2xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Legal</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">{{ page.title }}</h1>
          <p class="text-white/80 text-sm leading-relaxed">{{ page.intro }}</p>
          <p class="text-white/60 text-xs mt-4">Last updated: {{ lastUpdated }}</p>
        </div>
      </div>
      <PageHeroAside :image="pageImg.techCloseup" :title="'Questions about your data?'" :label="'Contact Us'" />
    </section>

    <PageBento v-bind="bentoBlock" />

    <section class="py-14 md:py-20 bg-background">
      <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto space-y-10">
          <div v-for="section in page.sections" :key="section.heading">
            <h2 class="text-xl font-bold text-foreground mb-3">{{ section.heading }}</h2>
            <p v-for="text in section.paragraphs" :key="text" class="text-muted-foreground text-sm leading-relaxed mb-3">{{ text }}</p>
            <ul v-if="section.items" class="list-disc pl-5 space-y-2 text-muted-foreground text-sm leading-relaxed">
              <li v-for="item in section.items" :key="item">{{ item }}</li>
            </ul>
          </div>

          <div class="rounded-2xl border border-border bg-card p-6">
            <h2 class="text-xl font-bold text-foreground mb-3">Contact us</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">
              OmniviaTech, Nairobi, Kenya<br />
              Email: <a href="mailto:reachout@omniviatech.co.ke" class="text-primary hover:underline">reachout@omniviatech.co.ke</a><br />
              Phone: <a href="tel:+254710351517" class="text-primary hover:underline">+254 710 351517</a>
            </p>
          </div>
        </div>
      </div>
    </section>
    <PageSplit v-bind="splitBlock" />

    <PageCta eyebrow="Questions" title="Need to discuss these terms or your data?" text="Contact our team and we will point you in the right direction." />
  </PublicLayout>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import heroLaptopDark from '@/../img/tech-background.webp';
import PageBento from '@/components/PageBento.vue';
import PageCta from '@/components/PageCta.vue';
import PageHeroAside from '@/components/PageHeroAside.vue';
import PageSplit from '@/components/PageSplit.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { pageImg } from '@/lib/pageImages';

type LegalSection = { heading: string; paragraphs: string[]; items?: string[] };
type LegalPage = { title: string; intro: string; sections: LegalSection[] };

const lastUpdated = '18 November 2026';

const pages: Record<'privacy' | 'terms', LegalPage> = {
  privacy: {
    title: 'Privacy Policy',
    intro: 'How OmniviaTech collects, uses and protects personal data, in line with the Kenya Data Protection Act, 2019.',
    sections: [
      {
        heading: 'Who we are',
        paragraphs: ['OmniviaTech is a technology company based in Nairobi, Kenya. This policy applies to omniviatech.co.ke and to enquiries you send us through it.'],
      },
      {
        heading: 'Information we collect',
        paragraphs: ['We collect information you give us and limited technical information when you use the website:'],
        items: [
          'Contact and quote details, such as your name, email address, phone number, company and message.',
          'Account details, such as your name, email address, password and profile information. If you sign in with Google, we receive basic details from your Google account.',
          'Activity in your account, such as wishlist items, reviews, enquiries and messages.',
          'Newsletter sign-up details.',
          'Messages you send through our website chat.',
          'Device and usage information, such as browser type, pages visited, approximate location and how you interact with the website.',
        ],
      },
      {
        heading: 'How we use your information',
        paragraphs: ['We use personal data to:'],
        items: [
          'Respond to enquiries, prepare quotes and provide our services.',
          'Create and manage your account.',
          'Send service messages and, where you have asked for them, newsletters.',
          'Measure and improve the website and our marketing.',
          'Protect the website and meet our legal obligations.',
        ],
      },
      {
        heading: 'Cookies and analytics',
        paragraphs: ['We use cookies and similar technologies to keep the website working and to understand how it is used. These include Google Analytics, Microsoft Clarity and the TikTok Pixel. Clarity may record how visitors move through pages, and the TikTok Pixel helps us measure advertising. You can block or delete cookies in your browser settings, although some features may stop working.'],
      },
      {
        heading: 'Who we share information with',
        paragraphs: ['We do not sell your personal data. We share it only where needed with service providers that help us run the business, such as hosting, email, analytics, advertising, sign-in and AI chat providers, or where the law requires it. Some providers may process data outside Kenya, and we take steps to ensure that it remains appropriately protected.'],
      },
      {
        heading: 'How long we keep information',
        paragraphs: ['We keep personal data only for as long as needed for the purposes above, including meeting legal, accounting and contract requirements. We then delete or anonymise it.'],
      },
      {
        heading: 'Your rights',
        paragraphs: ['Under the Data Protection Act, 2019 you may have the right to:'],
        items: [
          'Be informed about how your data is used.',
          'Access the personal data we hold about you.',
          'Ask us to correct or delete it.',
          'Object to certain processing, including direct marketing.',
          'Withdraw consent where we rely on your consent.',
          'Complain to the Office of the Data Protection Commissioner.',
        ],
      },
      {
        heading: 'Security',
        paragraphs: ['We use reasonable technical and organisational measures to protect personal data. No website or online service can be guaranteed to be completely secure.'],
      },
      {
        heading: 'Children',
        paragraphs: ['Our website is intended for businesses and adults. We do not knowingly collect personal data from children. Contact us if you believe a child has given us their information.'],
      },
      {
        heading: 'Changes to this policy',
        paragraphs: ['We may update this policy from time to time. The latest version will always be published on this page.'],
      },
    ],
  },
  terms: {
    title: 'Terms of Service',
    intro: 'The terms that apply when you use the OmniviaTech website and enquire about our services.',
    sections: [
      {
        heading: 'Using this website',
        paragraphs: ['By using omniviatech.co.ke you agree to these terms. If you do not agree, please do not use the website. You agree not to:'],
        items: [
          'Use the website unlawfully or to harm others.',
          'Try to gain unauthorised access to the website, its systems or other accounts.',
          'Upload harmful code or submit false information.',
          'Interfere with how the website works.',
        ],
      },
      {
        heading: 'Accounts',
        paragraphs: ['You are responsible for keeping your login details secure and for activity under your account. Please give accurate information and tell us if you suspect unauthorised use. We may suspend accounts that breach these terms.'],
      },
      {
        heading: 'Services, packages and quotes',
        paragraphs: ['Information on this website is a general description of what we offer. Prices, features and availability may change. An enquiry or quote request does not create a contract. Project scope, price, timing, payment and support are confirmed in a written quote or agreement, which applies if it differs from this website.'],
      },
      {
        heading: 'Intellectual property',
        paragraphs: ['Website content, branding, designs and software belong to OmniviaTech or its licensors unless stated otherwise. You may view the website for normal business or personal use, but you may not copy or reuse its content commercially without written permission. Ownership of project work is set out in the relevant agreement.'],
      },
      {
        heading: 'Reviews and content you submit',
        paragraphs: ['You are responsible for reviews, messages and other content you submit. It must be honest and lawful. You allow us to use and display reviews you submit for the website and our marketing, and we may remove content that breaches these terms.'],
      },
      {
        heading: 'Third-party services',
        paragraphs: ['The website may link to or rely on third-party services such as WhatsApp, Google and social networks. Their own terms and privacy policies apply, and we are not responsible for them.'],
      },
      {
        heading: 'Website information and availability',
        paragraphs: ['We work to keep the website accurate and available, but we do not guarantee that it will always be complete, current or uninterrupted. Articles are general information and are not legal, tax or financial advice.'],
      },
      {
        heading: 'Liability',
        paragraphs: ['To the extent allowed by law, OmniviaTech is not liable for indirect or consequential losses arising from your use of this website. Nothing in these terms limits any rights or liability that cannot legally be limited.'],
      },
      {
        heading: 'Governing law',
        paragraphs: ['These terms are governed by the laws of Kenya, and disputes are subject to the jurisdiction of the Kenyan courts.'],
      },
      {
        heading: 'Changes to these terms',
        paragraphs: ['We may update these terms from time to time. The latest version will always be published on this page.'],
      },
    ],
  },
};

const route = useRoute();
const page = computed(() => pages[route.meta.legalPage as 'privacy' | 'terms']);

// Inner-page design blocks (bento row, split panel, image cards)
const bentoBlock = {
  "eyebrow": "Our Commitment",
  "title": "Built on Trust and Transparency",
  "image": pageImg.techBackground,
  "imageTitle": "Your Data Stays Protected",
  "statLabel": "Encrypted connections",
  "statValue": "100",
  "statUnit": "%",
  "cards": [
    {
      "icon": "🔐",
      "title": "Data Protection",
      "text": "We collect only what we need, keep it secure and handle it in line with Kenya's Data Protection Act and good international practice."
    },
    {
      "icon": "📋",
      "title": "Plain-Language Terms",
      "text": "Our policies explain clearly what we do, what you can expect from us and how to reach us if anything is unclear."
    }
  ]
};
const splitBlock = {
  "eyebrow": "Your Rights",
  "title": "You Stay in Control of Your Information",
  "text": "You can ask what data we hold about you, request corrections or ask us to delete it. Reach out at any time and we will respond promptly.",
  "points": [
    "Access, correct or delete your personal data",
    "Unsubscribe from communications at any time"
  ],
  "image": pageImg.tech5,
  "statLabel": "Secure by design",
  "statValue": "24/7",
  "statUnit": "",
  "note": "Monitored, regularly audited systems",
  "statIcon": "🛡",
  "noteIcon": "🔒",
  "ctaLabel": "Ask a Question"
};

</script>
