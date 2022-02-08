<?php 
/**
 * The Dealsector Shortcodes Class
 *
 * @package Dealsector
 */

    class DealsectorShortcode {

        public function dealsector_sc_locationphone($atts = [], $content = null, $tag = ''){
            ob_start();
            global $dealsector_locationphone_attr;
            $dealsector_locationphone_attr["atts"] = $atts;
            Dealsector::dealsector_get_template_part("shortcode","location-phone");
            return ob_get_clean();
        }
      
        public function dealsector_sc_inventorys($atts = [], $content = null, $tag = ''){
            ob_start();
            global $dealsector_inventorys_attr;
            $dealsector_inventorys_attr["atts"] = $atts;
            Dealsector::dealsector_get_template_part("shortcode","inventorys");
            return ob_get_clean();
        }

        public function dealsector_sc_filter($atts = [], $content = null, $tag = ''){
            ob_start();
            global $dealsector_filter_attr;
            $dealsector_filter_attr["atts"] = $atts;
            Dealsector::dealsector_get_template_part("shortcode","filter");
            return ob_get_clean();
        }

        public function dealsector_sc_pagination($atts = [], $content = null, $tag = ''){
            ob_start();
            global $dealsector_pagination_attr;
            $dealsector_pagination_attr["atts"] = $atts;

            Dealsector::dealsector_get_template_part("shortcode","pagination");
            return ob_get_clean();
        }

        public function dealsector_sc_viewdetail($atts = [], $content = null, $tag = ''){
            ob_start();
            global $dealsector_viewdetail_attr;
            $dealsector_viewdetail_attr["atts"] = $atts;
            Dealsector::dealsector_get_template_part("shortcode","view-detail");
            return ob_get_clean();
        }
		
		public function dealsector_sc_printdetail($atts = [], $content = null, $tag = ''){
            ob_start();
            global $dealsector_printdetail_attr;
            $dealsector_printdetail_attr["atts"] = $atts;
            Dealsector::dealsector_get_template_part("shortcode","print-detail");
            return ob_get_clean();
        }

        
        public function dealsector_sc_featuredinventorys($atts = [], $content = null, $tag = ''){
            ob_start();
            global $dealsector_featuredinv_attr;
            $dealsector_featuredinv_attr["atts"] = $atts;
		    Dealsector::dealsector_get_template_part("shortcode","featured-inventory");
            return ob_get_clean();
        }
		
	  	public function dealsector_sc_financelink($atts = [], $content = null, $tag = ''){
            ob_start();
            Dealsector::dealsector_get_template_part("shortcode","finance-link");
            return ob_get_clean();
        }
        
        public function dealsector_sc_similarproducts($atts = [], $content = null, $tag = ''){
            ob_start();
            Dealsector::dealsector_get_template_part("shortcode","similar-products");
            return ob_get_clean();
        }

        public function dealsector_sc_preowninventorys($atts = [], $content = null, $tag = ''){
            ob_start();
            global $dealsector_preowninv_attr;
            $dealsector_preowninv_attr["atts"] = $atts;
            Dealsector::dealsector_get_template_part("shortcode","preown-inventory");
            return ob_get_clean();
        }

        public function dealsector_sc_locationinventorys($atts = [], $content = null, $tag = ''){
            ob_start();
            global $dealsector_locationinv_attr;
            $dealsector_locationinv_attr["atts"] = $atts;
            Dealsector::dealsector_get_template_part("shortcode","location-inventorys");
            return ob_get_clean();
        }

		public function wpc_elementor_shortcode( $atts ) {
            echo "<table><tbody><tr><td>Length:</td><td>20'</td></tr><tr><td>Width:</td><td>8'</td></tr><tr><td>Color:</td><td>Varius</td></tr><tr><td>Special Features:</td><td>Features Summary</td></tr></tbody></table>";
        }
}
    $DealsectorShortcode = new DealsectorShortcode();
    add_shortcode( 'dealsector_locationphone', array( $DealsectorShortcode, 'dealsector_sc_locationphone' ) );
    add_shortcode( 'dealsector_inventorys', array( $DealsectorShortcode, 'dealsector_sc_inventorys' ) );
    add_shortcode( 'dealsector_filter', array( $DealsectorShortcode, 'dealsector_sc_filter' ) );
    add_shortcode( 'dealsector_pagination', array( $DealsectorShortcode, 'dealsector_sc_pagination' ) );
    add_shortcode( 'dealsector_viewdetail', array( $DealsectorShortcode, 'dealsector_sc_viewdetail' ) );
    add_shortcode( 'dealsector_printdetail', array( $DealsectorShortcode, 'dealsector_sc_printdetail' ) );
    add_shortcode( 'dealsector_featuredinventorys', array( $DealsectorShortcode, 'dealsector_sc_featuredinventorys' ) );
    add_shortcode( 'dealsector_financelink', array( $DealsectorShortcode, 'dealsector_sc_financelink' ) );
    add_shortcode( 'dealsector_similar_products', array( $DealsectorShortcode, 'dealsector_sc_similarproducts' ) );
    add_shortcode( 'dealsector_preowninventorys', array( $DealsectorShortcode, 'dealsector_sc_preowninventorys' ) );
    add_shortcode( 'dealsector_locationinventorys', array( $DealsectorShortcode, 'dealsector_sc_locationinventorys' ) );
    add_shortcode( 'my_elementor_php_output', 'wpc_elementor_shortcode');
    
?>