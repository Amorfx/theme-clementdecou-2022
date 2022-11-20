<?php

namespace Theme2022\Utils;

class AcfUtils {
    public static function getRepeaterOption($field) {
        global $wpdb;
        $results = $wpdb->get_results('SELECT option_name, option_value FROM ' . $wpdb->prefix . 'options WHERE option_name LIKE "options_' . $field . '_%"');
        $data = array();
        $prefixGroups = "options_" . $field . '_';
        foreach ($results as $key => $result) {
            $key = explode($prefixGroups, $result->option_name);
            $keyLastItem = explode('_', $key[1]);
            $itemNumber = $keyLastItem[0];
            $nameOption = str_replace($itemNumber . '_', '', $key[1]);
            $data[$itemNumber][$nameOption] = $result->option_value;
        }
        return $data;
    }

    /**
     * Helper function to optimize limit sql queries
     *
     * @param $fieldName
     * @param $postId
     *
     * @return array|bool fields
     */
    public static function getAcfRepeaterFields($fieldName, $postId) {
        global $wpdb;

        $fields = $wpdb->get_results($wpdb->prepare("SELECT meta_key,meta_value FROM $wpdb->postmeta WHERE post_id=$postId AND meta_key like '{$fieldName}_%' order by meta_key asc"));

        if (empty($fields)) {
            return false;
        }

        $data = array();
        foreach ($fields as $key => $result) {
            $x = explode('_', explode($fieldName . '_', $result->meta_key)[1]); //double explode (aaa_n_bbb) => (number = n , name = bbb, $fieldName = aaa)
            $number = $x[0];
            $name = $x[1];
            $data[$number][$name] = $result->meta_value;
        }
        return $data;
    }
}
