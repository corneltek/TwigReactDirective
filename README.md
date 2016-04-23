Twig ReactDirective Extension
=============================
Since react component could be renderred partially in an app, this extension
converts reactapp directive into HTML and JavaScript.  Let you write readable
code in your twig templates.

(This repository is split from `git subtree`, files and namespaces will be
re-arranged later, PRs welcome).

Example

```twig
{% reactapp MyApp with { title: 'Todo List' , items: [ ... ] } %}

{% set config = { ... } %}
{% reactapp MyApp with config %}
```

The code above outputs:

```html
<div id="MyApp123fa9ef"> </div>
<script>
jQuery(function() {
    var app = React.createElement(MyApp, { ... });
    app.render(document.getElementById("MyApp123fa9ef"));
});
</script>
```



