<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>
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

      $(function(){
        let ip = "127.0.0.1";
        let port = "3000";

        let socket = io('http://'+ip+':'+port);  



        socket.on('connection');
      })

     

   /*    const form = document.querySelector("form");
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
      }); */

    </script>
  </body>
</html>
