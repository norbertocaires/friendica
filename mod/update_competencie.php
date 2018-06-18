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
        
        $r = q("UPDATE `competency` SET `name` = '%s', `statement` = '%s', `idnumber` = '%s', `autonomy` = '%f', `frequency` = '%f', `familiarity` = '%f', `scope` = '%f', `complexity` = '%s' WHERE `competency`.`id` = %d",
      		dbesc(trim($_POST['competencie_name'])),
		dbesc(trim($_POST['competencie_statement'])),
		dbesc(trim($_POST['competencie_idnumber'])),
                $_POST['autonomy'] === 'true',
		$_POST['frequency'] === 'true',
		$_POST['familiarity'] === 'true',
		$_POST['scope'] === 'true',
                dbesc(trim($_POST['complexity'])),
                intval($a->competencieId)
        );
        

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

        
        $r = q("SELECT `id`, `uid`, `name`, `statement`, `idnumber`, `autonomy`, `frequency`, `familiarity`, `scope`, `complexity` FROM `competency`  WHERE `id` = %d",
			intval($a->competencieId)
		);



        $competencie = '';        
       	if (DBM::is_result($r)) {
            $competencie = [
		'id'          => $r[0]['id'],
	        
                'name'        => $r[0]['name'],
		'statement'   => $r[0]['statement'],
                    
                'idnumber'    => $r[0]['idnumber'],
                'autonomy'    => $r[0]['autonomy'],
                'frequency'   => $r[0]['frequency'],
                'familiarity' => $r[0]['familiarity'],
                'scope'       => $r[0]['scope'],
                'complexity'  => $r[0]['complexity'],
                    
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


