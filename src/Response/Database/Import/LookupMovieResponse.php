<?php

namespace Sunhill\Visual\Response\Database\Import;

use Sunhill\Visual\Response\SunhillBladeResponse;
use Sunhill\ORM\Facades\Classes;
use Illuminate\Support\Facades\DB;

class LookupMovieResponse extends SunhillBladeResponse
{
    
    protected $template = 'visual::import.lookupmovie';
    
    protected $id = 0;
    
    public function setID(int $id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function prepareResponse()
    {
        parent::prepareResponse();
        
        $result = DB::table('import_movies')->where('id',$this->id)->first();
        
        $search = new \Imdb\TitleSearch(); // Optional $config parameter
        $results = $search->search($result->title, array(\Imdb\TitleSearch::MOVIE)); // Optional second parameter restricts types returned
        
    }
}  
