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

function add_competencie_init(App $a) {

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

function add_competencie_post(App $a) {

	if (! local_user()) {
		notice(L10n::t('Permission denied.') . EOL);
		return;
	}
        
	info(L10n::t('Profile updated.') . EOL);
}


function add_competencie_content(App $a) {

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

        $competencies = '';

		$competencies = [
			'id'          => 0,
			'title'       => '',
			'description' => '',
			'album' => [
				'link'  => System::baseUrl() . '/videos/' . $a->data['user']['nickname'] . '/album/' . bin2hex($rr['album']),
				'name'  => $name_e,
				'alt'   => L10n::t('View Album'),
			],
		];
        

	$o = "";

        
        $tpl = get_markup_template('competencie_fields.tpl');
	$o .= replace_macros($tpl, [
		'$title'       => L10n::t('Adicionar competencia'),
		'$save'        => 'Salvar',
                '$saveLink'    => System::baseUrl(). '/competencie/' . $a->data['user']['nickname'],
                '$competencie' => $competencies[0],
		'$upload'      => [L10n::t('Upload New Videosstem::baseUrl().'), System::baseUrl().'/videos/'.$a->data['user']['nickname'].'/upload'],
		'$competencies'=> $competencies,
		'$delete_url'  => (($can_post)?System::baseUrl().'/videos/'.$a->data['user']['nickname']:False)
	]);
        
	$o .= paginate($a);
	return $o;
}




