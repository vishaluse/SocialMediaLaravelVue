<template>
    <posts></posts>
</template>


<script>

import Posts from "./Posts";

export default {
    emits: ['reload'],
    mounted() {
        this.$emit('reload')
    },
    components : {
        Posts
    }
}
</script>
