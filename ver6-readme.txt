/*Flyspeck 6 Installation Instructions*/


YOU CAN ALWAYS CHECK THE WIKI DOCUMENTATION AT :

http://www.flyspeck.net/technical_info/qwikiwiki/

Intro:
Flyspeck is a php script designed to do one thing:  Allow non technical users to edit parts of a web page
in their browser without any installed software anywhere in the world.  This script edits regular HTML, SHTML or PHP files, it
does not need a database.

I built this because I very frequently want the ability to build a site, and hand off the mundane editing to the content
owners.  Frontpage is overkill, expensive, and in the hands of someone that is not very knowledgable, can be a headache.


Requirements:

 - PHP 4.3 or higher running on your web server, can be UNIX or Windows.
 - Client must have a modern browser IE5.5+, Mozilla, Firefox, works on many MAC or Windows modern era browsers.


Installation Steps:

1.) Unzip the file flyspeck.zip on your hard drive.

Simply upload the whole unzipped directory via ftp to your web root, or wherever it is convienent.
I have set the default settings to be on the web root (/flyspeck/).  See the additional instructions within if you wish
to put the dir somewhere else within the web root (like a /scripts/ dir).

2.) Open the file config.php and paste your domain key that was emailed to you on line 2.  You want it to look like:

$domain_key = "the-code-I-sent-you-pasted-here";

3.) Go to your browser and bring up http://yoursite.com/flyspeck/install.php

This will run some file permission checks, and let you know if you have to chmod the database files, or
your site files.  Most often, you will need to open ftp and chmod some files.

Files that are to be editable need to have permissions of 666 or higher (depending on config).  I like to start at default,
and then work my way up (to crack the permissions open to BARE minimum).  777 may be required in some configs.

You might have to chmod /data/flyspeck/users.txt and roles.txt - the two database files.


3.) Test to ensure the script is working by going to

http://www.yoursite.com/flyspeck/examples/whole_page.html

 ****Login as admin / admin to start ****

4.) If you receive an error message "Unable to open file", you may need to adjust your $docroot variable located in config.php.
All the script needs is what is known as the Document Root, or the server's path to the website root.  This can vary on unix machines,
but on windows machines it is probably C:\apache\htdocs\ .  There is a test file that can help you determine this:

http://www.yoursite.com/flyspeck/index.php?event=info

If you need help, contact Support at support@flyspeck.net.

/*Instructions for making pages editable*/

EACH PAGE you wish to make editable needs the following pieces:

1.) Put this line in the head:

<script src="/flyspeck/trigger.js" id="flytrig"></script>

1.) Paste this line BEFORE the start of the editable area:

<!-- #BeginEdit "0" -->

2.)  Paste this line AFTER the end of the editable area:

<!-- #EndEdit -->

3.)  Decide how you want to do the "edit switch" or, how will the end user go into
edit mode.

<a id="flyspecktrigger" href="javascript:switchMenu()">Flyspeck Editing Trigger</a>

The only requirements are, that it has an id of "flyspecktrigger" and fires the switchMenu javascript. Can be any element on your page!




NOTICE:  The number 0 in the <!-- #BeginEdit "0" --> is the unique indentifer for this piece of content.

For example, I like to just sequentially number each editable area, so a complete page looks like this:


 <html>
 <head>
 <script src="/flyspeck/trigger.js" id="flytrig"></script>
 </head>

 <body>
<!-- #BeginEdit "0" -->

<p>This is the FIRST editable area</p>

<!-- #EndEdit -->

<!-- #BeginEdit "1" -->

<p>This is the SECOND editable area</p>

<!-- #EndEdit -->
<a id="flyspecktrigger" href="javascript:switchMenu()">Flyspeck Editing Trigger</a>

</body>
</html>

You can copy the above HTML into a new file if you wish to create a new empty file ready for Flyspeck!


/* Security / Password */

Login as admin / admin , you must have one admin user.  You can add user accounts and assign them to ROLES, which are simply a name for a set of directories
that you want them to edit. You can expose more than one level deep by looking in the config.php.  I like to keep it simple and top level.


/* Other Config Settings */

In the config.php:



define("DEFAULT_DOCUMENT", "index.html");

Set this to the sites default index document i.e. index.html, default.htm etc.  Whatever your web server defaults to if a directory
is chosen in the url like http://site.com/directory/


Check config.php for many additional settings.


/*Support */

Contact support@flyspeck.net


/*Refunds */

I will return your payment in full within 60 days of purchase if you are not satisfied.
