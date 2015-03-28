<?php
/*
 * ZBZ5 Simple Localizing Tool V1.0
 *
 * This class is made to ease the task of localizing PHP applications
 * on servers where GetText is not installed
 *
 * Copyright (C) 2005  Vidar Løvbrekke Sømme <olegu.rasputin@gmail.com> (http://www.zbz5.net)
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */




/*
 * The following constants can be redefined to suit your needs, and moved to
 * your settings file if you want.
 */

/*
 * Where your language files are located
 */
define(ZBZ5_LANGUAGE_DIR, 'includes/languages');

/*
 * The "language code" of your fallback locale default to en_EN (enlgish)
 */
define(ZBZ5_FALLBACK_LOCALE, 'en_EN');

/*
 * The symbol that is used to separate elements of your language files to
 * indentify them (LanguageCode[divider]whateveryouwanttonameyourfile,
 * i.e: no_NB.adminstrings
 */
define(ZBZ5_DIVIDER, '.');

/*
 * The perl style regex search string used to identify key->value language
 * pairs in your language files (basically it defines the syntax the language files)
 * currently it is setup to find this:
 *
 * Line1 optional comment line
 * Line2 key string
 * Line3 translated value string
 */
define(ZBZ5_SEARCHSTRING, '/(?:\S.*\n)?(\S.*)\n(\S.*)\n/i');


class zbz5Localizer{
  /*
   * Array that holds the key => value pairs from the language files of the
   * current selected locale
   */
  var $current_locale_array = array();
  /*
   * Array that holds the key => value pairs from the language files of the
   * fallbakc locale
   */
  var $fallback_locale_array = array();


  /*
   * Constructor function that reads the language files in the language
   * directory, and inerpent them into key => value pairs of the
   * $this->current_locale_array and $this->fallback_locale_array
   *
   * @param     string  $current_locale_code the code identifying the language files
   *                    of the selected locale
   *
   */
  function zbz5Localizer($current_locale_code) {
    /*
     * Read the language directory
     */
    $dirhandle = opendir(ZBZ5_LANGUAGE_DIR);
    while (false !== ($filename = readdir($dirhandle))) {
      if (is_file(ZBZ5_LANGUAGE_DIR . '/' . $filename)) {
        $files[] = $filename;
      }
    }
    closedir($dirhandle);
    if (!is_array($files)) {
      return false;
    }

    /*
     * Filter out the language files for the current and fallback locale
     */
    foreach ($files as $languagefile) {
      $pieces = explode(ZBZ5_DIVIDER, $languagefile);
      if ($pieces[0] == $current_locale_code) {
        $current_locale_files[] = ZBZ5_LANGUAGE_DIR . '/' . $languagefile;
      }
      if ($pieces[0] == ZBZ5_FALLBACK_LOCALE) {
        $fallback_locale_files[] = ZBZ5_LANGUAGE_DIR . '/' . $languagefile;
      }
    }

    /*
     * Read language files from the current locale into the
     * $this->current_locale_array as key => value pairs
     */
    if (is_array($current_locale_files)) {
      foreach ($current_locale_files as $current_locale_file) {
        $filestring = file_get_contents($current_locale_file);
        preg_match_all(ZBZ5_SEARCHSTRING, $filestring, $searchresult, PREG_SET_ORDER);
        if (is_array($searchresult)) {
          foreach ($searchresult as $resultrow) {
            $key = trim($resultrow[1]);
            $value = trim($resultrow[2]);
            $this->current_locale_array[$key] = $value;
          }
        }
      }
    }

    /*
     * Read language files from the fallback locale into the
     * $this->fallback_locale_array as key => value pairs
     */
    if (is_array($fallback_locale_files)) {
      foreach ($fallback_locale_files as $fallback_locale_file) {
        $filestring = file_get_contents($fallback_locale_file);
        preg_match_all(ZBZ5_SEARCHSTRING, $filestring, $searchresult, PREG_SET_ORDER);
        if (is_array($searchresult)) {
          foreach ($searchresult as $resultrow) {
            $key = trim($resultrow[1]);
            $value = trim($resultrow[2]);
            $this->fallback_locale_array[$key] = $value;
          }
        }
      }
    }
  }

 /*
  * Returns a translated and formatted string iaw with the arguments given
  *
  * @param  string      $original string    the string to look up, translate, format and return
  *
  * @param  anything    any other parameters assigned to this function will be interpeted as
  *         sprintf()   ariables to format into the string. I.e calling the function like
  *         can take    this: $object->zbz5('There are %s apples', five) will return:
  *                     'There are five apples'.  See the php manual on sprintf for detailed
  *                     info on string formatting and variables.
  *
  * @return string      the translated and formated string
  */
  function zbz5($original_string) {
    $variables_to_be_encoded = array();
    $number_of_arguments = func_num_args();
    if ($number_of_arguments > 1) {
      $variables_to_be_encoded = func_get_args();
      unset($variables_to_be_encoded[0]);
    }
    $original_string = trim($original_string);
    if (array_key_exists($original_string, $this->current_locale_array)) {
      $localized_string = $this->current_locale_array[$original_string];
    } elseif (array_key_exists($original_string, $this->fallback_locale_array)) {
      $localized_string = $this->fallback_locale_array[$original_string];
    } else {
      $localized_string = $original_string;
    }
    $formated_string = vsprintf($localized_string, $variables_to_be_encoded);
    return $formated_string;
  }
}
