<template>
    <div ref="loading">{{ content }}</div>
</template>

<script>
    export default {
        props: {
            content: {
                type: String,
            },
        },
    };
</script>
