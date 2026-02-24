<script setup lang="ts">
import {
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

const userData = computed(() => ({
  name: authStore.user?.name || "Admin",
  email: authStore.user?.email || "admin@techsmart.co.za",
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
  if (!authStore.isSuperAdmin) return []
  return [
    {
      name: "Users",
      url: "/admin/users",
      icon: IconUsers,
    },
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
  ]
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
  {
    title: "Search",
    url: "#",
    icon: IconSearch,
  },
]
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
              <span class="text-base font-semibold">TechSmart Admin</span>
            </router-link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>
    <SidebarContent>
      <NavMain :items="navMain" />
      <NavDocuments :items="navDocuments" />
      <NavDocuments v-if="superAdminDocs.length > 0" :items="superAdminDocs" />
      <NavSecondary :items="navSecondary" class="mt-auto" />
    </SidebarContent>
    <SidebarFooter>
      <NavUser :user="userData" />
    </SidebarFooter>
  </Sidebar>
</template>
