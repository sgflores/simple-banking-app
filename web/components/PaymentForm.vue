<template>
    <b-card header="New Payment">
              
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
            payment: {     
                currency: 'USD',
                amount: 1,
                convertedAmount: 1,
            }
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