<template>
    <v-app>
        <v-container>
            <h1 class="blue-grey--text">Expenditures</h1>
            <NoContent v-if="!expenditures.length"/>
        </v-container>
    </v-app>
</template>

<script>
import NoContent from "../NoContent";
export default {
    name: "Expenditure",
    components: {NoContent},
    data() {
        return {
            expenditure: {},
            expenditures: [],
        }
    }
}
</script>

<style scoped>

</style>
