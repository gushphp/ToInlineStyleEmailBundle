ToInlineStyleEmailBundle
========================

**ToInlineStyleEmailBundle** is a _Symfony2_ bundle to use the **CssToInlineStyles** translator by _Tijs Verkoyen_ (see
https://github.com/tijsverkoyen/CssToInlineStyles for the repository)


Requirements
===========
ToInlineStyleEmailBundle is only supported on **PHP 5.3.3** and up.

Installation
===========
Please, use composer to install this bundle in your Symfony2 app. Then, register the bundle in your AppKernel. 

Documentation and Examples
===========
The bundle should provide a service named **css_to_inline_email_converter**. Use it in your controllers to have a shortcut to the 
converter developed by _Tijs Verkoyen_. Read the docs in the files for further details. For convenience, the service provides a function
capable to render a template. Retrieving the CSS file from its folder its only up-to you. E.g. in your controller retrieve the content of your CSS as:

``` php
file_get_contents($this->container->getParameter('kernel.root_dir').'/../src/Acme/MyBundle/Resources/css/style.css');
```

Contributing
===========
ToInlineStyleEmailBundle is an open source project. Contributions are encouraged. 
Feel free to contribute to improve this bundle.

About the author of the bundle
===========
ToInlineStyleEmailBundle has been originally developed and is mantained by Roberto Trunfio (see more on the author at www.trunfio.it)

