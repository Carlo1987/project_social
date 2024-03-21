<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <script src="http://localhost:3000/socket.io/socket.io.js"></script>
    <title>Progetto Social Chat</title>
  </head>
  <body>

  <h2> Progetto Social Chat </h2>

    <ul id="messages"></ul>

    <form action="">
      <input id="text_message" type="text" autocomplete="off" />
      <button type="submit">Send</button>
    </form>

    <script>

      let socket = io();

      const form = document.querySelector("form");
      const input = document.querySelector("#text_message");
      const messages = document.querySelector("#messages");


      form.addEventListener("submit", (e) => {
        e.preventDefault();
        if (input.value) {
          socket.emit("chat", input.value);
          input.value = "";
        }
      });


      socket.on("chat", (message) => {
        let li = document.createElement("li");
        li.append(message);
        messages.insertAdjacentElement("beforeend", li);
        window.scrollTo(0, document.body.scrollHeight);
      });

    </script>
  </body>
</html>
