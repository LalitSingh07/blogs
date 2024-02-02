<?php
function query(string $query,array $data=[]){
    try {
        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $stm = $con->prepare($query);
        $stm->execute($data);

        return $stm->fetchAll(PDO::FETCH_ASSOC);  // Return results directly
    } catch (PDOException $e) {
        throw new Exception("Database query failed: " . $e->getMessage());  // Re-throw exception for handling elsewhere
    }
}
function query_row(string $query,array $data=[])
{
    try {
        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $stm = $con->prepare($query);
        $stm->execute($data);

        return $stm->fetch(PDO::FETCH_ASSOC);  
    } catch (PDOException $e) {
        throw new Exception("Database query failed: " . $e->getMessage());  // Re-throw exception for handling elsewhere
    }
}

function redirect($page) {
    header('Location:'.ROOT.'/'.$page);
    exit;  
}
function oldvalue($key,$default='') {
    if (!empty($_POST[$key])) { 
        return $_POST[$key]; 
    }
    else{
        return $default;
    }

}
function add_root_to_images($content)
{

	preg_match_all("/<img[^>]+/", $content, $matches);

	if(is_array($matches[0]) && count($matches[0]) > 0)
	{
		foreach ($matches[0] as $img) {

			preg_match('/src="[^"]+/', $img, $match);
			$new_img = str_replace('src="', 'src="'.ROOT."/", $img);
			$content = str_replace($img, $new_img, $content);

		}
	}
	return $content;
}

function remove_root_from_content($content)
{
	
	$content = str_replace(ROOT, "", $content);

	return $content;
}
function authenticate($row){
    $_SESSION['user']= $row;
}

function loggedin(){
    if(!empty($_SESSION['user']))
        return true;
    return false;
}
function remove_images_from_content($content, $folder = 'uploads/')
{

	preg_match_all("/<img[^>]+/", $content, $matches);

	if(is_array($matches[0]) && count($matches[0]) > 0)
	{
		foreach ($matches[0] as $img) {

			if(!strstr($img, "data:"))
			{
				continue;
			}

			preg_match('/src="[^"]+/', $img, $match);
			$parts = explode("base64,", $match[0]);

			preg_match('/data-filename="[^"]+/', $img, $file_match);

			$filename = $folder.str_replace('data-filename="', "", $file_match[0]);

			file_put_contents($filename, base64_decode($parts[1]));
			$content = str_replace($match[0], 'src="'.$filename, $content);
			

		}
	}
	return $content;
}
function user($key = '')
{
	if(empty($key))
		return $_SESSION['user'];

	if(!empty($_SESSION['user'][$key])) 
		return $_SESSION['user'][$key];

	return '';
}

function str_to_url($url){
$url = str_replace("'", "", $url);
$url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
$url = trim($url, "-");
$url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
$url = strtolower($url);
$url = preg_replace('~[^-a-z0-9_]+~', '', $url);
return $url;
}

function esc($str) {
    return htmlspecialchars($str);
}
function getimage($file){
    $file = $file ?? '';
    if (file_exists($file)) {
        return ROOT . '/' . $file;
    }
    return ROOT . '/assets/images/default.png';
}

function getpagevars(){

    //set pagination vars
$pagenumber = $_GET['page'] ?? 1;
$pagenumber= empty($pagenumber) ? 1 : $pagenumber;
$pagenumber= $pagenumber < 1 ? 1 : $pagenumber;

$currentlink = $_GET['url'] ?? 'home';
$currentlink =ROOT . "/" . $currentlink;
$querystring ="";
foreach($_GET as $key=>$value){
    if($key != 'url'){
        $querystring .= "&".$key."=".$value;
    }
}
if(!strstr($querystring,"page")){
    $querystring.="&page=".$pagenumber;
}

$querystring=trim($querystring,"&");
$currentlink.="?". $querystring;

$currentlink = preg_replace("/page=.*/","page=".$pagenumber,$currentlink);

$nextlink = preg_replace("/page=.*/","page=".($pagenumber+1),$currentlink);

$firstlink = preg_replace("/page=.*/","page=1",$currentlink);

$prevpagenumber = $pagenumber<2 ? 1 : $pagenumber-1;  

$prevlink = preg_replace("/page=.*/","page=".$prevpagenumber,$currentlink);

$result=['currentlink'=>$currentlink,'nextlink'=>$nextlink,'firstlink'=>$firstlink,'prevlink'=>$prevlink,'pagenumber'=>$pagenumber];
return $result;

}
function old_select($key, $value, $default = '')
{
	if(!empty($_POST[$key]) && $_POST[$key] == $value)
		return " selected ";
	
	if($default == $value)
		return " selected ";
	
	return "";
}

function createtable(){
try{
    $string = "mysql:host=".DBHOST.";";
    $con = new PDO($string , DBUSER, DBPASS); 
    $query = "CREATE DATABASE IF NOT EXISTS " .DBNAME;
    $stm = $con->prepare($query);
    $stm-> execute();

    $query = "USE " .DBNAME;
    $stm = $con->prepare($query);
    $stm-> execute();

    $query = "CREATE TABLE IF NOT EXISTS users (
        id int primary key auto_increment,
        username varchar(50) not null,
        email varchar(150) not null,
        password varchar(250) not null,
        image varchar(1050) null,
        date datetime default current_timestamp,
        role varchar(10) not null,
        key username (username),
        key email (email)
    )";
    $stm = $con->prepare($query);
    $stm->execute();

    $query = "CREATE TABLE IF NOT EXISTS posts (
        id int primary key auto_increment,
        user_id int,
        category_id int,
        title varchar(100) not null,
        content text null,
        image varchar(1050) null,
        date datetime default current_timestamp,
        slug varchar(100) not null,
        
        key user_id (user_id),
        key category_id (category_id),
        key title (title),
        key slug (slug),
        key date (date)
        
    )";
    $stm = $con->prepare($query);
    $stm->execute();

    $query = "CREATE TABLE IF NOT EXISTS categories (
        id int primary key auto_increment,
        category varchar(50) not null,
        slug varchar(100) not null,
        disabled tinyint default 0,
        
        key slug (slug),
        key category (category)
    )";
    $stm = $con->prepare($query);
    $stm->execute();



}catch (PDOException $e){
        echo "" . $e->getMessage(); 
    }

}
// createtable();

function resize_image($filename, $max_size = 1000)
{
	
	if(file_exists($filename))
	{
		$type = mime_content_type($filename);
		switch ($type) {
			case 'image/jpeg':
				$image = imagecreatefromjpeg($filename);
				break;
			case 'image/png':
				$image = imagecreatefrompng($filename);
				break;
			case 'image/gif':
				$image = imagecreatefromgif($filename);
				break;
			case 'image/webp':
				$image = imagecreatefromwebp($filename);
				break;
			default:
				return;
				break;
		}

		$src_width 	= imagesx($image);
		$src_height = imagesy($image);

		if($src_width > $src_height)
		{
			if($src_width < $max_size)
			{
				$max_size = $src_width;
			}

			$dst_width 	= $max_size;
			$dst_height = ($src_height / $src_width) * $max_size;
		}else{
			
			if($src_height < $max_size)
			{
				$max_size = $src_height;
			}

			$dst_height = $max_size;
			$dst_width 	= ($src_width / $src_height) * $max_size;
		}

		$dst_height = round($dst_height);
		$dst_width 	= round($dst_width);

		$dst_image = imagecreatetruecolor($dst_width, $dst_height);
		imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
		
		switch ($type) {
			case 'image/jpeg':
				imagejpeg($dst_image, $filename, 90);
				break;
			case 'image/png':
				imagepng($dst_image, $filename, 90);
				break;
			case 'image/gif':
				imagegif($dst_image, $filename, 90);
				break;
			case 'image/webp':
				imagewebp($dst_image, $filename, 90);
				break;

		}

	}
}

?>