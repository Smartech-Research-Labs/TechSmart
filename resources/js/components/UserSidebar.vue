<script setup lang="ts">
import {
  IconArrowLeft,
  IconDashboard,
  IconHeart,
  IconHelp,
  IconInnerShadowTop,
  IconMail,
  IconSearch,
  IconSettings,
  IconStar,
  IconUserCircle,
} from "@tabler/icons-vue"

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
  name: authStore.user?.name || "User",
  email: authStore.user?.email || "",
  avatar: "",
}))

const navMain = [
  {
    title: "Overview",
    url: "/dashboard",
    icon: IconDashboard,
  },
  {
    title: "My Profile",
    url: "/dashboard/profile",
    icon: IconUserCircle,
  },
  {
    title: "My Wishlist",
    url: "/dashboard/wishlist",
    icon: IconHeart,
  },
  {
    title: "My Enquiries",
    url: "/dashboard/enquiries",
    icon: IconMail,
  },
  {
    title: "My Reviews",
    url: "/dashboard/reviews",
    icon: IconStar,
  },
]

const navSecondary = computed(() => {
  const items = [
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
  if (authStore.isAdmin || authStore.isSuperAdmin) {
    items.unshift({
      title: "Admin Panel",
      url: "/admin",
      icon: IconSettings,
    })
  }
  return items
})
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
              <span class="text-base font-semibold">TechSmart</span>
            </router-link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>
    <SidebarContent>
      <SidebarMenu class="px-2 pt-1">
        <SidebarMenuItem>
          <SidebarMenuButton as-child>
            <router-link to="/" class="flex items-center gap-2 text-muted-foreground hover:text-foreground transition text-sm">
              <IconArrowLeft class="!size-4" />
              <span>Back to Site</span>
            </router-link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
      <NavMain :items="navMain" />
      <NavSecondary :items="navSecondary" class="mt-auto" />
    </SidebarContent>
    <SidebarFooter>
      <NavUser :user="userData" />
    </SidebarFooter>
  </Sidebar>
</template>
