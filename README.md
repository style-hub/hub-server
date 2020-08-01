# Hub Server

The Hub Server is a community portal for sharing single file resources for QGIS. It requires minimum effort to share files, and is simple to browse and download the resources to your personal QGIS installation.

To setup the server you will need a 'LAMP' server (Linux, Apache, MySQL, PHP) or equivalent. There's a separate instruction for how you can setup a server on Ubuntu Linux further down.

The code you will use on your server (/var/www/hub/) is located in the "source" folder.

## Setup Server

For the development a standard database user is used.

User: _user_

Password: _1#Password_

[Setup server instructions](https://github.com/style-hub/hub-server/blob/master/setup-server.md)

To create tables in the database, use the _mysql_setup.sql_ script.

'''
mysql -u user -p < mysql_setup.sql
'''

Note that uploads of files to the server only works if the folders are set with sufficient permissions to "write". __(Warning)__

## Project goals

Build a web site with hubs that manage community contributed files for style, layout and maybe more.

The goal is to create a site that requires very little from the contributor and makes it as effortless at possible to download and use the resources.

Simple to search or browse, preview and download. Form based user contributions with minimal work required.

There will likely be a need for some contributor verification, but it should be kept at a minimum.

## Project todo list

* Project Structure!  
  * Style guides?
  * Desigh guides? (How should the code look)
* Landing site 
  * Multiple hubs
  * Similar content and use
  * One place to land and get instructions
* Filter and search using PHP
  * Probably also database table expansion
* When most is working with the "Style Hub", start on "Layout Hub"

## Why not use the Resource Sharing Plugin?

This is NOT a replacement for the plugin. But it is a way to significantly lower the bar for the majority of ordinary users to contribute, but also find and download the resources. Some resources is definitely not suitable to manage with a "hub" site. And the resources on a hub could easily be pulled to a resource sharing repository and shared that way too.

## Contribute to the project

You can fork and create pull requests as usual for a GitHub project.

If you want to engage more you can become a developer with direct commit rights.

(But in that case I guess we need to create more guidelines for the goal of the project.)
