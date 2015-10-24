<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

    
    <textarea name="content" id="editor" cols="30" rows="15" class="form-control" placeholder="Contenido del post"></textarea>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    
<script type="text/javascript">
      // File Picker modification for FCK Editor v2.0 - www.fckeditor.net
     // by: Pete Forde <pete@unspace.ca> @ Unspace Interactive
     var urlobj;

     function BrowseServer(obj)
     {
          urlobj = obj;
          OpenServerBrowser(
         'http://localhost/laravel/elfinderlaravel/public/editor',
    
          screen.width * 0.7,
          screen.height * 0.7 ) ;
     }

     function OpenServerBrowser( url, width, height )
     {
          var iLeft = (screen.width - width) / 2 ;
          var iTop = (screen.height - height) / 2 ;
          var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes" ;
          sOptions += ",width=" + width ;
          sOptions += ",height=" + height ;
          sOptions += ",left=" + iLeft ;
          sOptions += ",top=" + iTop ;
          var oWindow = window.open( url, "BrowseWindow", sOptions ) ;
     }

     function SetUrl( url, width, height, alt )
     {
          document.getElementById(urlobj).value = url ;
          oWindow = null;
     }
     </script>

     

<script type="text/javascript" src="{{ url('') }}/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="{{ url('') }}/tinymce/tinymce_editor.js"></script>
<script type="text/javascript">
/*editor_config.selector = "#editor";
editor_config.path_absolute = "http://localhost/laravel/elfinderlaravel/public/editor";
tinymce.init(editor_config);*/

</script>
    <script type="text/javascript">
    function elFinderBrowser (callback, value, meta) {
      tinymce.activeEditor.windowManager.open({
        file: 'http://localhost/laravel/elfinderlaravel/public/editor',// use an absolute path!
        title: 'elFinder 2.1',
        width: 900, 
        height: 450,
        resizable: 'yes'
      }, {
        oninsert: function (file, fm) {
          var url, reg, info;

          // URL normalization
          url = file.url;
          reg = /\/[^/]+?\/\.\.\//;
          while(url.match(reg)) {
            url = url.replace(reg, '/');
          }
          
          // Make file info
          info = file.name + ' (' + fm.formatSize(file.size) + ')';

          // Provide file and text for the link dialog
          if (meta.filetype == 'file') {
            callback(url, {text: info, title: info});
          }

          // Provide image and alt text for the image dialog
          if (meta.filetype == 'image') {
            callback(url, {alt: info});
          }

          // Provide alternative source and posted for the media dialog
          if (meta.filetype == 'media') {
            callback(url);
          }
        }
      });
      return false;
    }
    // TinyMCE init
    tinymce.init({
      selector: "#editor",
      height : 400,
      plugins: "image, link, media",
      relative_urls: false,
      remove_script_host: false,
      toolbar: "undo redo | styleselect | link image media",
      file_picker_callback : elFinderBrowser
    });
  </script>

    
</body>
</html>