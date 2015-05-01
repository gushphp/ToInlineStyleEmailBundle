ToInlineStyleEmailBundle
========================

**ToInlineStyleEmailBundle** is a _Symfony2_ bundle to use the **CssToInlineStyles** translator by _Tijs Verkoyen_ (see
https://github.com/tijsverkoyen/CssToInlineStyles for the repository)

Requirements
============
**ToInlineStyleEmailBundle** is only supported on **PHP 5.3.3** and up.

Installation
============
Please, use the _Composer_ to install this bundle in your Symfony2 app. 

The following lines should be added in your ```composer.json```

``` json
"require": {
    "robertotru/to-inline-style-email-bundle": "dev-master"
},
```

Then, register the bundle in your AppKernel by adding the following line:

``` php
new RobertoTru\ToInlineStyleEmailBundle\RobertoTruToInlineStyleEmailBundle(),
```

Documentation and Examples
==========================
The bundle provides a service named **css_to_inline_email_converter**. Use it in a controller to have a nice shortcut to the 
converter developed by _Tijs Verkoyen_. E.g.:

``` php
public function indexAction() { 
 $converter = $this->get('css_to_inline_email_converter');
 ...
}
```

Get the HTML and the CSS as a string and set this required values to the converter object, e.g.

``` php
$converter = $this->get('css_to_inline_email_converter');
 
$html = ...; // get the HTML here
$css = ....; // get the CSS here
      
$converter->setHTML($html);
$converter->setCSS($css);
```

The retrieval of the HTML and CSS files from its folder it is only up-to you. E.g. in your controller retrieve the content of your CSS as:

``` php
file_get_contents($this->container->getParameter('kernel.root_dir').
'/../src/Acme/TestBundle/Resources/css/mystyle.css');
```

Of course, it is supposed that a Symfony user will use a template instead of a static HTML page. Hence, 
for convenience, the service provides a function capable to render a template. E.g.:

``` php
$converter->setHTMLByView('AcmeTestBundle:MyController:my_template.html.twig', 
   array('param_1'=>$val_of_param_1, ..., 'param_n'=>$val_of_param_n));
```

The preceding function must be used _in vece_ of function ```setHTML()```.

You can use inline css directly in Twig template:

``` html
{% inlinecss '/css/email.css' %}
<div class="foo">
...
</div>
{% endinlinecss %}
```

Paths relative to bundle are supported as well:

``` html
{% inlinecss '@AcmeBundle:css:email.css' %}
<div class="foo">
...
</div>
{% endinlinecss %}
```

Read the docs in the files for further details on the usage of the service. 

Contributing
============
**ToInlineStyleEmailBundle** is an open source project. Contributions are encouraged. 
Feel free to contribute to improve this bundle.

About the author of the bundle
==============================
**ToInlineStyleEmailBundle** has been originally developed by Roberto Trunfio. Currently, the bundle is mantained by Daniel Richter.
