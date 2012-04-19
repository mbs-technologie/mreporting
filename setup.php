<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 Mreporting plugin for GLPI
 Copyright (C) 2003-2011 by the mreporting Development Team.

 https://forge.indepnet.net/projects/mreporting
 -------------------------------------------------------------------------

 LICENSE

 This file is part of mreporting.

 mreporting is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 mreporting is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with mreporting. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
 
// Init the hooks of the plugins -Needed
function plugin_init_mreporting() {
   global $PLUGIN_HOOKS;

   if (Session::getLoginUserID()) {
         
      Plugin::registerClass('PluginMreportingProfile',
                      array('addtabon' => 'Profile'));
                                    
      if (!Session::haveRight('config', 'w')
       ||
         isset($_SESSION['glpi_plugin_mreporting_profile'])
         && $_SESSION['glpi_plugin_mreporting_profile']['reports'] == ''
      ) $menu_entry  = false;
      else $menu_entry = "front/central.php";

      $PLUGIN_HOOKS['menu_entry']['mreporting'] = $menu_entry;

      $PLUGIN_HOOKS['change_profile']['mreporting'] = array('PluginMreportingProfile',
                                                                        'changeProfile');


      /*$mreporting_common = new PluginMreportingCommon;
      $reports = $mreporting_common->getAllReports();
      if ($reports !== false) {
         foreach($reports as $report) {
            foreach($report['functions'] as $function) {
               $PLUGIN_HOOKS['stats']['mreporting'][$function['min_url_graph']] = $function['title'];
            }
         }
      }*/
      
      if($_SESSION['glpi_use_mode'] = Session::DEBUG_MODE) {
         define('DEBUG_MREPORTING', false);
      } else {
         define('DEBUG_MREPORTING', false);
      }
   }
   
   if (class_exists('PluginMreportingProfile')) { // only if plugin activated
      $PLUGIN_HOOKS['pre_item_purge']['mreporting'] 
                     = array('Profile'=>array('PluginMreportingProfile', 'purgeProfiles'));
   }
   
   // Add specific files to add to the header : javascript or css
   $PLUGIN_HOOKS['add_javascript']['mreporting']= array ("lib/protovis/protovis-r3.2.js");
   //css 
   $PLUGIN_HOOKS['add_css']['mreporting']= array ("mreporting.css");
}

// Get the name and the version of the plugin - Needed
function plugin_version_mreporting() {
   global $LANG;

   return array('name'           => $LANG['plugin_mreporting']["name"],
                'version'        => "2.0",
                'author'         => "<a href='http://www.teclib.com'>Teclib'</a> & <a href='http://www.infotel.com'>Infotel</a>",
                'homepage'       => "https://forge.indepnet.net/projects/mreporting",
                'license' => 'GPLv2+',
                'minGlpiVersion' => "0.83");
}


// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_mreporting_check_prerequisites() {

   if (version_compare(GLPI_VERSION,'0.83','lt') || version_compare(GLPI_VERSION,'0.84','ge')) {
      echo "This plugin requires GLPI >= 0.83 and GLPI < 0.84";
   } else {
      return true;
   }
   return false;
}


// Check configuration process for plugin : need to return true if succeeded
// Can display a message only if failure and $verbose is true
function plugin_mreporting_check_config($verbose=false) {
   global $LANG;

   if (true) { // Your configuration check
      return true;
   }
   if ($verbose) {
      echo $LANG['plugins'][2];
   }
   return false;
}

?>