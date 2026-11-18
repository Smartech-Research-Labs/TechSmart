<template>
  <section>
    <div class="container mx-auto px-6">
      <div class="page-split-heading">
        <div>
          <p class="page-eyebrow">How we work</p>
          <h2>A clear path from idea to launch</h2>
        </div>
        <p>You always know what is being built, what comes next and who is responsible for it.</p>
      </div>
      <div class="grid gap-4 md:grid-cols-3">
        <article v-for="(step, index) in steps" :key="step.title" class="page-step">
          <span>0{{ index + 1 }}</span>
          <h3>{{ step.title }}</h3>
          <p>{{ step.text }}</p>
        </article>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const steps = [
  { title: 'Understand', text: 'We map your goals, users and existing systems, then agree on the scope.' },
  { title: 'Design and build', text: 'We work in reviewable stages so you can give feedback before launch.' },
  { title: 'Launch and support', text: 'We test, go live and stay available for improvements and maintenance.' },
];
</script>
