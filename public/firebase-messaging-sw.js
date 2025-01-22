importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-auth.js');

firebase.initializeApp({
    apiKey: "AIzaSyCXQ3qmoX-V8a1sO__YzVdGpzYntdquVjE",
    authDomain: "loungesvibe.firebaseapp.com",
    projectId: "loungesvibe",
    storageBucket: "loungesvibe.firebasestorage.app",
    messagingSenderId: "723994475168",
    appId: "1:723994475168:web:bd9f1e06df6a64865627c5",
    measurementId: "G-4T20V3DCFC"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    return self.registration.showNotification(payload.data.title, {
        body: payload.data.body || '',
        icon: payload.data.icon || ''
    });
});