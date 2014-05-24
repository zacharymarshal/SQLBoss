<?php

App::uses('AppHelper', 'View/Helper');

use Assetrinc\AssetService;

class AssetrincHelper extends AppHelper
{
    protected static $asset_service;

    public static function getAssetService()
    {
        if (!isset(self::$asset_service)) {
            self::$asset_service = new AssetService(
                array(
                    'sqlboss'          => __DIR__ . '/../../webroot/media/sqlboss',
                    'bower_components' => __DIR__ . '/../../webroot/media/bower_components',
                    'list'             => __DIR__ . '/../../webroot/media/list',
                    'rainbow'          => __DIR__ . '/../../webroot/media/rainbow',
                ),
                Router::url('/assets', true),
                array('debug' => Configure::read('debug') > 0)
            );
        }

        return self::$asset_service;
    }

    public function js($file)
    {
        return $this->_View->append('script', self::getAssetService()->jsTag($file));
    }

    public function css($file)
    {
        return $this->_View->append('css', self::getAssetService()->cssTag($file));
    }
}
