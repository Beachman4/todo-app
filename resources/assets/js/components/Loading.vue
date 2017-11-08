<template>
    <div class="loading-wrapper" style="text-align: center">
        <h3>{{ text }}</h3>
        <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
    </div>
</template>

<script>
    export default {
        props: ['text']
    }
</script>