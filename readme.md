<div id="wiki-wrapper" class="wiki-wrapper page">
<div class="gh-header">
  <div class="gh-header-show">
    <h1 class="gh-header-title instapaper_title">Integration with TinyMCE 4.x</h1>
      <div class="gh-header-meta">
        Naoki Sawada edited this page <time datetime="2015-08-27T08:50:18Z" is="relative-time" title="Aug 27, 2015, 4:50 AM AST">on Aug 27</time>
        ·
        <a href="/Studio-42/elFinder/wiki/Integration-with-TinyMCE-4.x/_history" class="history">
          17 revisions
        </a>
      </div>
  </div>
</div>
<div id="wiki-content">
  <div class="wrap has-rightbar">


  <div id="wiki-body" class="gollum-markdown-content instapaper_body">
    <div class="markdown-body">
      <p>In the TinyMCE init code, add the following line:</p>

<div class="highlight highlight-source-js"><pre>file_browser_callback <span class="pl-k">:</span> elFinderBrowser</pre></div>

<p>Then add the following function (change the <code>elfinder_url</code> to the correct path on your system):</p>

<div class="highlight highlight-source-js"><pre><span class="pl-k">function</span> <span class="pl-en">elFinderBrowser</span> (<span class="pl-smi">field_name</span>, <span class="pl-smi">url</span>, <span class="pl-smi">type</span>, <span class="pl-smi">win</span>) {
  tinymce.activeEditor.windowManager.<span class="pl-c1">open</span>({
    file<span class="pl-k">:</span> <span class="pl-s"><span class="pl-pds">'</span>/elfinder/elfinder.html<span class="pl-pds">'</span></span>,<span class="pl-c">// use an absolute path!</span>
    title<span class="pl-k">:</span> <span class="pl-s"><span class="pl-pds">'</span>elFinder 2.0<span class="pl-pds">'</span></span>,
    width<span class="pl-k">:</span> <span class="pl-c1">900</span>,  
    height<span class="pl-k">:</span> <span class="pl-c1">450</span>,
    resizable<span class="pl-k">:</span> <span class="pl-s"><span class="pl-pds">'</span>yes<span class="pl-pds">'</span></span>
  }, {
    <span class="pl-en">setUrl</span><span class="pl-k">:</span> <span class="pl-k">function</span> (<span class="pl-smi">url</span>) {
      win.<span class="pl-c1">document</span>.<span class="pl-c1">getElementById</span>(field_name).<span class="pl-c1">value</span> <span class="pl-k">=</span> url;
    }
  });
  <span class="pl-k">return</span> <span class="pl-c1">false</span>;
}</pre></div>

<p>Create (or edit) <em>elfinder.html</em> file. Include jQuery, jQuery UI, and elFinder</p>

<div class="highlight highlight-text-html-basic"><pre><span class="pl-c">&lt;!-- Include jQuery, jQuery UI, elFinder (REQUIRED) --&gt;</span>

<span class="pl-s1">&lt;<span class="pl-ent">script</span> <span class="pl-e">type</span>=<span class="pl-s"><span class="pl-pds">"</span>text/javascript<span class="pl-pds">"</span></span>&gt;</span>
<span class="pl-s1">  <span class="pl-k">var</span> FileBrowserDialogue <span class="pl-k">=</span> {</span>
<span class="pl-s1">    <span class="pl-en">init</span><span class="pl-k">:</span> <span class="pl-k">function</span>() {</span>
<span class="pl-s1">      <span class="pl-c">// Here goes your code for setting your custom things onLoad.</span></span>
<span class="pl-s1">    },</span>
<span class="pl-s1">    <span class="pl-en">mySubmit</span><span class="pl-k">:</span> <span class="pl-k">function</span> (<span class="pl-smi">URL</span>) {</span>
<span class="pl-s1">      <span class="pl-c">// pass selected file path to TinyMCE</span></span>
<span class="pl-s1">      parent.tinymce.activeEditor.windowManager.getParams().setUrl(<span class="pl-c1">URL</span>);</span>
<span class="pl-s1"></span>
<span class="pl-s1">      <span class="pl-c">// force the TinyMCE dialog to refresh and fill in the image dimensions</span></span>
<span class="pl-s1">      <span class="pl-k">var</span> t <span class="pl-k">=</span> parent.tinymce.activeEditor.windowManager.windows[<span class="pl-c1">0</span>];</span>
<span class="pl-s1">      t.<span class="pl-c1">find</span>(<span class="pl-s"><span class="pl-pds">'</span>#src<span class="pl-pds">'</span></span>).fire(<span class="pl-s"><span class="pl-pds">'</span>change<span class="pl-pds">'</span></span>);</span>
<span class="pl-s1"></span>
<span class="pl-s1">      <span class="pl-c">// close popup window</span></span>
<span class="pl-s1">      parent.tinymce.activeEditor.windowManager.<span class="pl-c1">close</span>();</span>
<span class="pl-s1">    }</span>
<span class="pl-s1">  }</span>
<span class="pl-s1"></span>
<span class="pl-s1">  $().ready(<span class="pl-k">function</span>() {</span>
<span class="pl-s1">    <span class="pl-k">var</span> elf <span class="pl-k">=</span> $(<span class="pl-s"><span class="pl-pds">'</span>#elfinder<span class="pl-pds">'</span></span>).elfinder({</span>
<span class="pl-s1">      <span class="pl-c">// set your elFinder options here</span></span>
<span class="pl-s1">      url<span class="pl-k">:</span> <span class="pl-s"><span class="pl-pds">'</span>php/connector.php<span class="pl-pds">'</span></span>,  <span class="pl-c">// connector URL</span></span>
<span class="pl-s1">      <span class="pl-en">getFileCallback</span><span class="pl-k">:</span> <span class="pl-k">function</span>(<span class="pl-smi">file</span>) { <span class="pl-c">// editor callback</span></span>
<span class="pl-s1">        <span class="pl-c">// file.url - commandsOptions.getfile.onlyURL = false (default)</span></span>
<span class="pl-s1">        <span class="pl-c">// file     - commandsOptions.getfile.onlyURL = true</span></span>
<span class="pl-s1">        FileBrowserDialogue.mySubmit(file); <span class="pl-c">// pass selected file path to TinyMCE </span></span>
<span class="pl-s1">      }</span>
<span class="pl-s1">    }).elfinder(<span class="pl-s"><span class="pl-pds">'</span>instance<span class="pl-pds">'</span></span>);      </span>
<span class="pl-s1">  });</span>
<span class="pl-s1">&lt;/<span class="pl-ent">script</span>&gt;</span></pre></div>

<h1>
<a id="user-content-alternative-method-using-the-new-tinymce-file_picker_callback-configuration-option" class="anchor" href="#alternative-method-using-the-new-tinymce-file_picker_callback-configuration-option" aria-hidden="true"><span class="octicon octicon-link"></span></a>Alternative method using the new TinyMCE 'file_picker_callback' configuration option</h1>

<p>(seems to better populate image dimensions, <a href="http://hypweb.net/elFinder-nightly/demo/tinymce/">this integration demo</a>)</p>

<p>In the TinyMCE init code, add the following line:</p>

<div class="highlight highlight-source-js"><pre>plugins<span class="pl-k">:</span> <span class="pl-s"><span class="pl-pds">"</span>image, link, media<span class="pl-pds">"</span></span>, <span class="pl-c">// example</span>
toolbar<span class="pl-k">:</span> <span class="pl-s"><span class="pl-pds">"</span>link image media<span class="pl-pds">"</span></span>,   <span class="pl-c">// example</span>
file_picker_callback <span class="pl-k">:</span> elFinderBrowser</pre></div>

<p>Then add the following function (change the <code>elfinder_url</code> to the correct path on your system):</p>

<div class="highlight highlight-source-js"><pre><span class="pl-k">function</span> <span class="pl-en">elFinderBrowser</span> (<span class="pl-smi">callback</span>, <span class="pl-smi">value</span>, <span class="pl-smi">meta</span>) {
  tinymce.activeEditor.windowManager.<span class="pl-c1">open</span>({
    file<span class="pl-k">:</span> <span class="pl-s"><span class="pl-pds">'</span>/elfinder/elfinder.html<span class="pl-pds">'</span></span>,<span class="pl-c">// use an absolute path!</span>
    title<span class="pl-k">:</span> <span class="pl-s"><span class="pl-pds">'</span>elFinder 2.0<span class="pl-pds">'</span></span>,
    width<span class="pl-k">:</span> <span class="pl-c1">900</span>,  
    height<span class="pl-k">:</span> <span class="pl-c1">450</span>,
    resizable<span class="pl-k">:</span> <span class="pl-s"><span class="pl-pds">'</span>yes<span class="pl-pds">'</span></span>
  }, {
    <span class="pl-en">oninsert</span><span class="pl-k">:</span> <span class="pl-k">function</span> (<span class="pl-smi">file</span>, <span class="pl-smi">elf</span>) {
      <span class="pl-k">var</span> url, reg, info;

      <span class="pl-c">// URL normalization</span>
      url <span class="pl-k">=</span> file.url;
      reg <span class="pl-k">=</span><span class="pl-sr"> <span class="pl-pds">/</span><span class="pl-cce">\/</span><span class="pl-c1">[<span class="pl-k">^</span>/]</span><span class="pl-k">+?</span><span class="pl-cce">\/\.\.\/</span><span class="pl-pds">/</span></span>;
      <span class="pl-k">while</span>(url.<span class="pl-c1">match</span>(reg)) {
        url <span class="pl-k">=</span> url.<span class="pl-c1">replace</span>(reg, <span class="pl-s"><span class="pl-pds">'</span>/<span class="pl-pds">'</span></span>);
      }

      <span class="pl-c">// Make file info</span>
      info <span class="pl-k">=</span> file.<span class="pl-c1">name</span> <span class="pl-k">+</span> <span class="pl-s"><span class="pl-pds">'</span> (<span class="pl-pds">'</span></span> <span class="pl-k">+</span> elf.formatSize(file.<span class="pl-c1">size</span>) <span class="pl-k">+</span> <span class="pl-s"><span class="pl-pds">'</span>)<span class="pl-pds">'</span></span>;

      <span class="pl-c">// Provide file and text for the link dialog</span>
      <span class="pl-k">if</span> (meta.filetype <span class="pl-k">==</span> <span class="pl-s"><span class="pl-pds">'</span>file<span class="pl-pds">'</span></span>) {
        callback(url, {text<span class="pl-k">:</span> info, title<span class="pl-k">:</span> info});
      }

      <span class="pl-c">// Provide image and alt text for the image dialog</span>
      <span class="pl-k">if</span> (meta.filetype <span class="pl-k">==</span> <span class="pl-s"><span class="pl-pds">'</span>image<span class="pl-pds">'</span></span>) {
        callback(url, {alt<span class="pl-k">:</span> info});
      }

      <span class="pl-c">// Provide alternative source and posted for the media dialog</span>
      <span class="pl-k">if</span> (meta.filetype <span class="pl-k">==</span> <span class="pl-s"><span class="pl-pds">'</span>media<span class="pl-pds">'</span></span>) {
        callback(url);
      }
    }
  });
  <span class="pl-k">return</span> <span class="pl-c1">false</span>;
}</pre></div>

<p>Create (or edit) <em>elfinder.html</em> file. Include jQuery, jQuery UI, and elFinder</p>

<div class="highlight highlight-text-html-basic"><pre><span class="pl-c">&lt;!-- Include jQuery, jQuery UI, elFinder (REQUIRED) --&gt;</span>

<span class="pl-s1">&lt;<span class="pl-ent">script</span> <span class="pl-e">type</span>=<span class="pl-s"><span class="pl-pds">"</span>text/javascript<span class="pl-pds">"</span></span>&gt;</span>
<span class="pl-s1">  <span class="pl-k">var</span> FileBrowserDialogue <span class="pl-k">=</span> {</span>
<span class="pl-s1">    <span class="pl-en">init</span><span class="pl-k">:</span> <span class="pl-k">function</span>() {</span>
<span class="pl-s1">      <span class="pl-c">// Here goes your code for setting your custom things onLoad.</span></span>
<span class="pl-s1">    },</span>
<span class="pl-s1">    <span class="pl-en">mySubmit</span><span class="pl-k">:</span> <span class="pl-k">function</span> (<span class="pl-smi">file</span>, <span class="pl-smi">elf</span>) {</span>
<span class="pl-s1">      <span class="pl-c">// pass selected file data to TinyMCE</span></span>
<span class="pl-s1">      parent.tinymce.activeEditor.windowManager.getParams().oninsert(file, elf);</span>
<span class="pl-s1">      <span class="pl-c">// close popup window</span></span>
<span class="pl-s1">      parent.tinymce.activeEditor.windowManager.<span class="pl-c1">close</span>();</span>
<span class="pl-s1">    }</span>
<span class="pl-s1">  }</span>
<span class="pl-s1"></span>
<span class="pl-s1">  $().ready(<span class="pl-k">function</span>() {</span>
<span class="pl-s1">    <span class="pl-k">var</span> elf <span class="pl-k">=</span> $(<span class="pl-s"><span class="pl-pds">'</span>#elfinder<span class="pl-pds">'</span></span>).elfinder({</span>
<span class="pl-s1">      <span class="pl-c">// set your elFinder options here</span></span>
<span class="pl-s1">      url<span class="pl-k">:</span> <span class="pl-s"><span class="pl-pds">'</span>php/connector.php<span class="pl-pds">'</span></span>,  <span class="pl-c">// connector URL</span></span>
<span class="pl-s1">      <span class="pl-en">getFileCallback</span><span class="pl-k">:</span> <span class="pl-k">function</span>(<span class="pl-smi">file</span>) { <span class="pl-c">// editor callback</span></span>
<span class="pl-s1">        <span class="pl-c">// Require `commandsOptions.getfile.onlyURL = false` (default)</span></span>
<span class="pl-s1">        FileBrowserDialogue.mySubmit(file, elf); <span class="pl-c">// pass selected file path to TinyMCE </span></span>
<span class="pl-s1">      }</span>
<span class="pl-s1">    }).elfinder(<span class="pl-s"><span class="pl-pds">'</span>instance<span class="pl-pds">'</span></span>);      </span>
<span class="pl-s1">  });</span>
<span class="pl-s1">&lt;/<span class="pl-ent">script</span>&gt;</span></pre></div>

    </div>

  </div>
  </div>
</div>
</div>