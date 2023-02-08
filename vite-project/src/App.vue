<script></script>

<template>
   <div>
     <Loading></Loading>
     <router-view></router-view>
   </div>
</template>

<script>
    import Loading from './alert/Loading.vue';
    export default {
        components: {
            Loading,
        },
    };
</script>
