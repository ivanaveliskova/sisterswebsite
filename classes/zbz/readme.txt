ZBZ5 Simple Localizing Tool
Author - Vidar Løvbrekke Sømme <olegu.rasputin@gmail.com> (http://www.zbz5.net)
Copyright 2005 Vidar Løvbrekke Sømme
Licensed under the GNU Lesser General Public License v2.1

ABOUT
*******************************************
ZBZ5 Simple Localizing tool was created because I needed a localizing
tool, and my host did not have the PHP GetText modules installed.
The library was made to be as easy to use as possible, and allso have a
very simple syntax for the language files

SETUP
*******************************************
In the top of the zbz5.php file there are 4 constants that can be used to
customize and set up the localizer.

ZBZ5_LANGUAGE_DIR : the directory that contains your language files. Relative path from the file where the object is
called.  No trailing slash!

ZBZ5_FALLBACK_LOCALE : zbz5 operates with a fallback locale, if you have one locale i.e english that is 100% translated
and another locale i.e spanish that lacks a few phrases, the fallback locale will be used if the phrase can not
be found in the current locale.  The value is used to filter out the language files to use. example value: en_EN / no_NB
etc if you choose to follow the i18n naming style.  If not choose your own code, but remember to name you language
files iaw with this.

ZBZ5_DIVIDER : The symbol that is used to separate elements of your language files to  indentify them
(LanguageCode[divider]whateveryouwanttonameyourfile), i.e: no_NB.adminstrings.

ZBZ5_SEARCHSTRING : The perl style regex search string used to identify key->value language pairs in your
language files (basically it defines the syntax the language files).
currently it is setup to find this:

Line1 optional comment line
Line2 key string
Line3 translated value string

LANGUAGE FILES
*******************************************
The language files must be named iaw the language codes you choose to use.
the script uses the first segment of the filename to determine what language
the file belongs to: en_EN.adminstrings is an example where en_EN is the language
identifyer '.'(dot / punctuation) is the divider (can be changed in ZBZ5_DIVIDER) and adminstrings which is
a custom name that you can choose to your liking.

the language files have a very simple syntax.  The strings are organized like this:
Optional comment line
key line
translated value line

and that's it, nothing more, any two or three lines that are adjacent to each other will be
interpeted as (comment)key->value sections

The syntax of the language files can be changed by altering the ZBZ5_SEARCHSTRING constant.

USE
*******************************************
include the zbz5.php file in your application
create a new zbz5Localizer object with the desired locale.
use the $object->zbz5 method to translate $string

example
test.php:
<?php
include zbz5.php

$translater = new zbz5Localizer('no_NB');
print $translater->zbz5('Translate this');
//prints out 'this translated'

?>

ZBZ5 supports variables in  the string i.a.w the sprintf function in PHP:
advanced example:
advanced.php
<?php
include zbz5.php

$translater = new zbz5Localizer('no_NB');
$number_of_apples = 'five';
print $translater->zbz5('There are %s apples', $number_of_apples);
//prints out tranlated: There are five apples.

?>

NOTES
*******************************************
ZBZ5 Simple Translation too is only tested on small applications with a few (less than 1000) phrases.
It may very well be that it will fucntion on larger scales aswell, but it has not been tested.
Some sort of caching and or database backend should probably be added to the ZBZ5 code to up perfomance in such
cases.

Allso, the default searchstring of ZBZ5 does not support phrases that spans over multiple lines,
To support such long strings with linebreaks you would have to alter the ZBZ5_SEARCHSTRING constant, and
change the regex code.


