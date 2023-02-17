<?php

namespace Sunhill\Visual\Response\Database\Import;

use Sunhill\Visual\Response\SunhillListResponse;
use Sunhill\ORM\Facades\Classes;
use Sunhill\Visual\Facades\SunhillSiteManager;
use Illuminate\Support\Facades\DB;

class ListMoviesImportResponse extends SunhillListResponse
{
    
    protected $template = 'visual::import.listmovies';
    
    protected function prepareHeaders(): array 
    {
        $this->params['headers'] = [
            $this->getStdClass(['name'=>__('ID'),'link'=>null]),
            $this->getStdClass(['name'=>__('Movie name'),'link'=>null]),
            $this->getStdClass(['name'=>__('IMDB-ID'),'link'=>null]),
            $this->getStdClass(['name'=>__('Imported'),'link'=>null]),
            $this->getStdClass(['name'=>"",'link'=>null]),
            $this->getStdClass(['name'=>"",'link'=>null]),
            $this->getStdClass(['name'=>"",'link'=>null]),
            $this->getStdClass(['name'=>"",'link'=>null]),
        ];
        return $this->params['headers'];
    }
    
    protected function prepareList($key,$order,$delta,$limit)
    {
        return DB::table('import_movies')->offset($delta*self::ENTRIES_PER_PAGE)->limit(self::ENTRIES_PER_PAGE)->get(['id','title','imdb_id','object_id']);
    }

    protected function getPrefix()
    {
        return SunhillSiteManager::getPrefix();    
    }
    
    protected function prepareMatrix($input): array
    {
        $result = [];        
        foreach ($input as $name => $description)
        {
            $row = [];
            $row[] = $this->getStdClass(['name'=>$description->id,'link'=>null]);
            $row[] = $this->getStdClass(['name'=>$description->title,'link'=>null]);
            $row[] = $this->getStdClass(['name'=>$description->imdb_id,'link'=>null]);
            $row[] = $this->getStdClass(['name'=>($description->object_id > 0)?__('yes'):__('no'),'link'=>null]);
            
            $row[] = $this->getStdClass(['name'=>__('lookup'),'link'=>SunhillSiteManager::getCurrentFeaturePath().'/LookupMovie/'.$description->id]);
            $row[] = $this->getStdClass(['name'=>__('import'),'link'=>SunhillSiteManager::getCurrentFeaturePath().'/ImportMovie/'.$description->id]);
            $row[] = $this->getStdClass(['name'=>__('edit'),'link'=>SunhillSiteManager::getCurrentFeaturePath().'/EditMovie/'.$description->id]);
            $row[] = $this->getStdClass(['name'=>__('delete'),'link'=>SunhillSiteManager::getCurrentFeaturePath().'/DeleteMovie/'.$description->id]);
            $result[] = $row;
        }
        return $result;        
    }
    
    protected function getTotalEntryCount()
    {
        return DB::table('import_movies')->count();
    }
    
    
    protected function getPaginatorLink(int $index)
    {
        return SunhillSiteManager::getCurrentFeaturePath().'/ListMovies/'.$index;
    }
    
}  
