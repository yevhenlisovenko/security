<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Example</title>

  </head>
  <body>
    <h1>Hello, world!</h1>

    <div id="support">
        <input type="text" id="title" placeholder="your title" />
        <textarea placeholder="your text"></textarea>
        <button onclick="send()" type="button" name="submit">Send</button>
    </div>


  <?php 
        $security = new Security();
        
  ?>
  <script>
        var rand_hash = '<?=$security->ReturnRandHash()?>';
        var access_hash = '<?=$security->ReturnAccessHash()?>';
        var session_id = '<?=$security->ReturnSessionId()?>';
  </script>
  
  </body>
</html>
