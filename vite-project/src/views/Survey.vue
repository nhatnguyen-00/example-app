<script setup lang="ts">
    import { onMounted, ref } from 'vue';
    import { hide, show } from 'uspin';

    const targetRef = ref(null);
</script>

<template>
    <div>
        <div ref="targetRef" class="demo">hello</div>
        <div class="demoButton">
            <button @click="show(targetRef)">show</button>
            <button @click="hide(targetRef)">hide</button>
        </div>
    </div>
</template>
