$(document).ready(function()
{
    var baseUrl = (!window.location.origin) ? window.location.origin = window.location.protocol + '//' + window.location.host : '';

    function browser(field_name, url, type, win)
    {
        if(type === 'media')
        {
            tinyMCE.activeEditor.windowManager.alert('There is no browser dialog available for this plugin');
        }
        else
        {
            var cmsURL = window.location.toString();    // script URL - use an absolute path!
            cmsURL = 'type=' + (cmsURL.indexOf("?") < 0) ? cmsURL + ' ?type='  + type : cmsURL + ' &type=' + type;

            switch(type)
            {
                case 'image':
                    var browserUrl = baseUrl + '/images/browser/';
                    var dialogTitle = 'Images';
                break;
                case 'file':
                    var browserUrl = baseUrl + '/filebrowser/';
                    var dialogTitle = 'Files';
                break;
            }

            tinymce.win_image = tinymce.activeEditor.windowManager.open({
                url: browserUrl,
                title: dialogTitle,
                width : 701,  
                height : 500,
                resizable : 'yes',
                inline : 'yes',
                close_previous : 'no'
            }, {
                window : win,
                input : field_name,
                oninsert: function(url, title)
                {
                    win.document.getElementById(field_name).value = url;
                }
            });
            return false;
        }
    }

    $(function()
    {
        $('body').find('div[contenteditable="true"][data-content]').tinymce({
            script_url : '../tinymce/tinymce.min.js',
            theme: 'modern',
            skin : 'dgp',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor'
            ],
            toolbar1: 'undo redo | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | charmap',
            toolbar2: 'styleselect | bold italic strikethrough | removeformat | link unlink | image media',
            add_unload_trigger: false,
            entity_encoding : 'raw',
            inline_styles : false,
            inline: true,
            schema: 'html5',
            element_format : 'xhtml',
            relative_urls: false,
            absolute_urls: true,
            convert_urls : false,
            image_advtab: false,
            statusbar: false,
            panel_align: 'auto',
            link_list: baseUrl + '/pages/links/',
            file_browser_callback : browser,
            menu: { 
                edit: {title: 'Edit', items: 'cut copy paste | selectall | searchreplace'}, 
                insert: {title: 'Insert', items: 'hr nonbreaking anchor insertdatetime emoticons'}, 
                view: {title: 'View', items: 'visualblocks'}, 
                table: {title: 'Table', items: 'inserttable tableprops deletetable cell row column'}, 
                tools: {title: 'Tools', items: 'code'} 
            },
            insertdate_formats: ['%H:%M:%S', '%r', '%d-%m-%Y', '%d/%m/%Y', '%m-%d-%Y', '%m/%d/%Y'],
            insertdate_timeformat: '%H:%M:%S',
            style_formats: [
                {title: 'Headers', items: [
                    {title: 'Header 1', format: 'h1'},
                    {title: 'Header 2', format: 'h2'},
                    {title: 'Header 3', format: 'h3'},
                    {title: 'Header 4', format: 'h4'},
                    {title: 'Header 5', format: 'h5'},
                    {title: 'Header 6', format: 'h6'}
                ]},
                {title: 'Inline', items: [
                    {title: 'Superscript', icon: 'superscript', format: 'superscript'},
                    {title: 'Subscript', icon: 'subscript', format: 'subscript'},
                    {title: 'Code', icon: 'code', format: 'code'}
                ]},
                {title: 'Blocks', items: [
                    {title: 'Paragraph', format: 'p'},
                    {title: 'Blockquote', format: 'blockquote'}
                ]},
                {title: 'Images', items: [
                    {title: 'Left', selector: 'img', classes: 'left'},
                    {title: 'Right', selector: 'img', classes: 'right'},
                    {title: 'Center', selector: 'img', classes: 'center'},
                    {title: 'No enlarge', selector: 'img', classes: 'no-enlarge'}
                ]},
                {title: 'Links', items: [
                    {title: 'Link block', selector: 'a', classes: 'link-block'},
                    {title: 'Link block active', selector: 'a', classes: 'link-block-active'}
                ]}
            ]
        });
    });
});