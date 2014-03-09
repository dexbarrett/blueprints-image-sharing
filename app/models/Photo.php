<?php
class Photo extends Eloquent
{
    protected $fillable = array('title', 'image');

    public static $upload_rules = array(
        'title' => 'required|min:3',
        'image' => 'required|image'
    );
}