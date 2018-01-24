<?php

namespace App;
/**
 * Created by PhpStorm.
 * User: Vu Hai
 * Date: 1/15/2017
 * Time: 3:10 PM
 */
class ModelBase {

    /**
     * List contains error code.
     */
    var $list_error_code = array ();


    public static $validate_messages = array(
        'required' => ':attributeを入力してください。',
        "max"  => array(
            "numeric" => "The :attribute may not be greater than :max.",
            "file"    => "The :attribute may not be greater than :max kilobytes.",
            "string"  => ":attributeは:maxキャラクター以内でなければなりません。",
            "array"   => "The :attribute may not have more than :max items.",
        ),
    );

    public function get_list_error_code() {

        return $this->list_error_code;

    }

    public function set_list_error_code($list_error_code) {

        $this->list_error_code = $list_error_code;

    }

}