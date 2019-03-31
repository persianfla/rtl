<?php

namespace PersianFla\RTL\Frontend\Content;

use Flarum\Foundation\Application;
use Flarum\Frontend\Document;
use PersianFla\RTL\Frontend\Compiler\RTLCSSCompiler;
use Psr\Http\Message\ServerRequestInterface as Request;

class RTL
{
    protected $app;

    /**
     * @var Filesystem
     */
    protected $assetsDir;

    /**
     * @var \Flarum\Frontend\Assets
     */
    protected $assets;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->assets = $this->app->make('flarum.assets.forum');
        $this->assetsDir = $this->assets->getAssetsDir();
    }

    public function __invoke(Document $document, Request $request)
    {
      $oldFile = pathinfo($document->css[0]);
      $compiler = $this->makeRTLCSS($oldFile['basename']);

      if ($this->app->inDebugMode()) {
        $compiler->commit();
      }

      $document->css[0] = $compiler->getUrl();
      $document->direction = "rtl";
    }

    public function makeRTLCSS($oldFileName): RTLCSSCompiler
    {
        $compiler = new RTLCSSCompiler($this->assetsDir, 'forum.rtl.css');
        $compiler->setOldFileName($oldFileName);
        return $compiler;
    }

    /**
     * @return string|null
     */
    protected function getRevision(): ?string
    {
        if ($this->assetsDir->has(static::REV_MANIFEST)) {
            $manifest = json_decode($this->assetsDir->read(static::REV_MANIFEST), true);

            return array_get($manifest, $this->filename);
        }

        return null;
    }
}
