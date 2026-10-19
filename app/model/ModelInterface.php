<?php
interface ModelInterface
{
    public static function find($id);
    public static function all($filter = null);
    public function save();
    public static function delete($id);
}