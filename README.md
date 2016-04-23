Twig ReactDirective Extension
=============================
Since ReactJS component could be renderred partially in an app, this extension
converts reactapp directive into HTML and JavaScript.  Let you write readable
code in your twig templates.

## Install

    composer require corneltek/twig-react-directive "*"

## Usage

```php
use TwigReactDirective\ReactDirectiveExtension;

$twig = new Twig_Environment($loader);
$twig->addExtension(new ReactDirectiveExtension);
```

## Template Example

```twig
{% reactapp "MyApp" with { title: 'Todo List' , items: [ ... ] } %}

{% set config = { ... } %}
{% reactapp "MyApp" with config %}
```

The code above outputs:

```html
<div id="MyApp123fa9ef"> </div>
<script type="text/javascript">
if (typeof __dom_ready === "undefined") {
  function __dom_ready(cb) {
    var d = document;
    var hack = d.documentElement.doScroll;
    var loaded = (hack ? /^loaded|^c/ : /^loaded|^i|^c/).test(d.readyState)
    if (!loaded) {
      d.addEventListener("DOMContentLoaded", function(){
        d.removeEventListener("DOMContentLoaded", arguments.callee, false );
        cb();
      }, false);
    }
    if (loaded) {setTimeout(cb, 0);}
  }
}
(function() {
  var ready = typeof jQuery !== "undefined" ? jQuery : __dom_ready;
ready(function() {
  var app = React.createElement(MyApp, {"title":"test title"});
  React.render(app, document.getElementById("MyApp123fa9ef"));
});

})();
</script>
```



