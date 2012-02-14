<?php
class IndexController extends Simple_Controller
{
    public function IndexAction()
    {
        echo $this->response->url(array("index" , "index" , "index" , array("id" => 123 , "b" => 'abc') , array('c' => 1)));
        exit();
    }
    public function ShoppingAction()
    {
        
        Simple_Tool_Page::$subpage_link_s = array("index" , "index" , "shopping");
        Simple_Tool_Page::$response_s = $this->response;
        Simple_Tool_Page::$current_page_s = $this->request->get('page');
        Simple_Tool_Page::$nums_s = Imagewalls::getCount();
        $limit = Simple_Tool_Page::getPageController();
        $where = "1=1 ";
        $where .= $limit;
        $imagewalls = Imagewalls::getByAll($where);
        $this->response->imagewalls = $imagewalls;
        $this->response->pagehtml = Simple_Tool_Page::$page_html;
    }
    public function HeaderAction()
    {}
//    public function getjpegsize($img_loc) {
//    $handle = fopen($img_loc, "rb") or die("Invalid file stream.");
//    $new_block = NULL;
//    if(!feof($handle)) {
//        $new_block = fread($handle, 32);
//        $i = 0;
//        if($new_block[$i]=="\xFF" && $new_block[$i+1]=="\xD8" && $new_block[$i+2]=="\xFF" && $new_block[$i+3]=="\xE0") {
//            $i += 4;
//            if($new_block[$i+2]=="\x4A" && $new_block[$i+3]=="\x46" && $new_block[$i+4]=="\x49" && $new_block[$i+5]=="\x46" && $new_block[$i+6]=="\x00") {
//                // Read block size and skip ahead to begin cycling through blocks in search of SOF marker
//                $block_size = unpack("H*", $new_block[$i] . $new_block[$i+1]);
//                $block_size = hexdec($block_size[1]);
//                while(!feof($handle)) {
//                    $i += $block_size;
//                    $new_block .= fread($handle, $block_size);
//                    if($new_block[$i]=="\xFF") {
//                        // New block detected, check for SOF marker
//                        $sof_marker = array("\xC0", "\xC1", "\xC2", "\xC3", "\xC5", "\xC6", "\xC7", "\xC8", "\xC9", "\xCA", "\xCB", "\xCD", "\xCE", "\xCF");
//                        if(in_array($new_block[$i+1], $sof_marker)) {
//                            // SOF marker detected. Width and height information is contained in bytes 4-7 after this byte.
//                            $size_data = $new_block[$i+2] . $new_block[$i+3] . $new_block[$i+4] . $new_block[$i+5] . $new_block[$i+6] . $new_block[$i+7] . $new_block[$i+8];
//                            $unpacked = unpack("H*", $size_data);
//                            $unpacked = $unpacked[1];
//                            $height = hexdec($unpacked[6] . $unpacked[7] . $unpacked[8] . $unpacked[9]);
//                            $width = hexdec($unpacked[10] . $unpacked[11] . $unpacked[12] . $unpacked[13]);
//                            return array($width, $height);
//                        } else {
//                            // Skip block marker and read block size
//                            $i += 2;
//                            $block_size = unpack("H*", $new_block[$i] . $new_block[$i+1]);
//                            $block_size = hexdec($block_size[1]);
//                        }
//                    } else {
//                        return FALSE;
//                    }
//                }
//            }
//        }
//    }
//    return FALSE;
//}
}