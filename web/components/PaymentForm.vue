<template>
    <b-card header="New Payment">
              
        <b-form @submit.prevent="onSubmit" novalidate>
            <b-form-group id="amount-group" label="You Send:" label-for="amount">
                <b-input-group :prepend="account.currency" size="sm">
                <b-form-input @change="convertAmount"
                    id="amount"
                    v-model="payment.amount"
                    type="number" stype="any"
                    required
                    placeholder="Amount"
                    :class="{ 'is-invalid': payment.errors.has('amount') }"
                ></b-form-input>
                <has-error :form="payment" field="amount"></has-error>
                </b-input-group>
            </b-form-group>

            <b-form-group id="to-group" label="To:" label-for="to">
                <b-form-input
                id="to"
                size="sm"
                v-model="payment.to"
                type="number"
                step="any"
                required
                placeholder="Destination ID"
                :class="{ 'is-invalid': payment.errors.has('to') }"
                ></b-form-input>
                <has-error :form="payment" field="to"></has-error>
            </b-form-group>
            
            
            <div class="row">
                <div class="col-sm-3">
                    <b-form-group id="currency-group" label="Currency" label-for="currency">
                        <b-form-select id="currency" v-model="payment.currency" :options="currencies" @change="convertAmount"
                        value-field="code" text-field="code"
                        required :class="{ 'is-invalid': payment.errors.has('currency') }">
                        </b-form-select>
                        <has-error :form="payment" field="currency"></has-error>
                    </b-form-group>
                    </div>
                    <div class="col-sm-9">
                        <b-form-group id="converted-amount-group" label="Converted Amount" label-for="converted-amount">
                        <b-form-input
                        id="converted-amount"
                        v-model="payment.convertedAmount"
                        :readonly="true"
                        type="number"
                        required
                        placeholder="Converted Amount"
                        ></b-form-input>
                    </b-form-group>
                
                </div>
            </div>
            
            <b-form-group id="details-group" label="Details:" label-for="details">
                <b-form-input
                id="details"
                size="sm"
                v-model="payment.details"
                required
                placeholder="Payment details"
                :class="{ 'is-invalid': payment.errors.has('details') }"
                ></b-form-input>
                <has-error :form="payment" field="details"></has-error>
            </b-form-group>

            <b-button type="button" size="sm" variant="warning" @click="cancel">Cancel</b-button>
            <b-button type="submit" size="sm" variant="primary">Submit</b-button>

        </b-form>
        
    </b-card>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    props: {
        account: {
            required: true,
            type: Object,
        },
    },
     computed: {
      ...mapGetters({
        'currencies': 'currencies',
      }),
       
    },
    data() {
        return {
            payment: this.$vform({     
                currency: 'USD',
                amount: 1,
                convertedAmount: 1,
            })
        }
    },
    methods: {
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
      resetForm() {
          this.payment = {
               currency: 'USD',
            amount: 1,
            convertedAmount: 1,
          }
      },
      cancel() {
          this.resetForm();
          this.$emit('cancelFormHandler');
      },
      onSubmit() {
          this.$emit('onSubmitHandler', this.payment);
      },
    },
}
</script>