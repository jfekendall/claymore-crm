claymore
========

This is a modular CRM system that is supposed to be flexible and efficient for the user.

Specific business processes will not be taken into account and left to the company adopting this software to decide what is best for them

TODO
----

* Core functionality
* Templating System
* Client/Contact Management
* Support Ticketing
* Multiple database vendor support and configuration
* A setup feature for initial install

Conventions of Coding
---------------------

Code is to be Object-oriented whenever possible.

_NO_ in-line styles. Real estate in css files is cheap.

Each class or file needs to have a setup() function or method associated with it. This function or method will handle the process of modifying the user's database or folder permissions in order to make the accompanying section function.

All code used that is from someone outside of the project is to be attributed.


