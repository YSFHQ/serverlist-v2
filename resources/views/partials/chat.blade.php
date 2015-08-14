<div id="firechat-wrapper"></div>
<script type="text/javascript">
  var chatRef = new Firebase("https://ysfhq-chat.firebaseio.com");
  var chat = new FirechatUI(chatRef, document.getElementById("firechat-wrapper"));
  chatRef.onAuth(function(authData) {
    if (authData) {
      chat.setUser(authData.uid, "Anonymous" + authData.uid.substr(10, 8));
    } else {
      chatRef.authAnonymously(function(error, authData) {
        if (error) {
          console.log(error);
        }
      });
    }
  });
</script>
