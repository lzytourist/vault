<template>
    <div class="text-center waring">
        <v-icon size="100" color="green">fa fa-check</v-icon>
        <p class="grey--text">No records yet!</p>
    </div>
</template>

<script>
export default {
    name: "NoContent",
}
</script>

<style scoped>
.text-center.waring {
    opacity: .5;
    position: absolute;
    left: calc(50% - 55px);
    top: calc(50% - 70px);
}
</style>
