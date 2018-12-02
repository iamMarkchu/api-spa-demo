<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/12/2
 * Time: 22:12
 */

namespace App\Helpers;


class MarkdownHelper
{
    public function generateMenus(string $markdownContent) :array
    {
        $menus = [];
        $i = -1;  // 级初始值
        $j = -1;
        $k = -1;
        $l = -1;
        $lines = explode("\n", $markdownContent);
        collect($lines)->reject(function ($line) {
            return substr($line, 0, 1) !== '#';
        })->map(function ($header) {
//            if (substr($header, 0, 4).' ' === '#### ') {
//                return [
//                    'h' => 4,
//                    'text' => rtrim(substr($header, 4)),
//                    'child' => []
//                ];
//            } else
            if (substr($header, 0, 4) === '### ') {
                return [
                    'h' => 3,
                    'text' => ltrim(substr($header, 3)),
                    'child' => []
                ];
            } elseif (substr($header, 0, 3) === '## ') {
                return [
                    'h' => 2,
                    'text' => ltrim(substr($header, 2)),
                    'child' => []
                ];
            } elseif (substr($header, 0, 2) === '# ') {
                return [
                    'h' => 1,
                    'text' => ltrim(substr($header, 1)),
                    'child' => []
                ];
            }
            return [];
        })->map(function ($headerInfo) use(&$menus,&$i,&$j,&$k,&$l) {
            if (empty($headerInfo))
                return;

            if ($headerInfo['h'] == 1) {
                $menus[++$i] = $headerInfo;
                $j = -1;
                $k = -1;
                $l = -1;
            } elseif ($headerInfo['h'] == 2) {
                $menus[$i]['child'][++$j] = $headerInfo;
                $k = -1;
                $l = -1;
            } elseif ($headerInfo['h'] == 3) {
                $menus[$i]['child'][$j]['child'][++$k] = $headerInfo;
                $l = -1;
            }
//            elseif ($headerInfo['h'] == 4) {
//                $menus[$i]['child'][$j]['child'][$k]['child'][++$l] = $headerInfo;
//            }
        });
        return $menus;
    }
}