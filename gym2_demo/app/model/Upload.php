<?php


class Upload
{
    public static $fileName='';

    public static function uploadPhoto()
    {
        if (!empty($_FILES['myfile']['name'])){
            $currentDir=getcwd();
            $uploadDirectory='/vendor/Users/';

            $fileExtensions=['jpeg','jpg','png'];

            $fileName=$_FILES['myfile']['name'];
            $fileSize=$_FILES['myfile']['size'];
            $fileTmpName =$_FILES['myfile']['tmp_name'];
            $fileType=$_FILES['myfile']['type'];
            $fileExtension=pathinfo($fileName, PATHINFO_EXTENSION);
            $fileName1=uniqid().".".$fileExtension;
            $uploadPath=$currentDir . $uploadDirectory .$fileName1;

            $didUpload=move_uploaded_file($fileTmpName, $uploadPath);
            self::$fileName=$fileName1;
        }else{
            self::$fileName='default.jpeg';
        }
    }

    public static function getFileName()
    {
        return self::$fileName;
    }
}