<?php
/**
 * @file mod/competencie.php
 */

use Friendica\App;
use Friendica\Content\Nav;
use Friendica\Core\Config;
use Friendica\Core\L10n;
use Friendica\Core\System;
use Friendica\Core\Worker;
use Friendica\Database\DBM;
use Friendica\Model\Contact;
use Friendica\Model\Group;
use Friendica\Model\Item;
use Friendica\Model\Profile;
use Friendica\Model\Term;
use Friendica\Protocol\DFRN;
use Friendica\Util\DateTimeFormat;

require_once 'include/items.php';
require_once 'include/security.php';

function update_competencie_init(App $a) {

	if($a->argc > 1)
		DFRN::autoRedir($a, $a->argv[1]);

	if((Config::get('system','block_public')) && (! local_user()) && (! remote_user())) {
		return;
	}

	Nav::setSelected('home');

	$o = '';

	if($a->argc > 2) {
		$nick = $a->argv[1];
                $competencieId = $a->argv[2];
                
		$user = q("SELECT * FROM `user` WHERE `nickname` = '%s' AND `blocked` = 0 LIMIT 1",
			dbesc($nick)
		);

		if(! count($user))
			return;

		$a->data['user'] = $user[0];
		$a->profile_uid = $user[0]['uid'];
                $a->competencieId = $competencieId;

		$profile = Profile::getByNickname($nick, $a->profile_uid);

		$account_type = Contact::getAccountType($profile);

		$tpl = get_markup_template("vcard-widget.tpl");

		$vcard_widget = replace_macros($tpl, [
			'$name' => $profile['name'],
			'$photo' => $profile['photo'],
			'$addr' => defaults($profile, 'addr', ''),
			'$account_type' => $account_type,
			'$pdesc' => defaults($profile, 'pdesc', ''),
		]);
                
                

		if(! x($a->page,'aside'))
			$a->page['aside'] = '';
		$a->page['aside'] .= $vcard_widget;

		$tpl = get_markup_template("videos_head.tpl");
		$a->page['htmlhead'] .= replace_macros($tpl,[
			'$baseurl' => System::baseUrl(),
		]);

		$tpl = get_markup_template("videos_end.tpl");
		$a->page['end'] .= replace_macros($tpl,[
			'$baseurl' => System::baseUrl(),
		]);

	}

	return;
}

function update_competencie_post(App $a) {

	if (! local_user()) {
		notice(L10n::t('Permission denied.') . EOL);
		return;
	}

        $r = q("SELECT `id`, `uid`, `competencyId` FROM `competency`  WHERE `id` = %d",
			intval($a->competencieId)
		);

	include_once("/opt/lampp/htdocs/arc2-starter-pack/arc/ARC2.php");
	include_once('/opt/lampp/htdocs/arc2-starter-pack/config.php');
	$store = ARC2::getStore($arc_config); 
	$q = '
		SELECT DISTINCT ?subject ?property ?object WHERE { 
		?subject ?property ?object .
		}
	';
	$t = '';
	$rows = $store->query($q, 'rows');

	$name = '';
	$statement = '';
	if ($rows) {
		foreach ($rows as $row) {
			if(strpos($row['subject'], "#Competency_" . $r[0]['competencyId'])){
				$query = 'DELETE { <' . $row['subject'] . '> <' . $row['property'] . '> "' . $row['object'] . '" . }';
				$store->query($query);
			}
		}
	} else{
		return;
	}

	$queryName = 'INSERT INTO <file:///home/norberto/teste.owl> CONSTRUCT {
			<http://www.professional-learning.eu/ontologies/competence.owl#Competency_' . $r[0]['competencyId'] . '> 
			<http://www.w3.org/2000/01/rdf-schema#name> "' . 
			trim($_POST['competencie_name']) . 
			'" . }';
	$store->query($queryName);

	$queryStatement = 'INSERT INTO <file:///home/norberto/teste.owl> CONSTRUCT {
				<http://www.professional-learning.eu/ontologies/competence.owl#Competency_' . $r[0]['competencyId'] . '> 
				<http://www.w3.org/2000/01/rdf-schema#statement> "' . 
				trim($_POST['competencie_statement']) . 
				'" . }';
	$store->query($queryStatement);
        

        if ($r) {
            info(L10n::t('Competencia atualizada.') . EOL);
            $redirect = System::baseUrl() . '/competencie/' . $a->data['user']['nickname'];
            header("location:$redirect");
            exit();
        }else{
            info(L10n::t("erro") . EOL);
        }
}


function update_competencie_content(App $a) {

	if((Config::get('system','block_public')) && (! local_user()) && (! remote_user())) {
		notice(L10n::t('Public access denied.') . EOL);
		return;
	}

	require_once('include/security.php');
	require_once('include/conversation.php');

	if(! x($a->data,'user')) {
		notice(L10n::t('No competencie selected') . EOL );
		return;
	}

        
        $r = q("SELECT `id`, `uid`, `competencyId` FROM `competency`  WHERE `id` = %d",
			intval($a->competencieId)
		);

	include_once("/opt/lampp/htdocs/arc2-starter-pack/arc/ARC2.php");
	include_once('/opt/lampp/htdocs/arc2-starter-pack/config.php');
	$store = ARC2::getStore($arc_config); 
	$q = '
		SELECT DISTINCT ?subject ?property ?object WHERE { 
		?subject ?property ?object .
		}
	';
	$t = '';
	$rows = $store->query($q, 'rows');

	$name = '';
	$statement = '';
	if ($rows) {
		foreach ($rows as $row) {
			if(strpos($row['subject'], "#Competency_" . $r[0]['competencyId'])){
				if(strpos($row['property'], "#name")){
					$name = $row['object'];
				}
				if(strpos($row['property'], "#statement")){
					$statement = $row['object'];
				}
			}
		}
	} else{
		return;
	}

        $competencie = '';        
       	if (DBM::is_result($r)) {
            $competencie = [
		'id'          => $r[0]['id'],
	        
                'name'        => $name,
		'statement'   => $statement,
                    
                'edit'        => 'update_competencie/' . $a->data['user']['nickname'] .'/'.$r[0]['id'],
		
            ];
	}


	$o = "";

        
        $tpl = get_markup_template('competencie_fields.tpl');
	$o .= replace_macros($tpl, [
		'$title'       => L10n::t('Editar competencia'),
		'$save'        => 'Salvar Competencia',
                '$saveLink'    => System::baseUrl(). '/competencie/' . $a->data['user']['nickname'],
                '$competencie' => $competencie,
            
                '$action'      => 'update_competencie',
                '$nick'        =>  $a->data['user']['nickname'] . '/' . $a->competencieId,
            
		'$upload'      => [L10n::t('Upload New Videosstem::baseUrl().'), System::baseUrl().'/videos/'.$a->data['user']['nickname'].'/upload'],
		'$delete_url'  => (($can_post)?System::baseUrl().'/videos/'.$a->data['user']['nickname']:False)
	]);
        
	$o .= paginate($a);
	return $o;
}


