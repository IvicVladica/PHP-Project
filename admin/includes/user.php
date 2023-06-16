<?php

class User extends Db_object {

    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'user_image');
    public $id;
    public $password;
    public $username;
    public $first_name;
    public $last_name;
    public $user_image;
    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/400x400&text=image"; 

    public $type;
    public $size;
    public $tmp_path;
    public $errors = array();
    public $upload_errors = array(

    UPLOAD_ERR_OK          => "There is no error",
    UPLOAD_ERR_INI_SIZE    => "The uploaded file exceeds the upload_max_filesize directive",
    UPLOAD_ERR_FORM_SIZE   => "The uploaded file exceeds the max_file_size directive",
    UPLOAD_ERR_PARTIAL     => "The upload file was only partialy uploaded",
    UPLOAD_ERR_NO_FILE     => "No file was uploaded",
    UPLOAD_ERR_NO_TMP_DIR  => "Missing a temporary folder",
    UPLOAD_ERR_CANT_WRITE  => "Failed to write file to disk",
    UPLOAD_ERR_EXTENSION   => "A PHP extension stopped the file upload"

);

    public function upload_photo() {

        
            if(!empty($this->errors)) {
                return false;
            } 
            if (empty($this->user_image) || empty($this->tmp_path)) {
                $this->errors[] = "The file was not available";
                return false;
            }

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->user_image} already exists";
                return false;
            }

            if(move_uploaded_file($this->tmp_path, $target_path)) {
                
                    unset ($this->tmp_path);
                    return true;

            } else {
                $this->errors[] = "The file directory probably does not have permission";
                return false;
            }

        
    }

    public function picture_path() {

        return $this->upload_directory.DS.$this->user_image;
    } 


public function image_path_and_placeholder() {
    return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory.DS.$this->user_image;
}


public static function verify_user($username, $password) {
    global $database;

    $username = $database->escape_string($username);
    $password = $database->escape_string($password);

    $sql = "SELECT * FROM " . self::$db_table . " WHERE ";
    $sql .= "username = '{$username}' ";
    $sql .= "AND password = '{$password}' ";
    $sql .= "LIMIT 1";

    $the_result_array = self::find_by_query($sql);

    return !empty($the_result_array) ? array_shift($the_result_array) : false; 
    
}


public function ajax_save_user_image($user_image, $user_id) {

    global $database;

    $user_image = $database->escape_string($user_image);
    $user_id = $database->escape_string($user_id);

    $this->user_image = $user_image;
    $this->id = $user_id;

    $sql = "UPDATE " . self::$db_table . " SET user_image = '{$this->user_image}' ";
    $sql .= " WHERE id = '{$this->id}'";
    $update_image = $database->query($sql);

}


}  // end of User class


?>