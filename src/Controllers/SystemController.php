<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;

class SystemController extends Controller
{
      public function css() {
          $content = view('visual::basic.build',[
            'files'=>$this->get_files('css')
        ]);
        return response($content)->header('Content-Type','text/css');        
    }
    
    public function js() {
        $content = view('visual::basic.build',[
            'files'=>$this->get_files('js')
        ]);
        return response($content)->header('Content-Type','text/javascript');
    }
    
    protected function get_files(string $dir) {
        $result = [];
        $this->composeDir($result, dirname(__FILE__).'/../../resources/'.$dir); // First the defaults
        $this->composeDir($result, base_path('/resources/'.$dir));           // Implementation overrides defaults 
        return $result;
    }
      
    protected function composeDir(array &$result, string $effective_dir)
    {
        $files = [];
        if (!file_exists($effective_dir)) {
              return;
        }
        $d = dir($effective_dir);
        while (false !== ($entry = $d->read())) {
            if (is_file($effective_dir.'/'.$entry)) {
                $files[] = $effective_dir.'/'.$entry;
            }
        }
        $d->close(); 
        sort($files);
        foreach ($files as $file) {
            $result[] = Blade::render(file_get_contents($file));
        }
    }
      
}
