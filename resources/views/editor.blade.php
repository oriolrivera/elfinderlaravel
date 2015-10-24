<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>elFinder 2.0</title>

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="<?= asset('packages/barryvdh/elfinder/css/elfinder.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset('packages/barryvdh/elfinder/css/theme.css') ?>">

    <!-- elFinder JS (REQUIRED) -->
    <script src="<?= asset('packages/barryvdh/elfinder/js/elfinder.min.js') ?>"></script>

    <script type="text/javascript" src="<?= asset('packages/barryvdh/elfinder/js/i18n/elfinder.es.js') ?>"></script>


   
    
    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">

        var FileBrowserDialogue = {
                init: function() {
                    // Here goes your code for setting your custom things onLoad.
                },
                mySubmit: function (file, fm) {
                    // pass selected file data to TinyMCE
                    parent.tinymce.activeEditor.windowManager.getParams().oninsert(file, fm);
                    // close popup window
                    parent.tinymce.activeEditor.windowManager.close();
                }
            }
            // Documentation for client options:
            // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
            $().ready(function() {

                var getLang = function() {
                    try {
                        var full_lng = (navigator.browserLanguage || navigator.language || navigator.userLanguage);
                        var lng = full_lng.substr(0,2);
                        if (lng == 'ja') lng = 'jp';
                        else if (lng == 'pt') lng = 'pt_BR';
                        else if (lng == 'zh') lng = (full_lng.substr(0,5) == 'zh-tw')? 'zh_TW' : 'zh_CN';

                        if (lng != 'en') {
                            var script_tag      = document.createElement("script");
                            script_tag.type     = "text/javascript";
                            script_tag.src      = "js/i18n/elfinder."+lng+".js";
                            script_tag.charset = "utf-8";
                            $("head").append(script_tag);
                        }

                        return lng;
                    } catch(e) {
                        return 'en';
                    }
                };

                var elfinderInstance = $('#elfinder').elfinder({
                    resizable: false,
                    height: $(window).height() - 20,
                    ui  : ['toolbar', 'places', 'tree', 'path', 'stat'],
                    url : '<?= route("elfinder.connector") ?>',  // connector URL (REQUIRED)
                    customData: { 
                            _token: '<?= csrf_token() ?>'
                        },
                    lang: 'es'                     // language (OPTIONAL)
                    ,getFileCallback: function(file) { // editor callback
                        // file.url - commandsOptions.getfile.onlyURL = false (default)
                        // file     - commandsOptions.getfile.onlyURL = true (best with this alternative code)
                        FileBrowserDialogue.mySubmit(file, elfinderInstance); // pass selected file path to TinyMCE 
                    }
                }).elfinder('instance');

                // set document.title dynamically etc.
                var title = document.title;
                elfinderInstance.bind('open', function(event) {
                    var data = event.data || null;
                    var path = '';
                    
                    if (data && data.cwd) {
                        path = elfinderInstance.path(data.cwd.hash) || null;
                    }
                    document.title =  path? path + ':' + title : title;
                });

                // fit to window.height on window.resize
                var resizeTimer = null;
                $(window).resize(function() {
                    resizeTimer && clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {
                        var h = parseInt($(window).height()) - 20;
                        if (h != parseInt($('#elfinder').height())) {
                            elfinderInstance.resize('100%', h);
                        }
                    }, 200);
                });

            });


    </script>
</head>
<body>
    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>
</body>
</html>
