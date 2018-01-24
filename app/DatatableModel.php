<?php

namespace App;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Created by PhpStorm.
 * User: Vu Hai
 * Date: 1/15/2017
 * Time: 3:08 PM
 */

class DatatableModel extends ModelBase implements Arrayable,Jsonable{
    /** The s search. */
    var $sSearch = '';

    /** The i display start. */
    var $iDisplayStart = 0;

    /** The i display length. */
    var $iDisplayLength = 0;

    /** The i sorting cols. */
    var $iSortingCols = 0;

    /** The i sort col_0. */
    var $iSortCol_0 = 0;

    /** The s sort dir_0. */
    var $sSortDir_0 = "asc";

    /** The i total records. */
    var $iTotalRecords = "0";

    /** The i total display records. */
    var $iTotalDisplayRecords = "0";

    /** The aa data. */
    var $aaData = array();

    public function get_sSearch() {

        return $this->sSearch;

    }

    public function set_sSearch($sSearch) {

        $this->sSearch = $sSearch;

    }

    public function get_iDisplayStart() {

        return $this->iDisplayStart;

    }

    public function set_iDisplayStart($iDisplayStart) {

        $this->iDisplayStart = $iDisplayStart;

    }

    public function get_iDisplayLength() {

        return $this->iDisplayLength;

    }

    public function set_iDisplayLength($iDisplayLength) {

        $this->iDisplayLength = $iDisplayLength;

    }

    public function get_iSortingCols() {

        return $this->iSortingCols;

    }

    public function set_iSortingCols($iSortingCols) {

        $this->iSortingCols = $iSortingCols;

    }
    public function get_iSortCol_0() {

        return $this->iSortCol_0;

    }

    public function set_iSortCol_0($iSortCol_0) {

        $this->iSortCol_0 = $iSortCol_0;

    }
    public function get_sSortDir_0() {

        return $this->sSortDir_0;

    }

    public function set_sSortDir_0($sSortDir_0) {

        $this->sSortDir_0 = $sSortDir_0;

    }
    public function get_iTotalRecords() {

        return $this->iTotalRecords;

    }

    public function set_iTotalRecords($iTotalRecords) {

        $this->iTotalRecords = $iTotalRecords;

    }
    public function get_iTotalDisplayRecords() {

        return $this->iTotalDisplayRecords;

    }

    public function set_iTotalDisplayRecords($iTotalDisplayRecords) {

        $this->iTotalDisplayRecords = $iTotalDisplayRecords;

    }

    public function get_aaData() {

        return $this->aaData;

    }

    public function set_aaData($aaData) {

        $this->aaData = $aaData;

    }

    public function getDates() {
        // only this field will be converted to Carbon
        return array ('updated_at' );
    }

    /* (non-PHPdoc)
     * @see JsonableInterface::toJson()
     */
    public function toJson($options = 0) {
        // Return Json
        return json_encode ( array ("listErrorCode" => $this->get_list_error_code(),
            "sSearch" => $this->get_sSearch(),
            "iDisplayStart" => $this->get_iDisplayStart(),
            "iDisplayLength" => $this->get_iDisplayLength(),
            "iSortingCols" => $this->get_iSortingCols(),
            "iSortCol_0" => $this->get_iSortCol_0(),
            "sSortDir_0" => $this->get_sSortDir_0(),
            "iTotalRecords" => $this->get_iTotalRecords(),
            "iTotalDisplayRecords" => $this->get_iTotalDisplayRecords(),
            "aaData" => $this->get_aaData()->toArray() ) );
    }

    /* (non-PHPdoc)
     * @see ArrayableInterface::toArray()
     */
    public function toArray() {
        return "listErrorCode";
    }
}