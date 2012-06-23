Usage
=====

Installation
------------

Installing is a matter of downloading the scrybe.phar that is available at:

    http://www.phpdoc.org/scrybe.phar

And after that you could view what tasks are available by entering::

    $ php scrybe.phar
or::

    $ php scrybe.phar list
That exposes which output formats are currently supported. This list will be
expanded in the future when more features are implemented.

Upgrading
---------

Upgrading your installation of Scrybe is a matter of running the following
command::

    $ php scrybe.phar update
.. note:: This command is currently not shown in the command listing.

Running
-------

Scrybe is easy to use, for each output format there is a separate task.
These tasks may have specific properties so it pays to review it with the
``help`` command like this::

    $ php scrybe.phar help [command]