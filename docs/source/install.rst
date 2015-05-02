Installation
====================================

Laravel-Base
------------------------------------
If you are adding bootstrap to Laravel-Base, you will need to make some minor changes.

- Remove ``resources/views/layouts/default.blade.php`` (Optional but this package contains a more in depth layout)
- Remove ``Illuminate\Html\HtmlServiceProvider`` from ``config/app.php``.

Composer
------------------------------------
.. code::

    composer require nukacode/front-end-bootstrap:~1.0

Routes
------------------------------------
If you would like to use the included routes, add the following to your ``app/Http/routes.php`` file.

.. code::

    include_once(base_path() .'/vendor/nukacode/front-end-bootstrap/src/routes.php');

Service Providers
------------------------------------
Add the following service providers to ``configs/app.php``.
.. code::

     'NukaCode\Materialize\BootstrapServiceProvider',
     'NukaCode\Materialize\Html\HtmlServiceProvider',

Themes
------------------------------------
Bower
~~~~~~~
.. hint:: You only need to have one of these.

.. code::

    bower install -S nukacode-bootstrap-base#~0
    bower install -S nukacode-bootstrap-dark#~0
Resources
~~~~~~~~~
app.less
^^^^^^^^
At the top of ``resources/assets/less/app.less`` add the line below that matches your theme.  Make sure this is first line of that file.

.. code:: css

    @import '../../../vendor/bower_components/nukacode-bootstrap-base/less/base';
    @import '../../../vendor/bower_components/nukacode-bootstrap-dark/less/dark';

colors.less
^^^^^^^^
Create a file in ``resources/assets/less/`` called colors.less.  This file is used to quickly set some of the main
variables of the theme.  You can of course overload any other standard bootstrap variables as you like in this file as
well.

.. code:: css

    @bg:                #343838;
    @gray:              #343838;
    @brand-primary:     #6fba3b;
    @brand-info:        #3b81ba;
    @brand-success:     #62c462;
    @brand-warning:     #c09853;
    @brand-danger:      #ba403b;
    @menuColor:         #4e8329;

    @gray-darker:       lighten(@gray, 13.5%);
    @gray-dark:         lighten(@gray, 20%);
    @gray-light:        lighten(@gray, 60%);
    @gray-lighter:      lighten(@gray, 93.5%);
    @darkPrimary:       darken(@brand-primary, 15%);
    @darkerPrimary:     darken(@brand-primary, 30%);
    @darkInfo:          darken(@brand-info, 15%);
    @darkSuccess:       darken(@brand-success, 15%);
    @darkWarning:       darken(@brand-warning, 15%);
    @darkError:         darken(@brand-danger, 15%);
    @body-bg:           @bg;