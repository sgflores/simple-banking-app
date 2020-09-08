export default function ({ $auth, $router }) {
    // console.log($auth);
    if (!$auth.loggedIn) {
      return;
    }
}