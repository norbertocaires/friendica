<?php
/**
 * @file mod/dirfind.php
 */
use Friendica\App;
use Friendica\Core\L10n;

function competenciefind_init(App $a) {

	if (! local_user()) {
		notice(L10n::t('Permission denied.') . EOL );
		return;
	}
}

function competenciefind_content(App $a, $search) {
        
        $r = q("SELECT `id`, `uid`, `competencyId` FROM `competency` ");

	include_once("/opt/lampp/htdocs/arc2-starter-pack/arc/ARC2.php");
	include_once('/opt/lampp/htdocs/arc2-starter-pack/config.php');
	$store = ARC2::getStore($arc_config); 
	$q = '
		SELECT DISTINCT ?subject ?property ?object WHERE { 
		?subject ?property ?object .
		}
	';

	$rows = $store->query($q, 'rows');
        
      	$o = '';

        $competencies = [];
       	if ($r) {
            foreach ($r as $rr) {
		$name = '';
		$statement = '';
		foreach($rows as $owl){
			if(strpos($owl['subject'], "#Competency_".$rr['competencyId'])){
				if(strpos($owl['property'], "#name")){
					$name = $owl['object'];
				}
			}
			if(strpos($owl['subject'], "#Competency_".$rr['competencyId'])){
				if(strpos($owl['property'], "#statement")){
					$statement = $owl['object'];
				}
			}
		}
                
                if(strpos($name, $search) > -1 || strpos($statement, $search) > -1){
                    $competencies[] = [
                            'uid'          => $rr['uid'],

                            'name'        => $name,
                            'statement'   => $statement,
                    ];
                }
            }
	}
        
        if ($competencies){
                $entries = [];
                foreach ($competencies as $com){
            		$user = q("SELECT `username`, `nickname` FROM `user` WHERE `uid` = '%d' AND `blocked` = 0 LIMIT 1",
                            $com['uid']
                        );
                        $entries[] = [
                            //user
                            'username' => $user[0]['username'],
                            'linkProfile' => 'profile/'. $user[0]['nickname'],
                            //competencie
                            'name'      => $com['name'],
                            'statement' => $com['statement']                            
                        ];                
                }
                $tpl = get_markup_template('search_competecies_template.tpl');
      		$o .= replace_macros($tpl,[
			'title' => "Competencias encontradas",
			'$competencies' => $entries,
		]); 
 
        } else{
     		$tpl = get_markup_template('search_competecies_template.tpl');
      		$o .= replace_macros($tpl,[
			'title' => "Nenhum resultado",
			'$contacts' => []
		]); 
                info(L10n::t('No matches') . EOL);    
        }
        
	return $o;
}
