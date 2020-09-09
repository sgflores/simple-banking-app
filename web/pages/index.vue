<template>
  <div class="container">
    <div>
      <b-form @submit.prevent="login">
        <b-form-group class="text-bold"
          id="input-group-2"
          label="Enter your account ID:"
          label-for="input-2"
        >
          <b-form-input
            id="input"
            type="number"
            v-model="accountID"
            required
            placeholder="Account ID"
          ></b-form-input>
        </b-form-group>

        <b-button @click="login" variant="primary"
          >Login</b-button
        >
      </b-form>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
export default Vue.extend({
  auth: false,
  data() {
    return {
      accountID: 1
    };
  },
  components: {},
  methods: {
    async login() {
        const {data} = await this.$axios.post('/api/oauth/token', {
          "grant_type": this.$store.state.env.grant_type,
          "client_id": this.$store.state.env.client_id,
          "client_secret": this.$store.state.env.client_secret
        });
        
        this.$auth.setToken('local', 'Bearer ' + data.access_token);
        this.$auth.setRefreshToken('local', data.refresh_token);
        this.$axios.setHeader('Authorization', 'Bearer ' + data.access_token);

        this.$router.push(`/accounts/${this.accountID}`);
        
    }
  }
});
</script>

<style scoped>
.container {
  margin: 0 auto;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.title {
  font-family: "Quicksand", "Source Sans Pro", -apple-system, BlinkMacSystemFont,
    "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  display: block;
  font-weight: 300;
  font-size: 100px;
  color: #35495e;
  letter-spacing: 1px;
}

.subtitle {
  font-weight: 300;
  font-size: 42px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.links {
  padding-top: 15px;
}
.text-bold {
  font-weight: bolder;
  color: #fff;
}
</style>
