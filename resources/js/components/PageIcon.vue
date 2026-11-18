<template>
  <component :is="iconComponent" class="page-icon" :stroke-width="1.75" aria-hidden="true" />
</template>

<script setup lang="ts">
import {
  Award, BadgeCheck, BarChart3, Bot, Briefcase, Building2, Cloud, Code2, Cog, Factory, FileText, Gauge, Globe,
  GraduationCap, HandCoins, Handshake, Headphones, HeartPulse, Hotel, Landmark, LayoutList, Lightbulb, Lock, Mail,
  MessageCircle, Package, Phone, Radio, RefreshCw, Rocket, Shield, ShoppingCart, Smartphone, Sprout, Target,
  TrendingUp, Truck, Users, Wrench, Zap,
} from 'lucide-vue-next';
import { computed, type Component } from 'vue';

const props = defineProps<{ icon?: string | null }>();

const icons: Record<string, Component> = {
  '⚡': Zap, '🔒': Lock, '🤝': Handshake, '🎯': Target, '💡': Lightbulb, '📦': Package, '💼': Briefcase,
  '📝': FileText, '📞': Phone, '📱': Smartphone, '🌍': Globe, '🌐': Globe, '🚀': Rocket, '💰': HandCoins,
  '📊': BarChart3, '🔄': RefreshCw, '🎓': GraduationCap, '📈': TrendingUp, '🏢': Building2, '☁': Cloud,
  '🤖': Bot, '🏥': HeartPulse, '🛒': ShoppingCart, '🏭': Factory, '📡': Radio, '🚚': Truck, '🛡': Shield,
  '🏦': Landmark, '🏗': Building2, '🏨': Hotel, '💻': Code2, '📧': Mail, '💬': MessageCircle, '🛠': Wrench,
  '🏆': Award, '👥': Users, '🔐': Lock, '🔧': Wrench, '📋': LayoutList, '🌾': Sprout, '🏛': Landmark,
  '⚙': Cog, '🎧': Headphones, '🚦': Gauge,
};

const iconComponent = computed(() => icons[(props.icon || '').replace(/️/g, '').trim()] || BadgeCheck);
</script>
