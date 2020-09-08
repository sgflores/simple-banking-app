<template>
    <b-card class="mt-3" header="Payment History">
        <b-table striped hover :items="transactions"></b-table>
    </b-card>
</template>

<script>
export default {
    props: {
        transactions: {
            default() {
                return [];
            }
        }
    }
}
</script>