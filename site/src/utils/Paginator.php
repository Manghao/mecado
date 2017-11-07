<?php

namespace Mecado\Utils;

/**
 * Class Paginator
 * Permet la pagination
 * @package Mecado\Utils
 */
class Paginator
{

    /**
     * Permet de retourner un tableau de pagination
     * @param $perPage
     * @param $total
     * @param $currentPage
     * @return array
     */
    public static function paginate($perPage, $total, $currentPage) {
        $pagination = [
            'currentPage' => (!is_null($currentPage) ? $currentPage : 1),
            'lastPage' => ((ceil($total / $perPage) == 0) ? 1 : ceil($total / $perPage))
        ];
        return $pagination;
    }

}