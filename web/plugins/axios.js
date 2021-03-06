export default function ({ store, $axios, redirect, $toast }) {
    
    $axios.defaults.baseURL = store.state.env.APP_URL;

    $axios.onRequest(config => {
      
    });
  
    $axios.onError(error => {
      const code = parseInt(error.response && error.response.status)
      if (code === 400) {
        redirect('/400')
      }
      if (code === 401 || code === 404) {
        redirect('/')
      }
    });
  }