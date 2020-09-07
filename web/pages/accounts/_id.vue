<template>
  <div>
    <div class="container mt-50" v-if="loading">
      <br>
       <b-card>
        Loading...
      </b-card>
    </div>

    <div class="container mt-2" v-if="!loading">
       <b-card no-body>
        <b-tabs pills card vertical>
          <b-tab title="Account Info" active>
            <b-card :header="'Welcome, ' + account.name" v-if="!showForm">
              <b-card-text>
                <div>
                  Account: <code>{{ account.id }}</code>
                </div>
                <div>
                  Balance:
                  <code
                    >{{ account.currency_info.code}}{{ account.balance }}</code
                  >
                </div>
              </b-card-text>
              <b-button size="sm" variant="success" @click="showForm = !showForm"
                >New payment</b-button
              >
            </b-card>
            
              <b-card  header="New Payment" v-if="showForm">
              <b-form @submit="onSubmit">
                <b-form-group id="input-group-1" label="To:" label-for="input-1">
                  <b-form-input
                    id="input-1"
                    size="sm"
                    v-model="payment.to"
                    type="number"
                    required
                    placeholder="Destination ID"
                  ></b-form-input>
                </b-form-group>

                <b-form-group id="input-group-2" label="Amount:" label-for="input-2">
                  <b-input-group prepend="$" size="sm">
                    <b-form-input
                      id="input-2"
                      v-model="payment.amount"
                      type="number"
                      required
                      placeholder="Amount"
                    ></b-form-input>
                  </b-input-group>
                </b-form-group>

                <b-form-group id="input-group-3" label="Details:" label-for="input-3">
                  <b-form-input
                    id="input-3"
                    size="sm"
                    v-model="payment.details"
                    required
                    placeholder="Payment details"
                  ></b-form-input>
                </b-form-group>

                <b-button type="button" size="sm" variant="warning" @click="showForm = false">Cancel</b-button>
                <b-button type="submit" size="sm" variant="primary">Submit</b-button>
              </b-form>
            </b-card>

          </b-tab>

          <b-tab title="Transactions">
            <b-card class="mt-3" header="Payment History">
              <b-table striped hover :items="transactions"></b-table>
            </b-card>
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

export default { 
  layout: 'main',
  data() {
    return {
      showForm: false,
      payment: {
        currency: 'USD',
      },

      account: null,
      transactions: null,
      currencies: null,

      errors: [],

      loading: true
    };
  },

  mounted() {
    console.log(this.$store.getters);
    this.loadAccount();
  },

  methods: {
    async logout() {
        await this.$auth.logout();
        this.$router.push('/');
    },
    async loadAccount() {
      const account = await this.$axios.get(`http://localhost:8000/api/accounts/${this.$route.params.id}`);
      this.account = account.data;
      await this.loadTransactions();
      this.loading = false;
    },
    async loadTransactions()  {
      const {data} = await this.$axios.get(`http://localhost:8000/api/accounts/${this.$route.params.id}/transactions`);
      this.transactions = data.data;
    },
    async onSubmit(evt) {
      var that = this;

      evt.preventDefault();
      this.errors = '';
      const response = await this.$axios.post(`http://localhost:8000/api/accounts/${this.$route.params.id}/transactions`, this.payment)
      .then(response => {
        that.loadTransactions();
        that.showForm = false;
        that.form = {currency: 'USD'}
      })
      .catch(error => {
        that.errors = error.response.data.errors || error.response.data;
        alert(JSON.stringify(that.errors));
      });

    },
  }
};
</script>
