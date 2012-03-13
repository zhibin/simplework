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
    public function ShowwallAction()
    {
        $frame = $this->request->get("frame");
        $data['html']=array(
        '<div class="i_w_f box_shadow">
			<div class="hd"></div>
			<div class="bd">
				<ul class="pic">
								<li type="goods" style="width:200px;height:200px">
					<a target="_blank" href="#">
					<img src="http://s4.mogujie.cn/b7/bao/120120/2jd99_kqyw63kxkrbgu2cugfjeg5sckzsew_310x310.jpg_200x999.jpg">
					</a>
					<span class="p">¥68</span>
					<a style="display: none;" href="javascript:;" class="add_to_album_btn"></a>
				</li>
								</ul>
				<div class="favorite">
					<a href="javascript:;" class="favaImg">喜欢</a>
					<div class="favDiv">
				    <a target="_blank" class="favCount" href="/note/12f59bc">2050</a>
				    <i></i>
				    </div>
					<span class="creply_n">
					(
					<a href="/note/1287qyw" target="_blank">9</a>
					)
					</span>
					<a href="/note/1287qyw" target="_blank" class="creply">评论</a>
					</div>
			</div>
			<div class="who_share_s">
				<a target="_blank" href="/u/15tn7g">
					<img src="http://s9.mogujie.cn/b7/avatar/120129/2wtky_kqywumsmkrbfiq2ugfjeg5sckzsew_200x200.jpg_32x32.jpg" alt="璐璐wwl" class="icard avt fl r3">
				</a>
				<div class="share_info">
					<a href="/u/15tn7g" target="_blank" class="n icard">璐璐wwl</a>
					<p class="clr6">
					软绵绵珊瑚绒球球睡裙♥
					</p>
				</div>
			</div>
			<ul class="rep_list ">
				<li class="rep_f rep_pb">
					<a target="_blank" href="">
					<img src="http://s8.mogujie.cn/b7/avatar/120111/2mw1u_kqywcvk2krbfirkugfjeg5sckzsew_100x100.jpg_24x24.jpg" class="avt icard">
					</a>
					<p class="rep_content">
					<a target="_blank" href="/u/159s58" class="n icard gc">爱豆花的晓妍</a>
					: 不错不错~不错不错~不错不错~不错不错~不错不错~
					</p>
				</li>
				<li class="rep_f rep_pb clear">
					<a target="_blank" href="/u/159s58">
					<img src="http://s8.mogujie.cn/b7/avatar/120111/2mw1u_kqywcvk2krbfirkugfjeg5sckzsew_100x100.jpg_24x24.jpg" alt="爱豆花的晓妍" class="avt icard">
					</a>
					<p class="rep_content">
					<a target="_blank" href="/u/159s58" class="n icard gc">爱豆花的晓妍</a>
					: 不错不错~
					</p>
				</li>
				<div class="clear"></div>
			</ul>
			<div class="ws_ft"></div>
		</div>', '<div class="i_w_f box_shadow">
			<div class="hd"></div>
			<div class="bd">
				<ul class="pic">
								<li type="goods" style="width:200px;height:200px">
					<a target="_blank" href="#">
					<img src="http://s4.mogujie.cn/b7/bao/120120/2jd99_kqyw63kxkrbgu2cugfjeg5sckzsew_310x310.jpg_200x999.jpg">
					</a>
					<span class="p">¥68</span>
					<a style="display: none;" href="javascript:;" class="add_to_album_btn"></a>
				</li>
								</ul>
				<div class="favorite">
					<a href="javascript:;" class="favaImg">喜欢</a>
					<div class="favDiv">
				    <a target="_blank" class="favCount" href="/note/12f59bc">2050</a>
				    <i></i>
				    </div>
					<span class="creply_n">
					(
					<a href="/note/1287qyw" target="_blank">9</a>
					)
					</span>
					<a href="/note/1287qyw" target="_blank" class="creply">评论</a>
					</div>
			</div>
			<div class="who_share_s">
				<a target="_blank" href="/u/15tn7g">
					<img src="http://s9.mogujie.cn/b7/avatar/120129/2wtky_kqywumsmkrbfiq2ugfjeg5sckzsew_200x200.jpg_32x32.jpg" alt="璐璐wwl" class="icard avt fl r3">
				</a>
				<div class="share_info">
					<a href="/u/15tn7g" target="_blank" class="n icard">璐璐wwl</a>
					<p class="clr6">
					软绵绵珊瑚绒球球睡裙♥
					</p>
				</div>
			</div>
			<ul class="rep_list ">
				<li class="rep_f rep_pb">
					<a target="_blank" href="">
					<img src="http://s8.mogujie.cn/b7/avatar/120111/2mw1u_kqywcvk2krbfirkugfjeg5sckzsew_100x100.jpg_24x24.jpg" class="avt icard">
					</a>
					<p class="rep_content">
					<a target="_blank" href="/u/159s58" class="n icard gc">爱豆花的晓妍</a>
					: 不错不错~不错不错~不错不错~不错不错~不错不错~
					</p>
				</li>
				<li class="rep_f rep_pb clear">
					<a target="_blank" href="/u/159s58">
					<img src="http://s8.mogujie.cn/b7/avatar/120111/2mw1u_kqywcvk2krbfirkugfjeg5sckzsew_100x100.jpg_24x24.jpg" alt="爱豆花的晓妍" class="avt icard">
					</a>
					<p class="rep_content">
					<a target="_blank" href="/u/159s58" class="n icard gc">爱豆花的晓妍</a>
					: 不错不错~
					</p>
				</li>
				<div class="clear"></div>
			</ul>
			<div class="ws_ft"></div>
		</div>');
        if($frame == 8)
        {
           $data['pagerHtml'] = 1;
        }
        $data['error'] = 0;
        $data['frame'] = $frame+1;
        
        echo json_encode($data);
        exit;
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