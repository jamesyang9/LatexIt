<!DOCTPYE html>
<html>
  <head>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
    function verify(form) {
      if (form.name.value == '') {
        alert('Please enter a name.');
        return false;
      }
      return true;
    }
    </script>
   </head>
   <body>
     <div id="login">
       <div id="logo">
         <img src="http://lorempixel.com/50/50/cats">
         <span>LatexIt</span>
       </div>
       <form method="POST" action="index.php" onsubmit="return verify(this);">        
        <input type="text" placeholder="Enter a name..." name="name" />
        <input type="hidden" name="post" value="name" />
        <input type="submit" value="" />
       </form>
     </div>
   </body>
</html
