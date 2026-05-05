<template>
  <GlobalMegaMenu />
  <SidebarProvider>
    <AdminSidebar />
    <SidebarInset>
      <SiteHeader :title="title" />
      <div class="flex flex-1 flex-col gap-4 p-4 @container/main lg:p-6">
        <slot />
      </div>
      <DashboardFooter />
    </SidebarInset>
  </SidebarProvider>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import AdminSidebar from '@/components/AdminSidebar.vue';
import DashboardFooter from '@/components/DashboardFooter.vue';
import GlobalMegaMenu from '@/components/GlobalMegaMenu.vue';
import SiteHeader from '@/components/SiteHeader.vue';
import { SidebarInset, SidebarProvider } from '@/components/ui/sidebar';

const route = useRoute();

const title = computed(() => {
  const meta = route.meta as { title?: string };
  return meta.title || 'Admin Dashboard';
});
</script>

<style scoped>
:deep([data-slot="sidebar-wrapper"]) {
  --header-height: 3.5rem;
}
</style>
