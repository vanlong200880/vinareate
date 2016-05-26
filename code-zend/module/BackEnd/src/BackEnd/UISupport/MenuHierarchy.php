<?php
namespace BackEnd\UISupport;

class MenuHierarchy{

    static $tmp = array();

    static function showMenu($postFeature){
    }

    /*
 * Hàm hiển thị danh sách menu dạng list
 * Tham số truyền vào:
 *  - $menus: danh sách menu
 *  - $id_parent: mặc định, không cần truyền vào
 */
    static function showMenuLi($menus, $id_parent = 0){
        # BƯỚC 1: LỌC DANH SÁCH MENU VÀ CHỌN RA NHỮNG MENU CÓ ID_PARENT = $id_parent

        // Biến lưu menu lặp ở bước đệ quy này
        $menu_tmp = array();

        foreach($menus as $i => $item){
            // Nếu có parent_id bằng với parrent id hiện tại
            if((int)$item['parent'] == $id_parent){
                $menu_tmp[] = $item;
                // Sau khi thêm vào biên lưu trữ menu ở bước lặp
                // thì unset nó ra khỏi danh sách menu ở các bước tiếp theo
                unset($menus[$i]);
            }
        }

        # BƯỚC 2: lẶP MENU THEO DANH SÁCH MENU Ở BƯỚC 1

        // Điều kiện dừng của đệ quy là cho tới khi menu không còn nữa
        if($menu_tmp){
            foreach($menu_tmp as $item){
                echo '<div style="padding-left: 50px">';
                echo '<form method="POST" action="/backend/deep-feature/match">
                    <input type="hidden" name="featureId" value="' . $item["id"] . '">
                    <input type="submit" name="action" value="edit" class="btn btn-default">
                    <input type="submit" name="action" value="delete" class="btn btn-default">
                </form>';
                echo '<table border = "0" class="table" >
                            <tr >
                                <td > ' . $item['name'] . ' </td >
                                <td > ' . $item['description'] . ' </td >
                                <td > ' . $item['menu_order'] . ' </td >
                                <td > ' . $item['parent'] . ' </td >
                                <td > ' . $item['status'] . ' </td >
                            </tr >
                        </table >';
                self::showMenuLi($menus, $item['id']);
                echo '</div > ';
            }
        }
    }

    static function show($menus, $idParent = 0, $cbForeach){
        $closure = function(){
        };
        $cbForeach = ($cbForeach == null)? $closure : $cbForeach;
        //        $cbItem = ($cbForeach == null)? $closure : $cbItem;
        $menu_tmp = array();
        foreach($menus as $i => $item){
            if((int)$item['parent'] == $idParent){
                $menu_tmp[] = $item;
                unset($menus[$i]);
            }
        }
        if($menu_tmp){
            foreach($menu_tmp as $item){
                echo '<div class="parentDiv">';
                $cbForeach($item);
                echo '<div class="childrenDiv">';
                self::show($menus, $item['id'], $cbForeach);
                echo '</div>';
                echo '</div>';
            }
        }
    }

    static function reArrange($menus, $idParent = 0, $count = 1, $hasChild = false){
        self::$tmp = array();
        self::reArrangeLoop($menus, $idParent, $count, $hasChild);
        return self::$tmp;
    }

    static function reArrangeLoop($menus, $idParent = 0, $count = 1, $hasChild = false){
        foreach($menus as $i => $item){
            if($item["parent"] == $idParent){
                $hasChild = true;
                $item["class"] = "level-" . $count;
                $ref = &self::$tmp[];
                $ref = $item;
//                self::$tmp[] = $item;
                unset($menus[$i]);
                //call tiep de tim ra may thang con cua no
                $xyz = self::reArrangeLoop($menus, $item["value"], ($count + 1), false);
                if($xyz){
                    $ref["disabled"] = true;
                }
            }
        }
        return $hasChild;
    }
}