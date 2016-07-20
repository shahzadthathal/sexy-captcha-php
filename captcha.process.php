<?php
	include_once("session.php");
	$requestVars = isset($_REQUEST) ? $_REQUEST : array();
	if(isset($_REQUEST['captcha_name'])){
		$captcha_name = $_REQUEST['captcha_name']; 
	}
	$capDivID=isset($_GET['divID'])?$_GET['divID']:'captchaWrapper';
	switch($requestVars['action']) {
		case 'verify':
			if (substr($requestVars['captcha'], 10) == $_SESSION[$captcha_name.'_captchaCodes'][$_SESSION[$captcha_name.'_captchaAnswer']]) {
				echo json_encode(array('status' => 'success'));
			} else {
				$_SESSION[$captcha_name.'_captchaCodes'] = NULL;
				$_SESSION[$captcha_name.'_captchaAnswer'] = NULL;
				echo json_encode(array('status' => 'error'));
			}
			
			break;
		case 'refresh':
			$captchaImages = array(	array('label'=> 'star',
													'on'=> array('top'=> '-54px',
																'left'=> '0px'),
													'off'=> array('top'=> '-55px',
													'left'=> '-28px'),
											),
									array('label'=> 'heart',
											'on'=> array('top'=> '1px','left'=> '0px'),
													'off'=> array('top'	=> '0','left'=> '-28px'),
													),
									array('label'	=> 'bwm',
													'on'=> array('top'=> '-26px','left'=> '0px'),
													'off'=> array('top'=> '-26px','left'=> '-28px'),
													),
									array('label'=> 'diamond',
													'on'=> array('top'=> '-85px','left'=> '0px'),
													'off'	=> array('top'=> '-84px','left'=> '-28px'),
													)
													);

		$captchaCodes = array('star'=> md5(mt_rand(00000000, 99999999)), 
														'heart'=> md5(mt_rand(00000000, 99999999)), 
														'bwm' => md5(mt_rand(00000000, 99999999)), 
														'diamond' => md5(mt_rand(00000000, 99999999))
														);
		shuffle($captchaImages);
		$randomCaptcha = array_rand($captchaImages);
	
		$_SESSION[$captcha_name.'_captchaAnswer'] = $captchaImages[$randomCaptcha]['label'];
		$_SESSION[$captcha_name.'_captchaCodes'] = $captchaCodes;
		
		//HTML output
		echo '<div class="captchaWrapper" id="'.$capDivID.'">';
		foreach ($captchaImages as $count => $captchaImage) {
			echo '	<a href="#" class="captchaRefresh"></a>
							<div	id="draggable_' . $captchaCodes[$captchaImage['label']] . '" 
										class="draggable" 
										style="left: ' . (($count * 30) + 8) . 'px; background-position: ' . $captchaImage['on']['top'] . ' ' . $captchaImage['on']['left'] . ';"></div>';
		}

		echo '	<div class="targetWrapper">
					<div class="target" style="background-position: ' . $captchaImages[$randomCaptcha]['off']['top'] . ' ' . $captchaImages[$randomCaptcha]['off']['left'] . ';">
					</div>
				</div>
				<input name="'.$captcha_name.'" type="hidden" id="'.$captcha_name.'" class="captchaAnswer" value="" />
			</div>';
		
		break;
	}
