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
    
};

export const actions = {

};