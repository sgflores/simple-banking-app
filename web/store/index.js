import Vuex from 'vuex';

export const state = () => ({
    token: null,
    env: {
        APP_URL: process.env.APP_URL,
        grant_type: process.env.grant_type,
        client_id: process.env.client_id,
        client_secret: process.env.client_secret
    }
});

export const mutations = {
    setToken(state, token) {
        state.token = token;
    }
};

export const actions = {
    setToken(context, token) {
        context.commit('setToken', token);
    }
};