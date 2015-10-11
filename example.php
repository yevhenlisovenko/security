<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Example</title>

  </head>
  <body>
    <h1>Protected form without Captcha!</h1>

    
    <input type="text" id="title" placeholder="your title" />
    <textarea id="msg" placeholder="your text"></textarea>
    <button onclick="submit()" type="button" name="submit">Send</button>
    

  <?php 
      include_once "Security.php";
      $security = new Security();
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>
  
        var rand_hash = '<?=$security->ReturnRandHash()?>';
        var access_hash = '<?=$security->ReturnAccessHash()?>';
        var session_id = '<?=$security->ReturnSessionId()?>';
        
	function submit(){
		var isData = {};
		isData['title'] = $("#title").val();
		isData['msg'] = $("#msg").val();
	
		send(isData, success, null);
	}
	function success(data){
		console.log(data);
        }
        function send(data, callback, params){
            $.ajax(
                {
                    type: "POST",
                    url: '/action.php',
                    dataType: 'json',
                    xhrFields: {withCredentials: true},
                    data : (typeof data === "undefined")?sA():sA(data),
                    crossDomain: true,
                    success: function(data){
                        if (data.status == 'ok'){
                            rand_hash = data.rh;
                            access_hash = data.ah;
                            session_id = data.sid;
                            localStorage.setItem('rand_hash', rand_hash);
                            localStorage.setItem('access_hash', access_hash);
                            localStorage.setItem('session_id', session_id);
        
                            if (typeof callback !== "undefined" && callback != null){
                                if (typeof params !== "undefined" && callback != null){
                                    callback(data, params);
                                    return;
                                }else{
                                    callback(data);
                                    return;
                                }
                            }
                        }
                    }
                }
            );
        }
        function sA(isData){ 
          var isData = typeof isData !== 'undefined' ? isData : {}; 
          isData[f(true)]=f(false);  
          return isData;
        }
        function a(){ access_hash = localStorage.getItem('access_hash'); session_id = localStorage.getItem('session_id'); rand_hash = localStorage.getItem('rand_hash'); var pre=access_hash.match(/[0-9a-f]+/g),mixed=(parseInt(session_id)%2===0?pre.reverse():pre).join(''),s=mixed.length,r='',k;for(k=0;k<s;++k){if(k%3===0){r+=mixed.substring(k,k+1);}}return r;}
        function b(){ access_hash = localStorage.getItem('access_hash'); session_id = localStorage.getItem('session_id'); rand_hash = localStorage.getItem('rand_hash'); var pre=rand_hash.match(/[0-9a-f]+/g),mixed=((parseInt(session_id)+1)%2===0?pre.reverse():pre).join(''),s=mixed.length,r='',k;for(k=0;k<s;++k){if(k%3===0){r+=mixed.substring(k,k+1);}}return r;}
        function f(t){ return (t)?a():((!t)?b():false); }
        
        
  </script>
  
  </body>
</html>
