<template>
  <div>
    <div class="container mt-2" v-if="loading">
      <br>
       <b-card>
        Loading...
      </b-card>
    </div>

    <div class="container mt-2" v-else>
      <br>
       <b-card no-body>
        <b-tabs pills card vertical>
          <b-tab title="Account Info" active>
            
            <account-info :account="account" v-on:showPaymentHandler="showForm = true" v-if="!showForm"></account-info>
            
            <payment-form :account="account" ref="paymentForm" v-if="showForm"
              v-on:cancelFormHandler="cancel"
              v-on:onSubmitHandler="onSubmit"></payment-form>

          </b-tab>

          <b-tab title="Transactions">
            <account-transactions :transactions="transactions"></account-transactions>
          </b-tab>

          <b-tab title="Logout" @click="logout">
            <b-card-text>Logging out...</b-card-text>
          </b-tab>

        </b-tabs>
      </b-card>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      'account': 'account',
      'transactions': 'transactions',
    }),
  },
  data() {
    return {
      showForm: false,
      loading: true
    };
  },

  async mounted() {
    await this.$store.dispatch('loadCurrencies', {$axios: this.$axios}); 
    await this.loadAccountInfo();
    this.loading = false;
  },

  methods: {
    cancel() {
      this.showForm = false;
    },
    async logout() {
     await this.$auth.logout();
    },
    async loadAccountInfo() {
      await this.$store.dispatch('loadAccount', {$axios: this.$axios, $route: this.$route}); 
      await this.$store.dispatch('loadTransactions', {$axios: this.$axios, $route: this.$route});
      (this.transactions || []).map(data => {
        delete data['from_amount'];
        delete data['to_amount'];
      });
    },
    async onSubmit(payment) {
      const that = this;
      this.$axios.post(`/api/accounts/${this.account.id}/transactions`, payment)
      .then(response => {
        that.loadAccountInfo();
        that.showForm = false;
        that.$refs.paymentForm.resetForm();
      })
      .catch(error => {
        alert(JSON.stringify(error.response.data.errors || error.response.data));
      });
    },
  }
};
</script>
