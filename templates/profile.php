<?php
	include(__DIR__ . "/header.php");
?>

<html>
    <head></head>
		<script language="javascript"> 

		function toggle(el) {
			if ( el.id && el.style.display == 'block' ) {
				el.style.display = 'none';
			} else {
				el.style.display = 'block';
			}
		}

		function cancelToggle(id, e) {
				var target = (e && e.target) || (event && event.srcElement);
				var obj = document.getElementById('toggleText');
				if (target != obj) {
					obj.style.display='none'
				}
			}

		function stop(e) {
			if(!e) {
				window.event.cancelBubble = true;
			} else {
				e.stopPropagation();
			}
		}
	
    </script>
    <body>

    <a id="displayText" href="javascript:toggle(document.getElementById('toggleText'));">show</a>

    <div onClick='toggle(this)' id="toggleText" style="display: none; background: none repeat scroll 0 0 rgba(0, 0, 0, 0.6);  
               bottom: 0; height: 100%; left: 0; overflow: hidden; position: fixed; right:100; top: 10; width: 100%;">

       <div onClick='stop(event)' style="background: none repeat scroll 0 0 #80C5A9; display: block; height: 40%; position:fixed; bottom: 0;  overflow: hidden; width: 100%;">
      <h1>Welcome Naren</h1>
      <label>Its good for u.All the best</label> 
     </div>
    </div>

    </body>
</html>

<?php
	include(__DIR__ . "/footer.php");
?>

