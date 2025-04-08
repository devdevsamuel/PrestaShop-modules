{literal}
<script src="https://www.gstatic.com/firebasejs/10.11.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.11.0/firebase-messaging-compat.js"></script>

<script>
  const firebaseConfig = {
    apiKey: "TU_API_KEY",
    authDomain: "TU_AUTH_DOMAIN",
    projectId: "TU_PROJECT_ID",
    messagingSenderId: "TU_MESSAGING_SENDER_ID",
    appId: "TU_APP_ID"
  };

  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();

  navigator.serviceWorker.register('/modules/fcmnotify/firebase-messaging-sw.js')
    .then((registration) => {
      messaging.useServiceWorker(registration);
      messaging.requestPermission()
        .then(() => messaging.getToken({ vapidKey: "TU_VAPID_KEY" }))
        .then((token) => {
          console.log("TOKEN: ", token);
          // Aquí podrías hacer un POST con fetch para guardar el token en tu backend
        });
    });
</script>
{/literal}