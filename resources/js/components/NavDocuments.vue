<script setup lang="ts">
import type { Component } from "vue"
import {
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from "@/components/ui/sidebar"

defineProps<{
  items: {
    name: string
    url: string
    icon: Component
  }[]
}>()
</script>

<template>
  <SidebarGroup>
    <SidebarGroupLabel>Documents</SidebarGroupLabel>
    <SidebarGroupContent>
      <SidebarMenu>
        <SidebarMenuItem v-for="item in items" :key="item.name">
          <SidebarMenuButton as-child>
            <router-link :to="item.url">
              <component :is="item.icon" />
              <span>{{ item.name }}</span>
            </router-link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarGroupContent>
  </SidebarGroup>
</template>
