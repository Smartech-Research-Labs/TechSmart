<script setup lang="ts">
import { ref } from 'vue'
import {
  IconArrowLeft,
  IconChartBar,
  IconDashboard,
  IconFileDescription,
  IconHelp,
  IconInnerShadowTop,
  IconListDetails,
  IconMail,
  IconMessage,
  IconPackage,
  IconReport,
  IconSearch,
  IconServer,
  IconSettings,
  IconShield,
  IconStar,
  IconUsers,
  IconWriting,
} from "@tabler/icons-vue"

import NavDocuments from "@/components/NavDocuments.vue"
import NavMain from "@/components/NavMain.vue"
import NavSecondary from "@/components/NavSecondary.vue"
import NavUser from "@/components/NavUser.vue"
import GlobalSearch from "@/components/GlobalSearch.vue"
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from "@/components/ui/sidebar"
import { useAuthStore } from "@/stores/auth"
import { computed } from "vue"

const authStore = useAuthStore()

// Global search state
const showSearch = ref(false)

const userData = computed(() => ({
  name: authStore.user?.name || "Admin",
  email: authStore.user?.email || "admin@omniviatech.com",
  avatar: "",
}))

const navMain = [
  {
    title: "Dashboard",
    url: "/admin",
    icon: IconDashboard,
  },
  {
    title: "CMS",
    url: "/admin/cms",
    icon: IconListDetails,
  },
  {
    title: "Pages",
    url: "/admin/pages",
    icon: IconFileDescription,
  },
  {
    title: "Blogs",
    url: "/admin/blogs",
    icon: IconWriting,
  },
  {
    title: "Case Studies",
    url: "/admin/case-studies",
    icon: IconReport,
  },
  {
    title: "Industries",
    url: "/admin/industries",
    icon: IconInnerShadowTop,
  },
  {
    title: "Services",
    url: "/admin/services",
    icon: IconServer,
  },
  {
    title: "Products",
    url: "/admin/products",
    icon: IconPackage,
  },
  {
    title: "Bundles",
    url: "/admin/bundles",
    icon: IconChartBar,
  },
]

const navDocuments = [
  {
    name: "Reviews",
    url: "/admin/reviews",
    icon: IconStar,
  },
  {
    name: "Enquiries",
    url: "/admin/enquiries",
    icon: IconMail,
  },
  {
    name: "Chat",
    url: "/admin/chat",
    icon: IconMessage,
  },
]

const superAdminDocs = computed(() => {
  const items: { name: string; url: string; icon: any }[] = []
  
  // Admin and SuperAdmin can manage users
  if (authStore.isAdmin || authStore.isSuperAdmin) {
    items.push({
      name: "Users",
      url: "/admin/users",
      icon: IconUsers,
    })
  }
  
  // Only SuperAdmin gets roles and audit logs
  if (authStore.isSuperAdmin) {
    items.push(
      {
        name: "Roles & Permissions",
        url: "/admin/roles",
        icon: IconShield,
      },
      {
        name: "Audit Logs",
        url: "/admin/audit-logs",
        icon: IconReport,
      },
    )
  }
  
  return items
})

const navSecondary = [
  {
    title: "Settings",
    url: "/admin/settings",
    icon: IconSettings,
  },
  {
    title: "Help",
    url: "/contact",
    icon: IconHelp,
  },
]

// Search click handler
function openSearch() {
  showSearch.value = true
}
</script>

<template>
  <Sidebar collapsible="offcanvas">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton
            as-child
            class="data-[slot=sidebar-menu-button]:!p-1.5"
          >
            <router-link to="/">
              <IconInnerShadowTop class="!size-5" />
              <span class="text-base font-semibold">OmniviaTech Admin</span>
            </router-link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>
    <SidebarContent>
      <SidebarMenu class="px-2 pt-1">
        <SidebarMenuItem>
          <SidebarMenuButton as-child>
            <router-link to="/dashboard" class="flex items-center gap-2 text-muted-foreground hover:text-foreground transition text-sm">
              <IconArrowLeft class="!size-4" />
              <span>Back to Dashboard</span>
            </router-link>
          </SidebarMenuButton>
        </SidebarMenuItem>
        <!-- Search Button -->
        <SidebarMenuItem>
          <SidebarMenuButton @click="openSearch" class="flex items-center gap-2 text-muted-foreground hover:text-foreground transition text-sm cursor-pointer">
            <IconSearch class="!size-4" />
            <span>Search</span>
            <kbd class="ml-auto text-[10px] px-1.5 py-0.5 bg-muted text-muted-foreground rounded border border-border">Ctrl+K</kbd>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
      <NavMain :items="navMain" />
      <NavDocuments :items="navDocuments" />
      <NavDocuments v-if="superAdminDocs.length > 0" :items="superAdminDocs" />
      <NavSecondary :items="navSecondary" class="mt-auto" />
    </SidebarContent>
    <SidebarFooter>
      <NavUser :user="userData" />
    </SidebarFooter>
  </Sidebar>
  
  <!-- Global Search Modal -->
  <GlobalSearch v-model="showSearch" />
</template>
