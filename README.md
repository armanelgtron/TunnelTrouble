Tunnel Trouble
--------------

The website for Durf's "Tunnel Trouble" Armagetron server.
It displays statitics about players who have finished maps,
with a ladder, and pages for individual maps' ranks and players.

It borrows a lot of code from racing.armanelgtron.tk with a new interface, among other changes.


### Requirements

* Something to host a web-server, such as NGINX or Apache.
* PHP >= 7.2
* PHP-JSON


### Configuration

Make a copy of `config.tmp.php` as `config.php`, and make changes to `config.php` according to your environment.

You need valid browser-accessable paths to

* jQuery
* Materialize >= 1.0.0


You can host them locally, or specify paths to CDNs. See 
https://jquery.com/download/#using-jquery-with-a-cdn
and
https://materializecss.com/getting-started.html
for more information on that.


And, of course, racing stats. Tunnel Trouble uses +ap's built-in racing, 
so the stats are expected to be stored that way.
In the future, configuration files containing the map order will also be needed,
right now it just looks for all the racing stats files and gets map information from that.
