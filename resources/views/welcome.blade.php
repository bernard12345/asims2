<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Real-time notifications in Laravel using Pusher</title>
 
  </head>
  <body>

    <ul id="mess" class="list-group">
      <li>israel</li>
    </ul>
    <h1>Real-time notifications in Laravel using Pusher</h1>
    <!-- Incldue Pusher Js Client via CDN -->

    @include('partials.javajs')
    <script src="https://js.pusher.com/4.2/pusher.min.js"></script>

    <!-- Alert whenever a new notification is pusher to our Pusher Channel -->
    <script>
    //Remember to replace key and cluster with your credentials.
    var pusher = new Pusher('033a636624d2992694ec',{
      cluster: 'ap1',
      encrypted: true
    });
    //Also remember to change channel and event name if your's are different.
    var channel = pusher.subscribe('thesis');
    channel.bind('notify-events', function(data){
      alert(data);
      var text = "";
          text ="<li> buhay is life </li>"+data;
        
       
        $("#mess").prepend(text);


      
        
    });
  </script>
  </body>
</html>