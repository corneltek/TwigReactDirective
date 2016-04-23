<?php
namespace TwigReactDirective;
use Twig_Node;
use Twig_Compiler;
use Twig_Node_Expression;
use Twig_Node_Expression_Array;
use Twig_Node_Expression_Constant;
use Twig_Node_Expression_Name;
use Twig_Node_Expression_GetAttr;

class ReactAppNode extends Twig_Node
{
    public function __construct(array $attributes, $lineno, $tag = null)
    {
        parent::__construct(array(), $attributes, $lineno, $tag);
    }

    protected function writeEcho($compiler, $str)
    {
        $compiler->raw('echo "' . addslashes($str) . '";' . PHP_EOL);
    }

    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);
        $appName = $this->getAttribute('reactapp');
        $configNode = $this->getAttribute('config');
        $bindTo = $this->getAttribute('bind_to');

        $compiler->write("// ReactDirectiveExtension\n");

        if ($bindTo) {
            $compiler->write("\$elementId = '$bindTo';\n");
        } else {
            $compiler->write("\$elementId = uniqid('$appName');\n");
        }

        $configVarName = $compiler->getVarName();
        $compiler->write("\$$configVarName = ");
        $configNode->compile($compiler);
        $compiler->write(";\n");

        if ($bindTo) {
            // don't render react app container here
        } else {
        }

        $this->writeEcho($compiler, "<div id=\"{\$elementId}\"> </div>\n");
        $this->writeEcho($compiler, "<script type=\"text/javascript\">\n");

        $compiler->raw('echo \'
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
\';');
        // use jQuery flag switch
        $this->writeEcho($compiler, "ready(function() {\n");
        if ($compiler->getEnvironment()->isDebug()) {
            $compiler->raw("echo \"console.info(\'Initialize $appName on \$elementId:\');\";\n");
            $compiler->raw("echo 'console.dir(';");
            $compiler->raw("echo json_encode(\$$configVarName, JSON_PRETTY_PRINT);\n");
            $compiler->raw("echo ');';");
        }

        $this->writeEcho($compiler, "  var app = React.createElement($appName, ");

        if ($compiler->getEnvironment()->isDebug()) {
            $compiler->raw("echo json_encode(\$$configVarName, JSON_PRETTY_PRINT);\n");
        } else {
            $compiler->raw("echo json_encode(\$$configVarName);\n");
        }

        $this->writeEcho($compiler, ");\n");

        // React.render(app, document.getElementById('{{eid}}'));
        $this->writeEcho($compiler, "  React.render(app, document.getElementById(\"{\$elementId}\"));\n");

        $this->writeEcho($compiler, "});\n"); // end of __dom_ready


        $compiler->raw('echo \'
})();
\';');
        $this->writeEcho($compiler, "</script>\n");
    }
}




