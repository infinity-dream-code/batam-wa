<?php

namespace App\Models\ViewComponent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    public static function btnPageShow($link, $name): string
    {
        return '<a href="' . $link . '" class="btn btn-primary" title="'.$link.'">
                    <i class="ki-duotone ki-document fs-2x me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <span class="d-none d-md-inline">&nbsp;' . $name . '</span>
                </a>';
    }

    public static function btnPageEdit($link, $name): string
    {
        return '<a href="' . $link . '" class="btn btn-warning"><i class="ti ti-edit"></i><span class="d-none d-md-inline">&nbsp;' . $name . '</span></a>';
    }

    public static function btnPageDelete($link, $name): string
    {
        return '<a href="' . $link . '" class="btn btn-danger"><i class="ti ti-trash-x"></i><span class="d-none d-md-inline">&nbsp;' . $name . '</span></a>';
    }

    public static function btnPageCreate($link, $name): string
    {
        return '<a href="' . $link . '" class="btn btn-primary"><i class="ti ti-plus"></i><span class="d-none d-md-inline">&nbsp;' . $name . '</span></a>';
    }

    public static function btnModalCreate($data, $name): string
    {
        return '<button data-val="' . $data . '" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create"><i class="ti ti-plus"></i><span class="d-none d-md-inline">&nbsp;' . $name . '</span></button>';
    }

    public static function btnModalShow($data, $name): string
    {
        return '<button data-val="' . $data . '" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-show"><i class="ti ti-list-details"></i><span class="d-none d-md-inline">&nbsp;' . $name . '</span></button>';
    }

    public static function btnModalEdit($data, $name): string
    {
        return '<button data-val="' . $data . '" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit"><i class="ti ti-edit"></i><span class="d-none d-md-inline">&nbsp;' . $name . '</span></button>';
    }

    public static function btnModalDelete($data, $name): string
    {
        return '<button data-val="' . $data . '" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete"><i class="ti ti-trash-x"></i><span class="d-none d-md-inline">&nbsp;' . $name . '</span></button>';
    }

    public static function btnDownload($url, $name): string
    {
        return '<a href="' . $url . '" class="btn btn-ghost-primary btn-download"><i class="ti ti-download icon"></i><span class="d-none d-md-inline">&nbsp;' . $name . '</span></button>';
    }

    public static function btnAjaxDownload($url, $filename,$name): string
    {
        return '<button data-url="' . $url . '" data-filename="'.$filename.'" class="btn btn-ghost-primary btn-ajax-download"><i class="ti ti-download icon"></i><span class="d-none d-md-inline">&nbsp;' . $name . '</span></button>';
    }


}
