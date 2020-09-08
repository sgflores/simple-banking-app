<template>
    <b-card :header="'Welcome, ' + account.name">
        <b-card-text>
            <div>
                Account: <code>{{ account.id }}</code>
            </div>
            <div>
                Balance:
                <code
                >{{ account.currency_info.code}} {{ account.balance }}</code
                >
            </div>
        </b-card-text>
        
        <b-button size="sm" variant="success" @click="showPayment">New Payment</b-button>
    </b-card>
</template>

<script>
export default {
    props: {
        account: {
            required: true,
            type: Object
        }
    },
    methods: {
        showPayment() {
            this.$emit('showPaymentHandler');
        }
    }
}
</script>