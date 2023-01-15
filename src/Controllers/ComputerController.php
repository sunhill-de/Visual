<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Sunhill\Visual\Facades\SiteManager;
use Sunhill\Objects\Objects\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ComputerController extends Controller
{

    public function index()
    {
        $params = SiteManager::getParameters(['/'=>'Sunhill']);
        $params['sitename'] = 'Sunhill';
        $params['class'] = 'FamilyMember';
        $params['page'] = 'Computer';
        
        return view('visual::computer.index',$params);        
    }
    
    public function ExecImportPersons(Request $request)
    {
        $entries = $this->params['entries'] = DB::table('import_persons')->limit(10)->get();        
        foreach ($entries as $entry) {
            if ($request->input('import'.$entry->id)) {
                $groups = [];
                if ($assoc = DB::table('person_movie_assoc')->where('person_id',$entry->id)->first()) {
                    $groups[] = $assoc->job;
                }
                $person = new Person();
                $person->firstname = $entry->first_names;
                $person->lastname = $entry->last_names;
                foreach ($groups as $group) {
                    $person->groups[] = $group;
                }
                $person->commit();
            }
        }
        return redirect('/Computer/Database/Import/persons');
    }
}
