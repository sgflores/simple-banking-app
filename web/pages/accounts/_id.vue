<template>
  <div>
    <div class="container mt-2" v-if="loading">
      <br>
       <b-card>
        Loading...
      </b-card>
    </div>

    <div class="container mt-2" v-if="!loading">
      <br>
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
                    >{{ account.currency_info.code}} {{ account.balance }}</code
                  >
                </div>
              </b-card-text>
              <b-button size="sm" variant="success" @click="showForm = !showForm"
                >New Payment</b-button
              >
            </b-card>
            
              <b-card header="New Payment" v-if="showForm">
             
              <b-form @submit.prevent="onSubmit">

                <b-form-group id="input-group-2" label="You Send:" label-for="input-2">
                  <b-input-group :prepend="account.currency" size="sm">
                    <b-form-input @change="convertAmount"
                      id="input-2"
                      v-model="payment.amount"
                      type="number"
                      required
                      placeholder="Amount"
                    ></b-form-input>
                  </b-input-group>
                </b-form-group>

                <b-form-group id="input-group-1" label="To:" label-for="input-1">
                  <b-form-input
                    id="input-1"
                    size="sm"
                    v-model="payment.to"
                    type="number"
                    step="any"
                    required
                    placeholder="Destination ID"
                  ></b-form-input>
                </b-form-group>
                
                
                  <div class="row">
                  <div class="col-sm-3">
                    <b-form-group id="input-group-2" label="Currency" label-for="input-3">
                      <b-form-select v-model="payment.currency" :options="currencies" @change="convertAmount"
                        value-field="code" text-field="code">
                      </b-form-select>
                    </b-form-group>
                  </div>
                  <div class="col-sm-9">
                     <b-form-group id="input-group-2" label="Converted Amount" label-for="input-3">
                        <b-form-input
                        id="input-2"
                        v-model="payment.convertedAmount"
                        :readonly="true"
                        type="number"
                        required
                        placeholder="Converted Amount"
                      ></b-form-input>
                    </b-form-group>
                    
                  </div>
                </div>
                
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
  data() {
    return {
      showForm: false,
      payment: {
        amount: 1,
        convertedAmount: 1,
        currency: 'USD',
      },

      account: null,
      transactions: null,
      currencies: null,

      loading: true
    };
  },

  mounted() {
    this.loadAccount();
    this.loadCurrencies();
  },

  methods: {
    async logout() {
        await this.$auth.logout();
        this.$router.push('/');
    },
    async convertAmount() {
      if (!this.payment.amount) return;
      const {data} = await this.$axios.get(`/api/currencies/convertAmount`, {
        params: {
          currencyFrom: this.account.currency,
          currencyTo: this.payment.currency,
          amount: this.payment.amount
        }
      });
      this.payment.convertedAmount = data;
    },
    async loadAccount() {
      const account = await this.$axios.get(`/api/accounts/${this.$route.params.id}`);
      this.account = account.data;
      this.payment.currency = this.account.currency;
      await this.loadTransactions();
      this.loading = false;
    },
    async loadTransactions()  {
      const {data} = await this.$axios.get(`/api/accounts/${this.$route.params.id}/transactions`);
      (data.data || []).map(data => {
        delete data['from_amount'];
        delete data['to_amount'];
      });
      this.transactions = data.data;
    },
    async loadCurrencies()  {
      const {data} = await this.$axios.get(`/api/currencies`);
      this.currencies = data.data;
    },
    async onSubmit() {
      const that = this;
      await this.$axios.post(`/api/accounts/${this.$route.params.id}/transactions`, this.payment)
      .then(response => {
        that.loadAccount();
        that.showForm = false;
      })
      .catch(error => {
        alert(JSON.stringify(error.response.data.errors || error.response.data));
      });
    },
  }
};
</script>
