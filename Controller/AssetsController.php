<?php

use Assetrinc\AssetService;

class AssetsController extends AppController
{
    public function index()
    {
        $asset_service = new AssetService(
            array(
                'app' => __DIR__ . '/../webroot/media/sqlboss'
            ),
            Router::url('/assets', true),
            array('debug' => true)
        );
        $name = implode('/', func_get_args());
        $this->response->header(array(
            "Content-Type: {$asset_service->getContentType($name)}"
        ));
        $this->response->modified($asset_service->getLastModified($name));
        if ($this->response->checkNotModified($this->request)) {
            return $this->response;
        }
        $this->response->body($asset_service->getContent($name));

        return $this->response;
    }

}
