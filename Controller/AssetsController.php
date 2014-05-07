<?php

use Assetrinc\AssetService;

class AssetsController extends AppController
{
    public function index()
    {
        $asset_service = new AssetService(
            array(
                'sqlboss'          => __DIR__ . '/../webroot/media/sqlboss',
                'bower_components' => __DIR__ . '/../webroot/media/bower_components',
                'rainbow'          => __DIR__ . '/../webroot/media/rainbow',
            ),
            Router::url('/assets', true),
            array('debug' => true)
        );
        $name = implode('/', func_get_args());
        $content_type = $asset_service->getContentType($name);

        $this->response->type($content_type);
        $this->response->modified($asset_service->getLastModified($name));
        if ($this->response->checkNotModified($this->request)) {
            return $this->response;
        }
        $this->response->body($asset_service->getContent($name));

        return $this->response;
    }

}
