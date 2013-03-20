<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Menampikan Javascript dari proses pemuatan Xinha WYSIWYG Editor
 *
 * @param string $textarea Merupakan Array yang menampung nama dari textarea
                           yang akan diterapkan pada xinha editor
 *
 * @param string $plugin Merupakan Array yang menampung nama dari jenis plugin
                         yang akan diterapkan pada xinha editor
 *
 * @param string $skin Merupakan nama dari jenis skin yang akan
                       diterapkan pada xinha editor
 * @return script Javascript                                       
 */
function javascript_xinha( $textarea, $plugins = array(), $skin=NULL )
{
        $obj =& get_instance();
        $base = $obj->config->slash_item('base_url');
        ob_start();
?>
 
    <script type="text/javascript">
        _editor_url  = "<?php echo $base ?>xinha/";  //Menentukan path Xinha WYSIWYG Editor
        _editor_lang = "en";   //Jenis bahasa yang diterapkan pada Xinha WYSIWYG Editor
        </script>
 
    <!—
    Bagian ini penting dan wajib di ikutsertakan
    karena berperan juga dalam proses pemuatan editor
    —>
    <script type="text/javascript" src="<?php echo $base ?>xinha/htmlarea.js"></script>
 
      <?php  
          if($skin != NULL)
          {
          ?>
              <!— Bagian ini untuk menentukan skin/tampilan dari Xinha WYSIWYG Editor —>
              <link rel="stylesheet" href="<?php echo $base ?>xinha/skins/<?php echo $skin ?>/skin.css" type="text/css">
         <?php
          }
         ?>
        <script type="text/javascript">
          xinha_editors = null;
          xinha_init = null;
          xinha_config  = null;
          xinha_plugins = null;
 
          //Bagian Utama Pendefinisian dan Pemuatan Komponen Editor       
          xinha_init = xinha_init ? xinha_init : function()
          {
 
                        /*
                          Mendefinisikan jenis-jenis plugin yang akan
                          diterapkan pada Xinha WYSIWYG editor
                        */
                        xinha_plugins = xinha_plugins ? xinha_plugins :
                        [
 
                           <?php
                           $plugin_names='';
 
                           foreach ($plugins as $plugin){
                             $plugin_names.= "'$plugin',";
                           }
 
                           $plugin_names = substr($plugin_names,0,-1);
                           echo $plugin_names;
                           ?>
                        ];
 
                         //Bagian ini akan memuat plugin yang telah didefinisikan
                         if(!HTMLArea.loadPlugins(xinha_plugins, xinha_init)) return;
 
                        /*
                          Mendefinisikan nama dari textarea yang akan
                          diterapkan pada Xinha WYSIWYG editor
                          (bisa lebih dari satu nama dan otomatis textarea
                          bisa lebih dari satu)
                         */
                        xinha_editors = xinha_editors ? xinha_editors :
                        [
 
                           <?php
                           $area='';
                           foreach ($textarea as $item){
                             $area.= "'$item',";
                           }
                           $area=substr($area,0,-1);
                           echo $area;
                           ?>
                        ];
 
                        xinha_config = xinha_config ? xinha_config() : new HTMLArea.Config();
                        xinha_config.pageStyle = 'body { font-family: verdana,arial,sans-serif; font-size: .9em; }';
                        xinha_editors = HTMLArea.makeEditors( xinha_editors, xinha_config, xinha_plugins);
 
                        HTMLArea.startEditors(xinha_editors);
          }
          window.onload = xinha_init;
        </script>
        <?php
 
        $r = ob_get_contents();
        ob_end_clean();
        return $r;
 
}
?>