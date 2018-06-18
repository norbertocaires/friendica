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

function competencie_init(App $a) {

	if($a->argc > 1)
		DFRN::autoRedir($a, $a->argv[1]);

	if((Config::get('system','block_public')) && (! local_user()) && (! remote_user())) {
		return;
	}

	Nav::setSelected('home');

	$o = '';

	if($a->argc > 1) {
		$nick = $a->argv[1];
		$user = q("SELECT * FROM `user` WHERE `nickname` = '%s' AND `blocked` = 0 LIMIT 1",
			dbesc($nick)
		);

		if(! count($user))
			return;

		$a->data['user'] = $user[0];
		$a->profile_uid = $user[0]['uid'];

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

function competencie_post(App $a) {
	if (! local_user()) {
		notice(L10n::t('Permission denied.') . EOL);
		return;
	}
        
        $r = q("DELETE FROM `competency` WHERE `competency`.`id` = %d",
                $a->argv[2]
                );
    
        if ($r) {
            info(L10n::t('Competencia deletada.') . EOL);
            $redirect = System::baseUrl() . '/competencie/' . $a->data['user']['nickname'];
            header("location:$redirect");
            exit();
        }else{
            info(L10n::t("erro") . EOL);
        }
}

function competencie_content(App $a) {

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
        
       	$r = q("SELECT `id`, `uid`, `name`, `statement`, `idnumber`, `autonomy`, `frequency`, `familiarity`, `scope`, `complexity` FROM `competency`  WHERE `uid` = %d",
		intval($a->data['user']['uid'])
	);

        $competencies = [];
       	if (DBM::is_result($r)) {
            foreach ($r as $rr) {
    		$competencies[] = [
			'id'          => $rr['id'],
			
                        'name'        => $rr['name'],
			'statement'   => $rr['statement'],
                    
                        'idnumber'    => $rr['idnumber'],
                        'autonomy'    => $rr['autonomy'],
                        'frequency'   => $rr['frequency'],
                        'familiarity' => $rr['familiarity'],
                        'scope'       => $rr['scope'],
                        'complexity'  => $rr['complexity'],
                    
                        'edit'        => 'update_competencie/' . $a->data['user']['nickname'] .'/'.$rr['id'],
                        'del'         => 'competencie/'. $a->data['user']['nickname'] .'/'.$rr['id'] 
		];
            }
	}
        

	$o = "";

	// tabs
	$_is_owner = (local_user() && (local_user() == $owner_uid));
	$o .= Profile::getTabs($a, $_is_owner, $a->data['user']['nickname']);
        
        $tpl = get_markup_template('competencies.tpl');
	$o .= replace_macros($tpl, [
		'$title'       => L10n::t('Competencias'),
		'$edit'        => 'Editar competencia',
                '$del'         => 'Deletar',
                '$add'         => 'Adicionar competencia',
                '$addLink'     => System::baseUrl().'/add_competencie/'. $a->data['user']['nickname'],
		'$upload'      => [L10n::t('Upload New Videos'), System::baseUrl().'/videos/'.$a->data['user']['nickname'].'/upload'],
		'$competencies'=> $competencies,
	]);
        
	$o .= paginate($a);
	return $o;
}
