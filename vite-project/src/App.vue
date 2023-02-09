<script></script>

<template>
    <div>
        <Loading v-if="loading"></Loading>
        <router-view :class="[loading ? 'opacity-25' : '']"></router-view>
    </div>
</template>

<script>
    import Loading from './alert/Loading.vue';
    import { mapState } from 'vuex';
    export default {
        components: {
            Loading,
        },
        computed: {
            ...mapState(['loading']),
        },
    };
</script>
