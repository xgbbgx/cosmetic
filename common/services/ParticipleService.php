<?php
namespace common\services;

class ParticipleService{
    
    public static function getColumn(){
        
    }
    
    public static function ppl($content){
        return SpliteService::getPhpanalysisKeywords($content);
    }
}