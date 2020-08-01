# Hub Server

The Hub Server is a community portal for sharing single file resources for QGIS. It requires minimum effort to share files, and is simple to browse and download the resources to your personal QGIS installation.

To setup the server you will need a 'LAMP' server (Linux, Apache, MySQL, PHP) or equivalent. There's a separate instruction for how you can setup a server on Ubuntu Linux further down.

The Source you will use on your server is located in the "source" folder.

There's also instructions for how the database and tables should be setup.

## Setup Server

[Setup instructions](https://github.com/style-hub/hub-server/blob/master/setup-server.md)

__TODO: Database Setup__

## Project goals

Build a web site with hubs that manage community contributed files for style, layout and maybe more.

The goal is to create a site that requires very little from the contributor and makes it as effortless at possible to download and use the resources.

Simple to search or browse, preview and download. Form based user contributions with minimal work required.

## Project todo list

* Structure!
* Contributor input (table rows)
  * Style Name, styleName, Text
  * Style Description, styleDescription, Text
  * Contributor Name, contributorName, Text
  * Style Preview, stylePreview, Text/url (image uploaded to server ./images)
  * Style XML, styleXml, Text/url (file uploaded to server ./resources)
  * Probably a lot more columns like date/time, approval, category, etc...
* Upload form and scripts
* Landing site
* Filter and search

## Why not use the Resource Sharing Plugin?

This is NOT a replacement for the plugin. But it is a way to significantly lower the bar for the majority of ordinary users to contribute, but also find and download the resources. Some resources is definitely not suitable to manage with a "hub" site. And the resources on a hub could easily be pulled to a resource sharing repository and shared that way too.

## Contribute to the project

You can fork and create pull requests as usual for a GitHub project.

If you want to engage more you can become a developer with direct commit rights.

(But in that case I guess we need to create more guidelines for the goal of the project.)
