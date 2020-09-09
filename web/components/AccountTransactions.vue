<template>
    <b-card class="mt-3 table-responsive" header="Payment History">
        <b-table class="table-sm" striped hover :items="transactions"></b-table>
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