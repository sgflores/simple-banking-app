export const state = () => ({
    env: {
        APP_URL: process.env.APP_URL,
        grant_type: process.env.grant_type,
        client_id: process.env.client_id,
        client_secret: process.env.client_secret
    },
    account: null,
    transactions: null,
    currencies: null,
});

export const getters = {
    account(state) {
        return state.account;
    },
    transactions(state) {
        return state.transactions;
    },
    currencies(state) {
        return state.currencies;
    },
};

export const mutations = {
    setAccount(state, account) {
        state.account = account;
    },
    setTransactions(state, transactions) {
        state.transactions = transactions;
    },
    setCurrencies(state, currencies) {
        state.currencies = currencies;
    },
};

export const actions = {
    async loadAccount(context, {$axios, $route}) {
        const { data } = await $axios.get(`/api/accounts/${$route.params.id}`);
        context.commit('setAccount', data);
    },
    async loadTransactions(context, {$axios, $route}) {
        const { data } = await $axios.get(`/api/accounts/${$route.params.id}/transactions`);
        context.commit('setTransactions', data.data);
    },
    async loadCurrencies(context, {$axios}) {
        const { data } = await $axios.get(`/api/currencies`);
        context.commit('setCurrencies', data.data);
    },
};