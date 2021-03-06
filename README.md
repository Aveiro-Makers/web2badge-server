web2badge-server
=================

Web2Badge is the first project of Hack'Aveiro. It was presented at the Mini
Maker Faire Lisbon on September 19, 2014. Web2Badge is a system that allows an
LCD badge to receive messages from the Internet, through an RF-connected
gateway.


Server
======

This repository has the code of the server component of the web2badge project.

The server has the following main functions:

  * Manage the queue of messages to be sent to the devices
  * Provide a web interface for administration and publishing manual messages
  * Poll external systems (e.g. twitter) for significant messages to be sent
  * Provide a TCP server to which the gateway(s) connect to receive the messages


Install Instructions
====================

Using Vagrant
-------------

The simplest way to configure a server is to use [Vagrant](http://vagrantup.com).
Vagrant is a development environment manager that with a single command ("vagrant up") will start your favourite virtual machine provider (e.g. Virtualbox), download Ubuntu and configure everything this project requires

Manual Install
------

If you want to do it by hand, the main things you'll need to setup are:
  * Install Apache
  * Install PHP 5.3+
  * Install [Composer](https://getcomposer.org/)
  * Setup apache virtualhost to the "web" subfolder
  * Run Composer on the project's root folder (composer update)
  * Create empty database by running "bin/web2badge.php setup-database"

Configuration
-------

After having the application installed, you should configure it, by creating
a config/config.php file based on the config/config.php.dist template.

Also, if your OS supports [Upssart](http://upstart.ubuntu.com/), you can
optionally setup the project's twitter consumer as a service by copying
config/web2badge_twitter.conf to /etc/init/ edit it (to fix base install path dir)
and then you can start it with "initctl start web2badge_twitter"

License
-------
MIT licensed.
