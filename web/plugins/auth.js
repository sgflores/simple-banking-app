export default function ({ $auth, $router }) {
    if (!$auth.loggedIn) {
      return;
    }
  
    const username = $auth.user.username
}