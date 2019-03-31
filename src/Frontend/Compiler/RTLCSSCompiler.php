<?php

namespace PersianFla\RTL\Frontend\Compiler;

use Flarum\Frontend\Compiler\RevisionCompiler;
use Flarum\Frontend\Compiler\Source\FileSource;

class RTLCSSCompiler extends RevisionCompiler
{
    /**
     * @var string
     */
    protected $oldFileName;

    protected function compile(): string
    {
      $parser = new \Sabberworm\CSS\Parser($this->assetsDir->read($this->oldFileName));
      $tree = $parser->parse();
      $rtlcss = new RTLCSS($tree);
      $rtlcss->flip();
      return $tree->render();
    }

    /**
     * @return mixed
     */
    protected function getCacheDifferentiator()
    {
        return time();
    }

    /**
     * @param string $oldFileName
     */
    public function setOldFileName(string $oldFileName)
    {
        $this->oldFileName = $oldFileName;
    }
}
