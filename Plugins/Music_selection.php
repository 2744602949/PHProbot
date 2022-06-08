<?php
use PHProbot\Module\Api;

/**
*@comment 选歌
*@return image
*/
class Music_selection{
use Api;
function plugins_Music_selection(){
if (preg_match("/^[0-9]+$/u", $this->msg, $return_list)){
$qq=$this->qq;
if (is_file($qq."song_list.txt")==true){

$song=file_get_contents($qq."song.txt");
$data_one = explode("#",$song);
$data1 = $data_one[0];
if ($data1 == "语音"){
$data2 = $data_one[1];
$url="https://autumnfish.cn/search?keywords=".urlencode($data2);
$song_data=json_decode(file_get_contents($url),true);
$result=$song_data['result'];
$song_list=$result['songs'];//歌曲列表
$list_data=$song_list[$return_list[0]-1];//选歌
$song_id = $list_data["id"];
$url = "http://music.163.com/song/media/outer/url?id=".$song_id.".mp3";
$url_data = file_get_contents($url);
file_put_contents("../gocq/data/voices/".$song_id.".mp3",$url_data);

return $this->send("[CQ:record,file=".$song_id.".mp3]");
unlink($qq."song_list.txt");
}else{
$song=file_get_contents($qq."song.txt");
$data_one = explode("#",$song);
$data1 = $data_one[0];
$data2 = $data_one[1];

$url="https://autumnfish.cn/search?keywords=".urlencode($data2);
$song_data=json_decode(file_get_contents($url),true);
$result=$song_data['result'];
$song_list=$result['songs'];//歌曲列表
$list_data=$song_list[$return_list[0]-1];//选歌
$song_id = $list_data["id"];
return $this->send("[CQ:music,type=163,id=".$song_id."]");

unlink($qq."song_list.txt");

unlink($qq."song.txt");

}
}

}
}
}
?>