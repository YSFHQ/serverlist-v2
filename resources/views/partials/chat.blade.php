<div id="firechat-wrapper"></div>
@section('firechat-scripts')
<script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
<script src="https://cdn.firebase.com/libs/firechat/3.0.1/firechat.min.js"></script>
<script type="text/javascript">
  // Initialize Firebase SDK
  var config = {
    apiKey: "AIzaSyAxMOwhVljij8H1W40oLlnqvDJUF3lq77o",
    authDomain: "ysfhq-chat.firebaseapp.com",
    databaseURL: "https://ysfhq-chat.firebaseio.com",
    projectId: "ysfhq-chat",
    storageBucket: "ysfhq-chat.appspot.com",
    messagingSenderId: "330865101131"
  };
  firebase.initializeApp(config);

  // Get a reference to the Firebase Realtime Database
  var chatRef = firebase.database().ref("ysfhq-chat");

  // Create an instance of Firechat
  var chat = new FirechatUI(chatRef, document.getElementById("firechat-wrapper"));

  // Listen for authentication state changes
  firebase.auth().onAuthStateChanged(function (user) {
    if (user) {
      // If the user is logged in, set them as the Firechat user
      chat.setUser(user.uid, "Anonymous" + user.uid.substr(10, 8));
    } else {
      // If the user is not logged in, sign them in anonymously
      firebase.auth().signInAnonymously().catch(function(error) {
        console.log("Error signing user in anonymously:", error);
      });
    }
  });

  var audio = new Audio('notification.mp3');
  chat.on('message-add', function () {
    audio.play();
  });
</script>
@endsection