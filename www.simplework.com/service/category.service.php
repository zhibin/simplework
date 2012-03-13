<?php
class categoryService
{
    public static function add($fid, $name)
    {
        if (empty($name)) {
            throw new Simple_Exception("category name not empty", 1);
        }
        if ($fid == 0) {
            $ffid = 0;
        } else {
            $category = Categorys::getById($fid);
            if ($category->isEmpty()) {
                throw new Simple_Exception("category fid not exists", 2);
            }
            $ffid = $category->ffid;
            if (empty($ffid)) {
                $ffid = $category->id;
            }
        }
        $row['name'] = $name;
        $row['fid'] = $fid;
        $row['ffid'] = $ffid;
        Categorys::createBy($row);
    }
    public static function show($fid = 0, $style = "option", $selectid = 0, $level = 0, $str = '')
    {
        $categorys = Categorys::getByFid($fid);
        if (! empty($categorys)) {
            $level ++;
            foreach ($categorys as $k => $category) {
                switch ($style) {
                    case "option":
                        $str = self::option_sytle($category, $level, $str, $selectid);
                        break;
                    case "tr":
                        $str = self::tr_sytle($category, $level, $str);
                        break;
                }
                $str = self::show($category->id, $style, $selectid, $level, $str);
            }
        }
        return $str;
    }
    private static function tr_sytle($category, $level, $str)
    {
        $response = Simple_Front::getInstance()->response;
        $g = "";
        for ($j = 0; $j < $level; $j ++) {
            if ($j == $level - 1)
                $g .= "|-"; else
                $g .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        $str .= "<tr>";
        $str .= "<td>" . $category->id . "</td>";
        $str .= "<td>" . $g . $category->name . "</td>";
        $str .= "<td>" . $category->ctime() . "</td>";
        $str .= "<td><a href='" . $response->url(array("admin" , "category" , "modify")) . "'>编辑</a></td>";
        $str .= "</tr>";
        return $str;
    }
    public static function option_sytle($category, $level, $str, $selectid = 0)
    {
        $g = "";
        if ($selectid == $category->id) {
            $select = "selected";
        } else {
            $select = "";
        }
        $str .= "<option  $select ";
        $str .= " value=\"" . $category->id . "\">";
        for ($j = 0; $j < $level; $j ++) {
            if ($j == $level - 1)
                $g .= "|-"; else
                $g .= "&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        $str .= $g . $category->name;
        $str .= "</option>";
        return $str;
    }
}
?>