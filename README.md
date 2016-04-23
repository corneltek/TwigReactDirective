Twig ReactDirective Extension
=============================

This repository is split from `git subtree`, files and namespaces will be re-arranged later.


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



